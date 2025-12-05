<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoanTaken extends Model
{
    use HasFactory;
    protected $table = 'loan_takens';

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'user_id',
        'lender_id',
        'receipt',
        'amount',
        'date',
        'repayment_date',
        'amount_paid',
        'paid',
        'purpose',
    ];

    /**
     * Casts for model attributes
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'date'   => 'date',
        'repayment_date'   => 'date',
        'paid'   => 'boolean',
    ];

    /**
     * Relationships
     */

    // User who issued the loan
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Borrower receiving the loan
    public function lender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'lender_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($loan) {

            // If paid is true AND repayment_date is empty → set today's date
            if ($loan->paid && is_null($loan->repayment_date)) {
                $loan->repayment_date = now()->toDateString();
            }
            if($loan->paid && $loan->amount_paid < $loan->amount){
                $loan->amount_paid=$loan->amount;
            }
            // If paid is false → reset to null
            if (! $loan->paid) {
                $loan->repayment_date = null;
            }
        });
    }

}
