<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'phone_number',
        'birthday',
        'address',
        'profession'
    ];

    public function calculate_new_balance(float $due, float $paid)
    {
        $difference = $due - $paid;
        $this->current_balance = $this->current_balance + $difference;
    }
}
