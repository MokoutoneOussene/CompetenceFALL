<?php

namespace App\Jobs\Emploi;

use App\Models\Emploi\CandidatureConvocation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenererPdfConvocationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public CandidatureConvocation $convocation;

    public function __construct(CandidatureConvocation $convocation) { $this->convocation = $convocation; }

    public function handle(): void { $this->convocation->genererPdf(); }
}
