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

    public function movements()
    {
        return $this->hasMany('App\Models\Movement');
    }

    public function calculate_new_balance(float $due, float $paid)
    {
        $difference = $due - $paid;
        $this->current_balance = $this->current_balance + $difference;
    }

    public function get_previous_month_balance(string $current_month)
    {
        $movement = $this->movements()
                         ->whereMonth('created_at', $current_month - 1)
                         ->orderBy('created_at', 'DESC')
                         ->orderBy('id', 'DESC')
                         ->first();

        if ($movement == null) return 0;

        return $movement->balance;
    }

    public function get_month_movements(string $month)
    {
        return $this->movements()
                    ->whereMonth('created_at', $month)
                    ->get();
    }

    public function get_between_movements(string $from, string $to)
    {
        return $this->movements()->whereBetween('created_at', [$from, $to])->get();
    }
}
