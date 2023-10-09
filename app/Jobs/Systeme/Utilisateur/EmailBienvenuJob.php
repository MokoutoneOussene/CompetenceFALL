<?php

namespace App\Jobs\Systeme\Utilisateur;

use App\Mail\Compte\CompteMail;
use App\Models\Systeme\Utilisateur;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EmailBienvenuJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Utilisateur $utilisateur;

    /**
     * Create a new job instance.
     */
    public function __construct(Utilisateur $utilisateur)
    {
        $this->utilisateur = $utilisateur;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Envoyer un email de bienvenu.
        Mail::to($this->utilisateur->email)->send(new CompteMail(
            'Bienvenu',
            'emails.compte.DemandeVerificationEmail',
            $this->utilisateur
        ));
    }
}
