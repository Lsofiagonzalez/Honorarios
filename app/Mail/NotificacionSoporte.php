<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificacionSoporte extends Mailable
{


    use Queueable, SerializesModels;


    /**
     * 
     */
    protected $pdf;

    /**
     * 
     */
    public $soporte;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pdf,$soporte)
    {
        $this->pdf = $pdf;
        $this->soporte = $soporte;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.notificaciones.soportes')
        ->attachData($this->pdf, $this->soporte->radicado.'.pdf', [
            'mime' => 'application/pdf',
        ]);
    }

    
}
