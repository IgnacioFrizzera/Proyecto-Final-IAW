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

    public function get_previous_month_balance(string $current_month, string $year)
    {   
        $previous_month = $current_month - 1;
        if ($previous_month == '0')
        {
            $year = $year - 1;
            $previous_month = '12';
        }

        $movement = $this->movements()
                         ->whereMonth('created_at', $previous_month)
                         ->whereYear('created_at', $year)
                         ->orderBy('created_at', 'DESC')
                         ->orderBy('id', 'DESC')
                         ->first();
        
        if ($movement == null) return 0;

        return $movement->balance;
    }

    public function get_month_movements(string $month, string $year)
    {
        return $this->movements()
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->join('categories', 'movements.category_id', '=', 'categories.id')
                    ->get();
    }

    public function get_between_movements(string $from, string $to)
    {
        return $this->movements()
                    ->whereBetween('created_at', [$from, $to])
                    ->join('categories', 'movements.category_id', '=', 'categories.id')
                    ->get();
    }

    public function delete_movements()
    {
        $this->movements()->delete();
    }

    public function recalculate_balance(Movement $movement)
    {
        $previous_movement = $this->movements()->where('id', '<', $movement->id)->get()->last();
        $later_movements = $this->movements()->where('id', '>', $movement->id)->get();
        foreach ($later_movements as $later_movement)
        {
            $later_movement->recalculate_balance($previous_movement);
            $previous_movement = $later_movement;
        }
        $this->current_balance = $previous_movement->balance;      
    }
}
