<?php

namespace Modules\MgContabilidad\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PagosEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $pago;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $pago)
    {
        //
        $this->data = $data;
        $this->pago = $pago;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;
        $pago = $this->pago;
        return $this->view('mgcontabilidad::email.pagos', compact('data', 'pago'))
            ->from('ing.nestor.sanz@gmail.com', 'MACIAS GROUP')
            ->subject('Detalle de PAgo');
    }
}
