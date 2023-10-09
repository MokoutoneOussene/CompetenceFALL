<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code OTP pour la double authentification sur {{ env('APP_NAME') }}</title>
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

        /* Styles CSS pour le paragraphe d'instruction */
        .instructions {
            color: #007BFF; /* Blue Text for Instruction Message */
            font-weight: bold;
        }

        /* Styles CSS pour le code OTP */
        .otp-code {
            font-size: 24px;
            font-weight: bold;
            color: #007BFF; /* Blue Text for OTP Code */
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
        <h1>Code OTP pour la double authentification sur {{ env('APP_NAME') }}</h1>
        <p class="instructions">Cher/chère {{ $utilisateur->nom }},</p>
        <p>La double authentification est active sur votre compte.</p>
        <p>Veuillez utiliser le code OTP ci-dessous :</p>
        <p class="otp-code">{{ $utilisateur->codeOTP }}</p>
        <p>Ce code OTP est valable pour une seule utilisation et expirera le {{ $utilisateur->dateCodeOTP }}.</p>
        <p>Si vous avez des questions ou besoin d'aide, n'hésitez pas à nous contacter via <a href="mailto:{{ env('MAIL_ADRESS') }}">{{ env('MAIL_ADRESS') }}</a> ou en utilisant notre formulaire de contact sur le site.</p>
        <p class="signature">L'équipe de {{ env('APP_NAME') }}</p>
    </div>
</body>
</html>
