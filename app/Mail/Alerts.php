<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Alerts extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($status, $pro_titulo, $epi_titulo)
    {
        //
        $this->status = $status;
        $this->pro_titulo = $pro_titulo;
        $this->epi_titulo = $epi_titulo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        #return $this->markdown('emails.date-delivery');
        $status = $this->status;
        $pro_titulo = $this->pro_titulo;
        $epi_titulo = $this->epi_titulo;
        
        return $this->subject('Fecha de entrega')->view('emails.entrega', compact('status', 'pro_titulo', 'epi_titulo'));
    }
}
