<?php

namespace App\Providers;

use App\Models\Emploi\Archive;
use App\Models\Emploi\Candidature;
use App\Models\Emploi\CandidatureCentre;
use App\Models\Emploi\CandidatureCertificat;
use App\Models\Emploi\CandidatureCompetence;
use App\Models\Emploi\CandidatureConvocation;
use App\Models\Emploi\CandidatureCv;
use App\Models\Emploi\CandidatureDiplome;
use App\Models\Emploi\CandidatureExperience;
use App\Models\Emploi\CandidatureLangue;
use App\Models\Emploi\CandidaturePortfolio;
use App\Models\Emploi\CandidatureReference;
use App\Models\Emploi\CandidatureReponse;
use App\Models\Emploi\OffreEmploi;
use App\Observers\Emploi\ArchiveObserver;
use App\Observers\Emploi\CandidatureCentreObserver;
use App\Observers\Emploi\CandidatureCertificatObserver;
use App\Observers\Emploi\CandidatureCompetenceObserver;
use App\Observers\Emploi\CandidatureConvocationObserver;
use App\Observers\Emploi\CandidatureCvObserver;
use App\Observers\Emploi\CandidatureDiplomeObserver;
use App\Observers\Emploi\CandidatureExperienceObserver;
use App\Observers\Emploi\CandidatureLangueObserver;
use App\Observers\Emploi\CandidatureObserver;
use App\Observers\Emploi\CandidaturePortfolioObserver;
use App\Observers\Emploi\CandidatureReferenceObserver;
use App\Observers\Emploi\CandidatureReponseObserver;
use App\Observers\Emploi\OffreEmploiObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        OffreEmploi::observe(OffreEmploiObserver::class);
        Candidature::observe(CandidatureObserver::class);
        Archive::observe(ArchiveObserver::class);
        CandidatureCentre::observe(CandidatureCentreObserver::class);
        CandidatureCertificat::observe(CandidatureCertificatObserver::class);
        CandidatureCompetence::observe(CandidatureCompetenceObserver::class);
        CandidatureConvocation::observe(CandidatureConvocationObserver::class);
        CandidatureDiplome::observe(CandidatureDiplomeObserver::class);
        CandidatureCv::observe(CandidatureCvObserver::class);
        CandidatureExperience::observe(CandidatureExperienceObserver::class);
        CandidatureLangue::observe(CandidatureLangueObserver::class);
        CandidaturePortfolio::observe(CandidaturePortfolioObserver::class);
        CandidatureReference::observe(CandidatureReferenceObserver::class);
        CandidatureReponse::observe(CandidatureReponseObserver::class);
    }
}
