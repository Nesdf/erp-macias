<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\Alerts;

class SendEmailDateDeliver extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:deliver';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permite enviar correos cuando un episodio esta por concluirse';

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
     * @return mixed
     */
    public function handle()
    {
        //
        try{
            $ayer = \Modules\MgEpisodios\Entities\Episodios::jobYesterdayDate();
            $manana = \Modules\MgEpisodios\Entities\Episodios::jobTomorrowDate();

            if(count($ayer) > 0){
                foreach ($ayer as $key => $value) {
                    # code...
                    $enviado = \Mail::to('ing.nestor.sanz@gmail.com')->send( new Alerts('warning', $value->pro_titulo, $value->epi_titulo) );
                    $this->info('Se enviaron los correos de acuerdo a la entrega de episodios.');
                }
            }

            if(count($manana) > 0){
                foreach ($manana as $key => $value) {
                    # code...
                    $enviado = \Mail::to('ing.nestor.sanz@gmail.com')->send( new Alerts('danger', $value->pro_titulo, $value->epi_titulo) );
                    $this->info('Se enviaron los correos de acuerdo a la entrega de episodios.');
                }
            }
        } catch( Exception $ex ){
            dd($ex);
        }
        
    }
}
