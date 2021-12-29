<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\PDFController;

use App\Models\Client;
use App\Models\Movement;

class MonthlyClientMovementsEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthly_movements:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends an email to each client with its last month movements.';

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
        $pdf_controller = new PDFController();
        
        $current_month = date('m');

        $clients = Client::all();
        foreach ($clients as $client)
        {
            if ($client->email != null)
            {
                $movements = Movement::
                    where('client_id', $client->id)
                    ->whereMonth('created_at', $current_month - 1)
                    ->get();
                
                if (count($movements) != 0)
                {
                    $pdf = $pdf_controller->create_pdf($client, $movements);
                    // email->send()
                }
            }
        }
        $this->info('Monthly movements email sent to all clients');
    }
}
