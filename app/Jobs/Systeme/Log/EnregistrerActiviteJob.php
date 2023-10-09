<?php

namespace App\Jobs\Systeme\Log;

use App\Models\Systeme\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EnregistrerActiviteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $donnees;

    public function __construct(array $donnees)
    {

        $this->donnees = $donnees;
    }

    public function handle(): void
    {

        $activite = new Log([
            'utilisateur' => $this->donnees['utilisateur'],
            'action' => $this->donnees['action'],
            'details' => $this->donnees['details'],
        ]);

        $activite->save();
    }
}
