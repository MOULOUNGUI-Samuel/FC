<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loan extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = ['debtor_account_id', 'loan_number', 'amount_granted', 'annual_interest_rate', 'request_date', 'approval_date', 'disbursement_date', 'duration_in_months', 'status'];
    protected $casts = ['request_date' => 'date', 'approval_date' => 'date', 'disbursement_date' => 'date'];
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'debtor_account_id');
    }
    public function installments(): HasMany
    {
        return $this->hasMany(LoanInstallment::class);
    }
}
