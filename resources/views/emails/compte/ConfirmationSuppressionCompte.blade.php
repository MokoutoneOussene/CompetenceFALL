<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de suppression de compte sur {{ env('APP_NAME') }}.</title>
    <style>
        /* Styles CSS pour le corps de l'e-mail */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f0f5ff; /* Light Blue Background */
        }

        /* Styles CSS pour le conteneur principal de l'e-mail */
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #ffffff; /* White Background */
        }

        /* Styles CSS pour les titres */
        h1 {
            color: #007BFF; /* Blue Heading Text */
        }

        /* Styles CSS pour les liens */
        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Styles CSS pour le paragraphe de remerciement */
        .thanks {
            color: #007BFF; /* Blue Text for Thanks Message */
            font-weight: bold;
        }

        /* Styles CSS pour la signature de l'équipe */
        .signature {
            color: #007BFF; /* Blue Text for Signature */
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Confirmation de suppression de compte sur {{ env('APP_NAME') }}.</h1>
        <p class="thanks">Cher/chère {{ $utilisateur->nom }},</p>
        <p>Nous avons bien reçu votre demande de suppression de compte sur {{ env('APP_NAME') }}.</p>
        <p>Nous tenons à vous remercier pour le temps que vous avez passé sur notre plateforme et nous sommes désolés de vous voir partir.</p>
        <p>Votre compte a été supprimé avec succès, et toutes vos informations ont été effacées de notre base de données conformément à notre politique de confidentialité.</p>
        <p>Si vous décidez de revenir à l'avenir, nous serons heureux de vous accueillir à nouveau.</p>
        <p>Si vous avez des commentaires ou des suggestions sur votre expérience avec {{ env('APP_NAME') }}, n'hésitez pas à nous les transmettre.</p>
        <p>Encore une fois, merci pour votre confiance et votre participation à notre communauté.</p>
        <p class="signature">L'équipe de {{ env('APP_NAME') }}</p>
    </div>
</body>
</html>
