<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CashRegisterSession extends Model
{
    //
    use HasFactory, HasUuids;
    protected $fillable = ['cash_register_id', 'opening_user_id', 'opening_time', 'initial_balance', 'closing_user_id', 'closing_time', 'theorical_final_balance', 'real_final_balance', 'difference', 'justification'];
    protected $casts = ['opening_time' => 'datetime', 'closing_time' => 'datetime'];
    public function cashRegister(): BelongsTo
    {
        return $this->belongsTo(CashRegister::class);
    }
    public function openingUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'opening_user_id');
    }
    public function closingUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'closing_user_id');
    }
    public function operations(): HasMany
    {
        return $this->hasMany(Operation::class);
    }
}
