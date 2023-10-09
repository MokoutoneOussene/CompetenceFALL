<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ViderTables extends Command
{
    protected $signature = 'bd:vider';

    protected $description = 'Vider toutes les tables de la base de données.';

    public function handle()
    {

        // Désactiver les vérifications de contraintes de clé étrangère
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Récupérer la liste des tables de la base de données
        $tables = DB::select('SHOW TABLES');

        $excludedTables = [
            'migrations',       // Tables de migration
            'password_resets',  // Table de réinitialisation de mot de passe
            'failed_jobs',      // Table des jobs échoués (si utilisée)
            'cache',            // Table de cache (si utilisée)
            // Ajoutez ici d'autres tables à exclure si nécessaire
        ];

        foreach ($tables as $table) {
            $tableName = reset($table);

            // Vérifier si la table est dans la liste des exclusions
            if (! in_array($tableName, $excludedTables)) {
                DB::table($tableName)->truncate();
                $this->info("Table $tableName vidée avec succès.");
            }
        }

        // Réactiver les vérifications de contraintes de clé étrangère
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->info('Toutes les tables ont été vidées (en excluant les tables de Laravel).');
    }
}
