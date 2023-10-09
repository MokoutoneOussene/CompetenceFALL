<?php

namespace App\Models\Systeme;

use App\Models\Emploi\Offre;
use App\Models\Formation\FormationPresentielle;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pays extends Model
{
    use HasFactory;

    public $table = 'systeme_pays';

    public $timestamps = false;

    public $fillable = ['nom'];

    /**
     * Récupérer des personnes par rapport à leurs pays de naissance.
     *
     * @return HasMany $personnes
     *
     * @throws Exception $e
     */
    public function personnesPaysNaissances(): HasMany
    {

        try {

            return $this->hasMany(
                related: Personne::class,
                foreignKey: 'paysNaissance',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer des personnes par rapport à leurs pays de résidence.
     *
     * @return HasMany $personnes
     *
     * @throws Exception $e
     */
    public function personnesPaysResidences(): HasMany
    {

        try {

            return $this->hasMany(
                related: Personne::class,
                foreignKey: 'paysResidence',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer des organisations par rapport à leurs pays de siège.
     *
     * @return HasMany $organisations
     *
     * @throws Exception $e
     */
    public function organisationsPaysSieges(): HasMany
    {

        try {

            return $this->hasMany(
                related: Organisation::class,
                foreignKey: 'paysSiege',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les offres d'emploi.
     *
     * @return HasMany $offres
     *
     * @throws Exception $e
     */
    public function offres(): HasMany
    {

        try {

            return $this->hasMany(
                related: Offre::class,
                foreignKey: 'pays',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les indicatifs téléphoniques.
     *
     * @return HasMany $indicatifs
     *
     * @throws Exception $e
     */
    public function indicatifs(): HasMany
    {

        try {

            return $this->hasMany(
                related: IndicatifTelephonique::class,
                foreignKey: 'pays',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les formations en présentiel.
     *
     * @return HasMany $formations
     *
     * @throws Exception $e
     */
    public function formations(): HasMany
    {

        try {

            return $this->hasMany(
                related: FormationPresentielle::class,
                foreignKey: 'pays',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
