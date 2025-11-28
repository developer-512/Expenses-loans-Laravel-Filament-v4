<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    /**
     * Allowed source types.
     */
    public const SOURCE_TYPES = [
        'Salary',
        'Credit Card',
        'Pension',
        'Loan',
        'Projects',
        'Savings',
        'Other Payments',
    ];

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'title',
        'description',
        'amount',
        'receipt',
        'source',
        'date',
        'user_id',
    ];

    /**
     * The attributes cast.
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'date',
    ];

    /**
     * Relations
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mutator to ensure only allowed sources are saved.
     */
    public function setSourceAttribute($value): void
    {
        if (!in_array($value, self::SOURCE_TYPES)) {
            $this->attributes['source'] = 'Salary';
        }else{
            $this->attributes['source'] = $value;
        }
    }
}
