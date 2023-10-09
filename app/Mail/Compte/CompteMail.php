<?php

namespace App\Mail\Compte;

use App\Models\Systeme\Utilisateur;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $utilisateur;

    public $vue;

    /**
     * Créer un mail
     *
     * @param  string  $sujet : Sujet du message
     * @param  string  $vue : Vue mail en envoyée
     */
    public function __construct(

        string $sujet,

        string $vue,

        Utilisateur $utilisateur

    ) {

        $this->subject($sujet);

        $this->to($utilisateur->email);

        $this->utilisateur = $utilisateur;

        $this->vue = $vue;
    }

    public function build()
    {

        return $this->view($this->vue);
    }
}
