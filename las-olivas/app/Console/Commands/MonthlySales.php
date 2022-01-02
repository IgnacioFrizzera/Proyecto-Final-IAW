<?php

namespace App\Console\Commands;

use App\Http\Controllers\SalesController;
use App\Models\MonthlySale;

use Illuminate\Console\Command;

class MonthlySales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthly:sales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculates the sum of each receipt type for all the movements from the previous month.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $year = date('Y');
        $month_to_calculate = date('m') - 1;
        if ($month_to_calculate == '0')
        {
            $month_to_calculate = '12';
            $year = $year - 1;
        }

        $sales_controller = new SalesController();
        $monthly_sales = $sales_controller->calculate_monthly_sales($month_to_calculate, $year);

        MonthlySale::create([
            'fc' => $monthly_sales['fc'],
            'fcc' => $monthly_sales['fcc'],
            'ef' => $monthly_sales['ef'],
            'tc' => $monthly_sales['tc'],
            'td' => $monthly_sales['td'],
            'month' => $month_to_calculate,
            'year' => $year
        ]);
        
        $this->info('Monthly sales calculated.');
    }
}
