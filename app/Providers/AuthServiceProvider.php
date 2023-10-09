<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Systeme\Utilisateur;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gates pour les candidatures.
        // Vérifier si l'utilisateur est le propriétaire d'un modèle.
        Gate::define('proprietaire-modele', function (Utilisateur $utilisateur, $model): bool {

            return $utilisateur->id == $model->utilisateur;
        });

        // Vérifier si l'utilisateur est une personne physique.
        Gate::define('personne-physique', function (Utilisateur $utilisateur): bool {

            return $utilisateur->typeUtilisateur == 'personne';
        });

        // Vérifier si l'utilisateur est un reponsable des offres d'emploi.
        Gate::define('responsable-roo', function (Utilisateur $utilisateur): bool {

            $roles = $utilisateur->roles()->get(['slug']);

            $autorisation = false;

            if ($roles->isEmpty()) {
                return false;
            }

            foreach ($roles as $role) {
                if ($role->slug === 'roo') {
                    $autorisation = true;
                    break;
                }
            }

            return $autorisation;
        });
    }
}
