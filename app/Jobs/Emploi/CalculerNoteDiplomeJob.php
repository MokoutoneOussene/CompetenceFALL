<?php

namespace App\Jobs\Emploi;

use App\Models\Emploi\Candidature;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculerNoteDiplomeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Candidature $candidature;

    public function __construct(Candidature $candidature) { $this->candidature = $candidature; }

    public function handle(): void  { $this->candidature->calculerNoteDiplomes(); }
}
