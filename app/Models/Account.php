<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasFactory, HasUuids;
    protected $keyType = 'string';
    protected $fillable = [
        'user_id',
        'numero_compte',
        'nom',
        'type',
        'parent_account_id',
        'plafond',
        'statut',
        'solde'
    ];
    protected static function booted()
    {
        static::creating(function ($m) {
            if (!$m->getKey()) $m->{$m->getKeyName()} = (string) \Illuminate\Support\Str::uuid();
        });
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function parentAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'parent_account_id');
    }
    public function subAccounts(): HasMany
    {
        return $this->hasMany(Account::class, 'parent_account_id');
    }
}
