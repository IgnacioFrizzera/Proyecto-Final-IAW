<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $dates = ['created_at'];

    protected $fillable = [
        'description',
        'receipt_type',
        'due',
        'paid',
        'balance',
        'client_id',
        'category_id',
        'brand_id',
        'size_id',
        'paid_with_promotion',
        'created_at'
    ];

    public function recalculate_balance(Movement $previous_movement)
    {
        /**
         * due: 150, paid: 0, balance: 150 -> previous_movement
         * due: 0, paid: 150, balance: 0   -> debería ser -150 balance
         */

        $new_balance = $previous_movement->balance + $this->due - $this->paid;
        $this->balance = $new_balance;
        $this->save();
    }
}
