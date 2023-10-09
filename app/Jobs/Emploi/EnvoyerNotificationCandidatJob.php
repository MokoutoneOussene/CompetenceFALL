<?php

namespace App\Jobs\Emploi;

use App\Models\Emploi\OffreEmploi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EnvoyerNotificationCandidatJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public OffreEmploi $offreEmploi;

    public function __construct(OffreEmploi $offreEmploi)  {  $this->offreEmploi = $offreEmploi; }

    public function handle(): void  { $this->offreEmploi->genererPdf(); }
}
