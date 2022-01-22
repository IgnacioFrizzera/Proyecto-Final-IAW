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
        'extra_comentary',
        'paid_with_promotion',
        'created_at'
    ];

}
