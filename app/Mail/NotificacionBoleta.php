<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificacionBoleta extends Mailable
{
    use Queueable, SerializesModels;


    protected $pdf;


    public  $boleta;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pdf,$boleta)
    {
        $this->pdf = $pdf;
        $this->boleta = $boleta;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.notificaciones.boletas')
        ->attachData($this->pdf, $this->boleta->radicado.'.pdf', [
            'mime' => 'application/pdf',
        ]);
    }
}
