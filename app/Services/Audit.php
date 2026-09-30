<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Audit
{
    /** @param array<string, mixed> $changes */
    public static function record(string $action, Model $subject, array $changes = []): void
    {
        AuditLog::create(['user_id' => Auth::id(), 'action' => $action, 'subject_type' => $subject->getMorphClass(), 'subject_id' => $subject->getKey(), 'changes' => $changes]);
    }
}
