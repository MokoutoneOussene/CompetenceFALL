<?php

namespace Database\Seeders\Systeme;

use App\Models\Systeme\IndicatifTelephonique;
use App\Models\Systeme\Pays;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IndicatifTelephoniqueSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        IndicatifTelephonique::factory()->createMany([
            [
                'pays' => Pays::where('nom', 'Afghanistan')->first(['id'])->id,
                'valeur' => 93,
            ],
            [
                'pays' => Pays::where('nom', 'Afrique du Sud')->first(['id'])->id,
                'valeur' => 27,
            ],
            [
                'pays' => Pays::where('nom', 'Albanie')->first(['id'])->id,
                'valeur' => 355,
            ],
            [
                'pays' => Pays::where('nom', 'Algérie')->first(['id'])->id,
                'valeur' => 213,
            ],
            [
                'pays' => Pays::where('nom', 'Allemagne')->first(['id'])->id,
                'valeur' => 49,
            ],
            [
                'pays' => Pays::where('nom', 'Andorre')->first(['id'])->id,
                'valeur' => 376,
            ],
            [
                'pays' => Pays::where('nom', 'Angola')->first(['id'])->id,
                'valeur' => 244,
            ],
            [
                'pays' => Pays::where('nom', 'Antigua-et-Barbuda')->first(['id'])->id,
                'valeur' => 1,
            ],
            [
                'pays' => Pays::where('nom', 'Arabie saoudite')->first(['id'])->id,
                'valeur' => 966,
            ],
            [
                'pays' => Pays::where('nom', 'Argentine')->first(['id'])->id,
                'valeur' => 54,
            ],
            [
                'pays' => Pays::where('nom', 'Arménie')->first(['id'])->id,
                'valeur' => 374,
            ],
            [
                'pays' => Pays::where('nom', 'Australie')->first(['id'])->id,
                'valeur' => 61,
            ],
            [
                'pays' => Pays::where('nom', 'Autriche')->first(['id'])->id,
                'valeur' => 43,
            ],
            [
                'pays' => Pays::where('nom', 'Azerbaïdjan')->first(['id'])->id,
                'valeur' => 994,
            ],
            [
                'pays' => Pays::where('nom', 'Bahamas')->first(['id'])->id,
                'valeur' => 1,
            ],
            [
                'pays' => Pays::where('nom', 'Bahreïn')->first(['id'])->id,
                'valeur' => 973,
            ],
            [
                'pays' => Pays::where('nom', 'Bangladesh')->first(['id'])->id,
                'valeur' => 880,
            ],
            [
                'pays' => Pays::where('nom', 'Barbade')->first(['id'])->id,
                'valeur' => 1,
            ],
            [
                'pays' => Pays::where('nom', 'Belgique')->first(['id'])->id,
                'valeur' => 32,
            ],
            [
                'pays' => Pays::where('nom', 'Bélize')->first(['id'])->id,
                'valeur' => 501,
            ],
            [
                'pays' => Pays::where('nom', 'Bénin')->first(['id'])->id,
                'valeur' => 229,
            ],
            [
                'pays' => Pays::where('nom', 'Bhoutan')->first(['id'])->id,
                'valeur' => 975,
            ],
            [
                'pays' => Pays::where('nom', 'Biélorussie')->first(['id'])->id,
                'valeur' => 375,
            ],
            [
                'pays' => Pays::where('nom', 'Myanmar (Birmanie)')->first(['id'])->id,
                'valeur' => 95,
            ],
            [
                'pays' => Pays::where('nom', 'Bolivie')->first(['id'])->id,
                'valeur' => 591,
            ],
            [
                'pays' => Pays::where('nom', 'Bosnie-Herzégovine')->first(['id'])->id,
                'valeur' => 387,
            ],
            [
                'pays' => Pays::where('nom', 'Botswana')->first(['id'])->id,
                'valeur' => 267,
            ],
            [
                'pays' => Pays::where('nom', 'Brésil')->first(['id'])->id,
                'valeur' => 55,
            ],
            [
                'pays' => Pays::where('nom', 'Brunei')->first(['id'])->id,
                'valeur' => 673,
            ],
            [
                'pays' => Pays::where('nom', 'Bulgarie')->first(['id'])->id,
                'valeur' => 359,
            ],
            [
                'pays' => Pays::where('nom', 'Burkina Faso')->first(['id'])->id,
                'valeur' => 226,
            ],
            [
                'pays' => Pays::where('nom', 'Burundi')->first(['id'])->id,
                'valeur' => 257,
            ],
            [
                'pays' => Pays::where('nom', 'Cambodge')->first(['id'])->id,
                'valeur' => 855,
            ],
            [
                'pays' => Pays::where('nom', 'Cameroun')->first(['id'])->id,
                'valeur' => 237,
            ],
            [
                'pays' => Pays::where('nom', 'Canada')->first(['id'])->id,
                'valeur' => 1,
            ],
            [
                'pays' => Pays::where('nom', 'Cap-Vert')->first(['id'])->id,
                'valeur' => 238,
            ],
            [
                'pays' => Pays::where('nom', 'Centrafrique')->first(['id'])->id,
                'valeur' => 236,
            ],
            [
                'pays' => Pays::where('nom', 'Chili')->first(['id'])->id,
                'valeur' => 56,
            ],
            [
                'pays' => Pays::where('nom', 'Chine')->first(['id'])->id,
                'valeur' => 86,
            ],
            [
                'pays' => Pays::where('nom', 'Chypre')->first(['id'])->id,
                'valeur' => 357,
            ],
            [
                'pays' => Pays::where('nom', 'Colombie')->first(['id'])->id,
                'valeur' => 57,
            ],
            [
                'pays' => Pays::where('nom', 'Comores')->first(['id'])->id,
                'valeur' => 269,
            ],
            [
                'pays' => Pays::where('nom', 'Congo-Brazzaville')->first(['id'])->id,
                'valeur' => 242,
            ],
            [
                'pays' => Pays::where('nom', 'Congo-Kinshasa')->first(['id'])->id,
                'valeur' => 243,
            ],
            [
                'pays' => Pays::where('nom', 'Corée du Nord')->first(['id'])->id,
                'valeur' => 850,
            ],
            [
                'pays' => Pays::where('nom', 'Corée du Sud')->first(['id'])->id,
                'valeur' => 82,
            ],
            [
                'pays' => Pays::where('nom', 'Costa Rica')->first(['id'])->id,
                'valeur' => 506,
            ],
            [
                'pays' => Pays::where('nom', "Côte d'Ivoire")->first(['id'])->id,
                'valeur' => 225,
            ],
            [
                'pays' => Pays::where('nom', 'Croatie')->first(['id'])->id,
                'valeur' => 385,
            ],
            [
                'pays' => Pays::where('nom', 'Cuba')->first(['id'])->id,
                'valeur' => 53,
            ],
            [
                'pays' => Pays::where('nom', 'Danemark')->first(['id'])->id,
                'valeur' => 45,
            ],
            [
                'pays' => Pays::where('nom', 'Djibouti')->first(['id'])->id,
                'valeur' => 253,
            ],
            [
                'pays' => Pays::where('nom', 'Dominique')->first(['id'])->id,
                'valeur' => 1,
            ],
            [
                'pays' => Pays::where('nom', 'Égypte')->first(['id'])->id,
                'valeur' => 20,
            ],
            [
                'pays' => Pays::where('nom', 'Émirats arabes unis')->first(['id'])->id,
                'valeur' => 971,
            ],
            [
                'pays' => Pays::where('nom', 'Équateur')->first(['id'])->id,
                'valeur' => 593,
            ],
            [
                'pays' => Pays::where('nom', 'Érythrée')->first(['id'])->id,
                'valeur' => 291,
            ],
            [
                'pays' => Pays::where('nom', 'Espagne')->first(['id'])->id,
                'valeur' => 34,
            ],
            [
                'pays' => Pays::where('nom', 'Estonie')->first(['id'])->id,
                'valeur' => 372,
            ],
            [
                'pays' => Pays::where('nom', 'Eswatini (Swaziland)')->first(['id'])->id,
                'valeur' => 268,
            ],
            [
                'pays' => Pays::where('nom', 'États-Unis')->first(['id'])->id,
                'valeur' => 1,
            ],
            [
                'pays' => Pays::where('nom', 'Éthiopie')->first(['id'])->id,
                'valeur' => 251,
            ],
            [
                'pays' => Pays::where('nom', 'Fidji')->first(['id'])->id,
                'valeur' => 679,
            ],
            [
                'pays' => Pays::where('nom', 'Finlande')->first(['id'])->id,
                'valeur' => 358,
            ],
            [
                'pays' => Pays::where('nom', 'France')->first(['id'])->id,
                'valeur' => 33,
            ],
            [
                'pays' => Pays::where('nom', 'Gabon')->first(['id'])->id,
                'valeur' => 241,
            ],
            [
                'pays' => Pays::where('nom', 'Gambie')->first(['id'])->id,
                'valeur' => 220,
            ],
            [
                'pays' => Pays::where('nom', 'Géorgie')->first(['id'])->id,
                'valeur' => 995,
            ],
            [
                'pays' => Pays::where('nom', 'Ghana')->first(['id'])->id,
                'valeur' => 233,
            ],
            [
                'pays' => Pays::where('nom', 'Grèce')->first(['id'])->id,
                'valeur' => 30,
            ],
            [
                'pays' => Pays::where('nom', 'Grenade')->first(['id'])->id,
                'valeur' => 1,
            ],
            [
                'pays' => Pays::where('nom', 'Guatemala')->first(['id'])->id,
                'valeur' => 502,
            ],
            [
                'pays' => Pays::where('nom', 'Guinée')->first(['id'])->id,
                'valeur' => 224,
            ],
            [
                'pays' => Pays::where('nom', 'Guinée-Bissau')->first(['id'])->id,
                'valeur' => 245,
            ],
            [
                'pays' => Pays::where('nom', 'Guinée équatoriale')->first(['id'])->id,
                'valeur' => 240,
            ],
            [
                'pays' => Pays::where('nom', 'Guyana')->first(['id'])->id,
                'valeur' => 592,
            ],
            [
                'pays' => Pays::where('nom', 'Haïti')->first(['id'])->id,
                'valeur' => 509,
            ],
            [
                'pays' => Pays::where('nom', 'Honduras')->first(['id'])->id,
                'valeur' => 504,
            ],
            [
                'pays' => Pays::where('nom', 'Hongrie')->first(['id'])->id,
                'valeur' => 36,
            ],
            [
                'pays' => Pays::where('nom', 'Îles Cook')->first(['id'])->id,
                'valeur' => 682,
            ],
            [
                'pays' => Pays::where('nom', 'Îles Marshall')->first(['id'])->id,
                'valeur' => 692,
            ],
            [
                'pays' => Pays::where('nom', 'Îles Salomon')->first(['id'])->id,
                'valeur' => 677,
            ],
            [
                'pays' => Pays::where('nom', 'Inde')->first(['id'])->id,
                'valeur' => 91,
            ],
            [
                'pays' => Pays::where('nom', 'Indonésie')->first(['id'])->id,
                'valeur' => 62,
            ],
            [
                'pays' => Pays::where('nom', 'Irak')->first(['id'])->id,
                'valeur' => 964,
            ],
            [
                'pays' => Pays::where('nom', 'Iran')->first(['id'])->id,
                'valeur' => 98,
            ],
            [
                'pays' => Pays::where('nom', 'Irlande')->first(['id'])->id,
                'valeur' => 353,
            ],
            [
                'pays' => Pays::where('nom', 'Islande')->first(['id'])->id,
                'valeur' => 354,
            ],
            [
                'pays' => Pays::where('nom', 'Israël')->first(['id'])->id,
                'valeur' => 972,
            ],
            [
                'pays' => Pays::where('nom', 'Italie')->first(['id'])->id,
                'valeur' => 39,
            ],
            [
                'pays' => Pays::where('nom', 'Jamaïque')->first(['id'])->id,
                'valeur' => 1,
            ],
            [
                'pays' => Pays::where('nom', 'Japon')->first(['id'])->id,
                'valeur' => 81,
            ],
            [
                'pays' => Pays::where('nom', 'Jordanie')->first(['id'])->id,
                'valeur' => 962,
            ],
            [
                'pays' => Pays::where('nom', 'Kazakhstan')->first(['id'])->id,
                'valeur' => 7,
            ],
            [
                'pays' => Pays::where('nom', 'Kenya')->first(['id'])->id,
                'valeur' => 254,
            ],
            [
                'pays' => Pays::where('nom', 'Kirghizistan')->first(['id'])->id,
                'valeur' => 996,
            ],
            [
                'pays' => Pays::where('nom', 'Kiribati')->first(['id'])->id,
                'valeur' => 686,
            ],
            [
                'pays' => Pays::where('nom', 'Kosovo')->first(['id'])->id,
                'valeur' => 383,
            ],
            [
                'pays' => Pays::where('nom', 'Koweït')->first(['id'])->id,
                'valeur' => 965,
            ],
            [
                'pays' => Pays::where('nom', 'Laos')->first(['id'])->id,
                'valeur' => 856,
            ],
            [
                'pays' => Pays::where('nom', 'Lesotho')->first(['id'])->id,
                'valeur' => 266,
            ],
            [
                'pays' => Pays::where('nom', 'Lettonie')->first(['id'])->id,
                'valeur' => 371,
            ],
            [
                'pays' => Pays::where('nom', 'Liban')->first(['id'])->id,
                'valeur' => 961,
            ],
            [
                'pays' => Pays::where('nom', 'Libéria')->first(['id'])->id,
                'valeur' => 231,
            ],
            [
                'pays' => Pays::where('nom', 'Libye')->first(['id'])->id,
                'valeur' => 218,
            ],
            [
                'pays' => Pays::where('nom', 'Liechtenstein')->first(['id'])->id,
                'valeur' => 423,
            ],
            [
                'pays' => Pays::where('nom', 'Lituanie')->first(['id'])->id,
                'valeur' => 370,
            ],
            [
                'pays' => Pays::where('nom', 'Luxembourg')->first(['id'])->id,
                'valeur' => 352,
            ],
            [
                'pays' => Pays::where('nom', 'Macédoine du Nord')->first(['id'])->id,
                'valeur' => 389,
            ],
            [
                'pays' => Pays::where('nom', 'Madagascar')->first(['id'])->id,
                'valeur' => 261,
            ],
            [
                'pays' => Pays::where('nom', 'Malaisie')->first(['id'])->id,
                'valeur' => 60,
            ],
            [
                'pays' => Pays::where('nom', 'Malawi')->first(['id'])->id,
                'valeur' => 265,
            ],
            [
                'pays' => Pays::where('nom', 'Maldives')->first(['id'])->id,
                'valeur' => 960,
            ],
            [
                'pays' => Pays::where('nom', 'Mali')->first(['id'])->id,
                'valeur' => 223,
            ],
            [
                'pays' => Pays::where('nom', 'Malte')->first(['id'])->id,
                'valeur' => 356,
            ],
            [
                'pays' => Pays::where('nom', 'Maroc')->first(['id'])->id,
                'valeur' => 212,
            ],
            [
                'pays' => Pays::where('nom', 'Maurice')->first(['id'])->id,
                'valeur' => 230,
            ],
            [
                'pays' => Pays::where('nom', 'Mauritanie')->first(['id'])->id,
                'valeur' => 222,
            ],
            [
                'pays' => Pays::where('nom', 'Mexique')->first(['id'])->id,
                'valeur' => 52,
            ],
            [
                'pays' => Pays::where('nom', 'Micronésie')->first(['id'])->id,
                'valeur' => 691,
            ],
            [
                'pays' => Pays::where('nom', 'Moldavie')->first(['id'])->id,
                'valeur' => 373,
            ],
            [
                'pays' => Pays::where('nom', 'Monaco')->first(['id'])->id,
                'valeur' => 377,
            ],
            [
                'pays' => Pays::where('nom', 'Mongolie')->first(['id'])->id,
                'valeur' => 976,
            ],
            [
                'pays' => Pays::where('nom', 'Monténégro')->first(['id'])->id,
                'valeur' => 382,
            ],
            [
                'pays' => Pays::where('nom', 'Mozambique')->first(['id'])->id,
                'valeur' => 258,
            ],
            [
                'pays' => Pays::where('nom', 'Namibie')->first(['id'])->id,
                'valeur' => 264,
            ],
            [
                'pays' => Pays::where('nom', 'Nauru')->first(['id'])->id,
                'valeur' => 674,
            ],
            [
                'pays' => Pays::where('nom', 'Népal')->first(['id'])->id,
                'valeur' => 977,
            ],
            [
                'pays' => Pays::where('nom', 'Nicaragua')->first(['id'])->id,
                'valeur' => 505,
            ],
            [
                'pays' => Pays::where('nom', 'Niger')->first(['id'])->id,
                'valeur' => 227,
            ],
            [
                'pays' => Pays::where('nom', 'Nigéria')->first(['id'])->id,
                'valeur' => 234,
            ],
            [
                'pays' => Pays::where('nom', 'Norvège')->first(['id'])->id,
                'valeur' => 47,
            ],
            [
                'pays' => Pays::where('nom', 'Nouvelle-Zélande')->first(['id'])->id,
                'valeur' => 64,
            ],
            [
                'pays' => Pays::where('nom', 'Oman')->first(['id'])->id,
                'valeur' => 968,
            ],
            [
                'pays' => Pays::where('nom', 'Ouganda')->first(['id'])->id,
                'valeur' => 256,
            ],
            [
                'pays' => Pays::where('nom', 'Ouzbékistan')->first(['id'])->id,
                'valeur' => 998,
            ],
            [
                'pays' => Pays::where('nom', 'Pakistan')->first(['id'])->id,
                'valeur' => 92,
            ],
            [
                'pays' => Pays::where('nom', 'Palaos')->first(['id'])->id,
                'valeur' => 680,
            ],
            [
                'pays' => Pays::where('nom', 'Palestine')->first(['id'])->id,
                'valeur' => 970,
            ],
            [
                'pays' => Pays::where('nom', 'Panama')->first(['id'])->id,
                'valeur' => 507,
            ],
            [
                'pays' => Pays::where('nom', 'Papouasie-Nouvelle-Guinée')->first(['id'])->id,
                'valeur' => 675,
            ],
            [
                'pays' => Pays::where('nom', 'Paraguay')->first(['id'])->id,
                'valeur' => 595,
            ],
            [
                'pays' => Pays::where('nom', 'Pays-Bas')->first(['id'])->id,
                'valeur' => 31,
            ],
            [
                'pays' => Pays::where('nom', 'Pérou')->first(['id'])->id,
                'valeur' => 51,
            ],
            [
                'pays' => Pays::where('nom', 'Philippines')->first(['id'])->id,
                'valeur' => 63,
            ],
            [
                'pays' => Pays::where('nom', 'Pologne')->first(['id'])->id,
                'valeur' => 48,
            ],
            [
                'pays' => Pays::where('nom', 'Portugal')->first(['id'])->id,
                'valeur' => 351,
            ],
            [
                'pays' => Pays::where('nom', 'Qatar')->first(['id'])->id,
                'valeur' => 974,
            ],
            [
                'pays' => Pays::where('nom', 'Roumanie')->first(['id'])->id,
                'valeur' => 40,
            ],
            [
                'pays' => Pays::where('nom', 'Royaume-Uni')->first(['id'])->id,
                'valeur' => 44,
            ],
            [
                'pays' => Pays::where('nom', 'Russie')->first(['id'])->id,
                'valeur' => 7,
            ],
            [
                'pays' => Pays::where('nom', 'Rwanda')->first(['id'])->id,
                'valeur' => 250,
            ],
            [
                'pays' => Pays::where('nom', 'Saint-Christophe-et-Niévès')->first(['id'])->id,
                'valeur' => 1,
            ],
            [
                'pays' => Pays::where('nom', 'Saint-Marin')->first(['id'])->id,
                'valeur' => 378,
            ],
            [
                'pays' => Pays::where('nom', 'Saint-Vincent-et-les-Grenadines')->first(['id'])->id,
                'valeur' => 1,
            ],
            [
                'pays' => Pays::where('nom', 'Sainte-Lucie')->first(['id'])->id,
                'valeur' => 1,
            ],
            [
                'pays' => Pays::where('nom', 'Salvador')->first(['id'])->id,
                'valeur' => 503,
            ],
            [
                'pays' => Pays::where('nom', 'Samoa')->first(['id'])->id,
                'valeur' => 685,
            ],
            [
                'pays' => Pays::where('nom', 'Sao Tomé-et-Principe')->first(['id'])->id,
                'valeur' => 239,
            ],
            [
                'pays' => Pays::where('nom', 'Sénégal')->first(['id'])->id,
                'valeur' => 221,
            ],
            [
                'pays' => Pays::where('nom', 'Serbie')->first(['id'])->id,
                'valeur' => 381,
            ],
            [
                'pays' => Pays::where('nom', 'Seychelles')->first(['id'])->id,
                'valeur' => 248,
            ],
            [
                'pays' => Pays::where('nom', 'Sierra Leone')->first(['id'])->id,
                'valeur' => 232,
            ],
            [
                'pays' => Pays::where('nom', 'Singapour')->first(['id'])->id,
                'valeur' => 65,
            ],
            [
                'pays' => Pays::where('nom', 'Slovaquie')->first(['id'])->id,
                'valeur' => 421,
            ],
            [
                'pays' => Pays::where('nom', 'Slovénie')->first(['id'])->id,
                'valeur' => 386,
            ],
            [
                'pays' => Pays::where('nom', 'Somalie')->first(['id'])->id,
                'valeur' => 252,
            ],
            [
                'pays' => Pays::where('nom', 'Soudan')->first(['id'])->id,
                'valeur' => 249,
            ],
            [
                'pays' => Pays::where('nom', 'Soudan du Sud')->first(['id'])->id,
                'valeur' => 211,
            ],
            [
                'pays' => Pays::where('nom', 'Sri Lanka')->first(['id'])->id,
                'valeur' => 94,
            ],
            [
                'pays' => Pays::where('nom', 'Suède')->first(['id'])->id,
                'valeur' => 46,
            ],
            [
                'pays' => Pays::where('nom', 'Suisse')->first(['id'])->id,
                'valeur' => 41,
            ],
            [
                'pays' => Pays::where('nom', 'Suriname')->first(['id'])->id,
                'valeur' => 597,
            ],
            [
                'pays' => Pays::where('nom', 'Syrie')->first(['id'])->id,
                'valeur' => 963,
            ],
            [
                'pays' => Pays::where('nom', 'Tadjikistan')->first(['id'])->id,
                'valeur' => 992,
            ],
            [
                'pays' => Pays::where('nom', 'Tanzanie')->first(['id'])->id,
                'valeur' => 255,
            ],
            [
                'pays' => Pays::where('nom', 'Tchad')->first(['id'])->id,
                'valeur' => 235,
            ],
            [
                'pays' => Pays::where('nom', 'Tchéquie')->first(['id'])->id,
                'valeur' => 420,
            ],
            [
                'pays' => Pays::where('nom', 'Thaïlande')->first(['id'])->id,
                'valeur' => 66,
            ],
            [
                'pays' => Pays::where('nom', 'Timor-Leste')->first(['id'])->id,
                'valeur' => 670,
            ],
            [
                'pays' => Pays::where('nom', 'Togo')->first(['id'])->id,
                'valeur' => 228,
            ],
            [
                'pays' => Pays::where('nom', 'Tonga')->first(['id'])->id,
                'valeur' => 676,
            ],
            [
                'pays' => Pays::where('nom', 'Trinité-et-Tobago')->first(['id'])->id,
                'valeur' => 1,
            ],
            [
                'pays' => Pays::where('nom', 'Tunisie')->first(['id'])->id,
                'valeur' => 216,
            ],
            [
                'pays' => Pays::where('nom', 'Turkménistan')->first(['id'])->id,
                'valeur' => 993,
            ],
            [
                'pays' => Pays::where('nom', 'Turquie')->first(['id'])->id,
                'valeur' => 90,
            ],
            [
                'pays' => Pays::where('nom', 'Tuvalu')->first(['id'])->id,
                'valeur' => 688,
            ],
            [
                'pays' => Pays::where('nom', 'Ukraine')->first(['id'])->id,
                'valeur' => 380,
            ],
            [
                'pays' => Pays::where('nom', 'Uruguay')->first(['id'])->id,
                'valeur' => 598,
            ],
            [
                'pays' => Pays::where('nom', 'Vanuatu')->first(['id'])->id,
                'valeur' => 678,
            ],
            [
                'pays' => Pays::where('nom', 'Vatican')->first(['id'])->id,
                'valeur' => 39,
            ],
            [
                'pays' => Pays::where('nom', 'Venezuela')->first(['id'])->id,
                'valeur' => 58,
            ],
            [
                'pays' => Pays::where('nom', 'Viêt Nam')->first(['id'])->id,
                'valeur' => 84,
            ],
            [
                'pays' => Pays::where('nom', 'Yémen')->first(['id'])->id,
                'valeur' => 967,
            ],
            [
                'pays' => Pays::where('nom', 'Zambie')->first(['id'])->id,
                'valeur' => 260,
            ],
            [
                'pays' => Pays::where('nom', 'Zimbabwe')->first(['id'])->id,
                'valeur' => 263,
            ],
        ]);

        echo IndicatifTelephonique::count()." indicatif(s) téléphonique(s) créé(s).\n";
    }
}
