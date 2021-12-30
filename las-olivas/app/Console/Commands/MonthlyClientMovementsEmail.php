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

    private $months_translator = [
        '1' => 'Enero',
        '2' => 'Febrero',
        '3' => 'Marzo',
        '4' => 'Abril',
        '5' => 'Mayo',
        '6' => 'Junio',
        '7' => 'Julio',
        '8' => 'Agosto',
        '9' => 'Septiembre',
        '10' => 'Octubre',
        '11' => 'Noviembre',
        '12' => 'Diciembre'
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function create_subject($client, $month, $year)
    {
        return 
            'Resumenes Movimientos ' . $this->months_translator[$month] . '-' . $year . ': ' . 
            $client->name . ' ' . $client->last_name;
    }

    private function create_body($month, $year)
    {
        return 
            '<p>Procedemos a adjuntarte tus movimientos del mes de ' . $this->months_translator[$month] . 
            ' del año ' . $year . '</p>' .
            '<br>' .
            '<h3>Las Olivas Pringles</h3>';
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $files_path = public_path() . '/movements/';

        $pdf_controller = new PDFController();
        
        $year = date('Y');
        $previous_month = date('m');  // - 1;

        $clients = Client::all();
        foreach ($clients as $client)
        {
            if ($client->email != null)
            {
                $movements = Movement::
                    where('client_id', $client->id)
                    ->whereMonth('created_at', $previous_month)
                    ->get();
                
                if (count($movements) != 0)
                {
                    $pdf = $pdf_controller->create_pdf($client, $movements);
                    $client_path = $files_path . $client->name . $client->last_name . $previous_month . '.pdf';
                    
                    file_put_contents($client_path, $pdf->output());

                    $subject = $this->create_subject($client, $previous_month, $year);
                    $body = $this->create_body($previous_month, $year);

                    Mail::send(array(), array(), function ($message) use ($subject, $body, $client, $client_path) {
                        $message->to($client->email)
                          ->subject($subject)
                          ->from('testingautomast123@gmail.com', 'Las Olivas Pringles')
                          ->setBody($body, 'text/html')
                          ->attach(\Swift_Attachment::fromPath($client_path));
                    });
                }   
            }
        }
        $this->info('Monthly movements email sent to all clients');
    }
}
