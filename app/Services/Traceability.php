<?php

namespace App\Services;

use App\Models\ManufacturingBatch;
use App\Models\ProductUnit;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class Traceability
{
    public function transition(ManufacturingBatch $batch, string $next, string $notes): void
    {
        DB::transaction(function () use ($batch, $next, $notes): void {
            $batch = ManufacturingBatch::whereKey($batch->id)->lockForUpdate()->firstOrFail();
            $allowed = ['draft' => ['quality_review'], 'quality_review' => ['released'], 'released' => []];
            if (! in_array($next, $allowed[$batch->status] ?? [], true)) {
                throw ValidationException::withMessages(['status' => 'Batch transition is not permitted.']);
            }
            if ($next === 'released' && $batch->expires_on && $batch->expires_on->isPast()) {
                throw ValidationException::withMessages(['status' => 'Expired batches cannot be released.']);
            }
            if ($next === 'released' && ! ProductUnit::where('manufacturing_batch_id', $batch->id)->exists()) {
                throw ValidationException::withMessages(['status' => 'Generate serialized units before releasing this batch.']);
            }
            $batch->update(['status' => $next, 'quality_notes' => $notes]);
            if ($next === 'released') {
                ProductUnit::where('manufacturing_batch_id', $batch->id)->where('status', 'created')->update(['status' => 'active']);
            }
            Audit::record('batch.transitioned', $batch, ['to' => $next, 'quality_notes' => $notes]);
        }, 3);
    }

    public function generate(ManufacturingBatch $batch, int $count): void
    {
        DB::transaction(function () use ($batch, $count): void {
            $batch = ManufacturingBatch::whereKey($batch->id)->lockForUpdate()->firstOrFail();
            if ($batch->status !== 'draft') {
                throw ValidationException::withMessages(['batch' => 'Units can only be generated in a draft batch.']);
            }
            for ($i = 0; $i < $count; $i++) {
                ProductUnit::create(['manufacturing_batch_id' => $batch->id, 'serial' => $batch->code.'-'.strtoupper(bin2hex(random_bytes(6))), 'verification_token' => bin2hex(random_bytes(32))]);
            }
            Audit::record('batch.units_generated', $batch, ['count' => $count]);
        }, 3);
    }
}
