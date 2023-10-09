<?php

namespace App\Jobs\Systeme\Utilisateur;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\Facades\Image;

class PhotoProfilJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $chemin;

    public function __construct(string $chemin)
    {

        $this->chemin = $chemin;
    }

    public function handle(): void
    {

        $image = Image::make($this->chemin);

        $image->resize(200, null, function ($constraint) {

            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $image->save($this->chemin.'-intervention.png', 100, 'png');
    }
}
