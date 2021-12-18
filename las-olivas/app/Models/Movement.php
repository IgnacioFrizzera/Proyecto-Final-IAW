<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'receipt_type',
        'due',
        'paid',
        'balance',
        'client_id'
    ];

    public $timestamps = false;
}
