<?php

namespace App\Mail\Newsletter;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BienvenuMail extends Mailable
{
    use Queueable, SerializesModels;

    public $jeton;

    /**
     * Créer une nouvelle instance de mail
     */
    public function __construct(string $sujet, string $destinataire, string $jeton)
    {
        $this->subject($sujet);

        $this->to($destinataire);

        $this->jeton = $jeton;
    }

    public function build()
    {
        return $this->view('emails.motdepasseoublie');
    }
}
