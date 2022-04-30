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
        $new_balance = $previous_movement->balance + $this->due - $this->paid;
        $this->balance = $new_balance;
        $this->save();
    }
}
