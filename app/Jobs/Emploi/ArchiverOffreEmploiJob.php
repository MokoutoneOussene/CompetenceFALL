<?php

namespace App\Jobs\Emploi;

use App\Models\Emploi\Archive;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ArchiverOffreEmploiJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Archive $archive;

    public function __construct(Archive $archive) { $this->archive = $archive; }

    public function handle(): void { $this->archive->genererArchive();  }
}
