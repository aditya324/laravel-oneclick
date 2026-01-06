<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'student_registration_id',

        // Razorpay identifiers
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',

        // Amount details
        'amount',
        'currency',

        // Status tracking
        'status',
        'failure_stage',
        'failure_reason',
        'gateway_response',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'gateway_response' => 'array',
    ];

    /**
     * Relationship: Payment belongs to a student
     */
    public function student()
    {
        return $this->belongsTo(StudentRegistration::class, 'student_registration_id');
    }

    /**
     * Helper methods (VERY USEFUL)
     */
    public function isSuccessful(): bool
    {
        return $this->status === 'captured';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    public function canRetry(): bool
    {
        return in_array($this->status, ['failed', 'created', 'checkout_opened']);
    }
    public function isCaptured(): bool
    {
        return $this->status === 'captured';
    }

    public function isPending(): bool
    {
        return in_array($this->status, ['created', 'checkout_opened', 'pending']);
    }
}
