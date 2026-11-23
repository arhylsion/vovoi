<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $guarded = [];

    /**
     * Calculate discount for a given amount.
     */
    public function calculateDiscount(int $subtotal): int
    {
        if (! $this->is_active) {
            return 0;
        }

        if ($subtotal < $this->min_order) {
            return 0;
        }

        if ($this->discount_type === 'percent') {
            return (int) round(($subtotal * $this->discount_amount) / 100);
        }

        return min($this->discount_amount, $subtotal);
    }
}
