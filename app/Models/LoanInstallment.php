<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoanInstallment extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = ['loan_id', 'due_date', 'principal_amount', 'interest_amount', 'total_amount', 'status', 'paid_amount', 'payment_date'];
    protected $casts = ['due_date' => 'date', 'payment_date' => 'datetime'];
    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }
}
