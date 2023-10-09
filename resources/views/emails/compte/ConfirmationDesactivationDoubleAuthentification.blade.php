<!DOCTYPE html>
<html>
<head>
    <title>Félicitations pour la Désactivation de la Double Authentification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }

        h1, h2 {
            color: #1a237e;
        }

        a {
            color: #1a237e;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Félicitations pour la Désactivation de la Double Authentification !</h1>

    <p>Bonjour {{ $utilisateur->nom }},</p>

    <p>Nous tenons à vous féliciter d'avoir réussi à désactiver avec succès la Double Authentification (2FA) sur votre compte. Votre compte sera désormais accessible avec votre mot de passe seul.</p>

    <p>Si vous avez effectué cette désactivation, il est important de vous assurer que votre mot de passe est sécurisé et de ne pas le divulguer à d'autres personnes.</p>

    <p>Si vous n'avez pas effectué cette désactivation, veuillez nous contacter immédiatement pour assurer la sécurité de votre compte.</p>

    <p>Nous apprécions votre vigilance envers la sécurité de votre compte et la protection de vos données personnelles.</p>

    <p>Si vous avez des questions ou avez besoin d'assistance, n'hésitez pas à nous contacter via <a href="mailto:assistance@votreplateforme.com">assistance@votreplateforme.com</a>.</p>

    <p>Encore une fois, félicitations pour cette mesure de sécurité !</p>

    <p>Merci,</p>

    <p>L'équipe de la plateforme</p>
</body>
</html>
