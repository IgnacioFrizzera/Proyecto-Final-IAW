<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\PDFController;

use App\Models\Client;
use App\Models\Movement;

class MonthlyClientMovementsWhatsapp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthly_movements:whatsapp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends a whatsapp message to each client with its last month movements.';

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
        $clients = Client::all();
        foreach ($clients as $client)
        {
            $client_phone_number = $client->phone_number;
            if ($client_phone_number != null)
            {
                if ($client_phone_number[0] == '0')
                {
                    $client_phone_number = ltrim($client_phone_number, $client_phone_number[0]);
                }

                $movements = Movement::where('client_id', $client->id)->get();
                $pdf = $pdf_controller->create_pdf($client, $movements);
                
                // whatsapp->send
            }
        }
        $this->info('Monthly movements whatsapp message sent to all clients');
    }
}
