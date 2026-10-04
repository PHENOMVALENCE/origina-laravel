<?php

namespace App\Http\Controllers;

use App\Models\ManufacturingBatch;
use App\Models\ProductUnit;
use App\Models\VerificationScan;
use App\Services\Audit;
use App\Services\Traceability;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TraceabilityController
{
    public function create(Request $request): RedirectResponse
    {
        $data = $request->validate(['product_id' => 'required|exists:products,id', 'code' => 'required|string|max:60|regex:/^[A-Z0-9-]+$/|unique:manufacturing_batches,code', 'manufactured_on' => 'required|date|before_or_equal:today', 'expires_on' => 'nullable|date|after:manufactured_on']);
        DB::transaction(function () use ($data): void {
            $batch = ManufacturingBatch::create($data);
            Audit::record('batch.created', $batch);
        });

        return back()->with('status', 'Manufacturing batch created.');
    }

    public function transition(Request $request, ManufacturingBatch $batch, Traceability $service): RedirectResponse
    {
        $data = $request->validate(['status' => 'required|in:quality_review,released', 'quality_notes' => 'required|string|min:20|max:5000']);
        $service->transition($batch, $data['status'], $data['quality_notes']);

        return back()->with('status', 'Batch updated.');
    }

    public function generate(Request $request, ManufacturingBatch $batch, Traceability $service): RedirectResponse
    {
        $data = $request->validate(['count' => 'required|integer|min:1|max:500']);
        $service->generate($batch, (int) $data['count']);

        return back()->with('status', 'Serialized units generated.');
    }

    public function revoke(ProductUnit $unit): RedirectResponse
    {
        DB::transaction(function () use ($unit): void {
            $unit = ProductUnit::whereKey($unit->id)->lockForUpdate()->firstOrFail();
            if ($unit->status === 'revoked') {
                throw ValidationException::withMessages(['unit' => 'This serialized unit is already revoked.']);
            }
            $from = $unit->status;
            $unit->update(['status' => 'revoked']);
            Audit::record('unit.revoked', $unit, ['from' => $from, 'to' => 'revoked']);
        }, 3);

        return back()->with('status', 'Unit revoked.');
    }

    public function export(ManufacturingBatch $batch): StreamedResponse
    {
        $exportableCount = ProductUnit::where('manufacturing_batch_id', $batch->id)->where('status', '!=', 'revoked')->count();
        if ($exportableCount === 0) {
            throw ValidationException::withMessages(['batch' => 'This batch has no printable serialized units.']);
        }

        Audit::record('batch.labels_exported', $batch, ['unit_count' => $exportableCount]);

        return response()->streamDownload(function () use ($batch): void {
            $stream = fopen('php://output', 'w');
            if ($stream === false) {
                return;
            }
            fputcsv($stream, ['serial', 'verification_url']);
            foreach (ProductUnit::where('manufacturing_batch_id', $batch->id)->where('status', '!=', 'revoked')->orderBy('id')->cursor() as $unit) {
                fputcsv($stream, [$unit->serial, route('verify', $unit->verification_token)]);
            }
            fclose($stream);
        }, $batch->code.'-labels.csv', ['Content-Type' => 'text/csv', 'Cache-Control' => 'private, no-store']);
    }

    public function label(ProductUnit $unit): View
    {
        if ($unit->status === 'revoked') {
            throw ValidationException::withMessages(['unit' => 'Revoked units cannot produce printable labels.']);
        }

        $renderer = new ImageRenderer(new RendererStyle(240), new SvgImageBackEnd);
        $qr = base64_encode((new Writer($renderer))->writeString(route('verify', $unit->verification_token)));
        Audit::record('unit.label_viewed', $unit);

        return view('admin.label', compact('unit', 'qr'));
    }

    public function verify(Request $request, string $token): View
    {
        $unit = ProductUnit::with('batch.product')->where('verification_token', $token)->first();
        $valid = $unit && $unit->status === 'active' && $unit->batch?->status === 'released' && (! $unit->batch->expires_on || $unit->batch->expires_on->endOfDay()->isFuture());
        $scans = 0;
        if ($unit) {
            VerificationScan::create(['product_unit_id' => $unit->id, 'visitor_hash' => hash_hmac('sha256', (string) $request->ip().now()->format('Y-m-d'), (string) config('app.key'))]);
            $scans = VerificationScan::where('product_unit_id', $unit->id)->count();
        }

        return view('shop.verify', compact('unit', 'valid', 'scans'));
    }
}
