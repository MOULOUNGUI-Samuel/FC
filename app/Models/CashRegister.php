<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashRegister extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = ['user_id', 'name', 'type', 'balance', 'min_threshold', 'max_threshold'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
