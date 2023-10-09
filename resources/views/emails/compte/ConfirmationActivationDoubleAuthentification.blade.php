<!DOCTYPE html>
<html>
<head>
    <title>Félicitations pour l'Activation de la Double Authentification</title>
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
    <h1>Félicitations pour l'Activation de la Double Authentification !</h1>

    <p>Bonjour {{ $utilisateur->nom }},</p>

    <p>Nous tenons à vous féliciter d'avoir activé avec succès la Double Authentification (2FA) sur votre compte. Votre sécurité en ligne est maintenant renforcée grâce à cette mesure de protection supplémentaire.</p>

    <p>A partir de maintenant, lorsque vous vous connecterez à votre compte, vous devrez fournir un code d'authentification unique généré par votre application d'authentification 2FA.</p>

    <p>Nous vous encourageons à garder votre code d'authentification en lieu sûr et à ne pas le partager avec qui que ce soit. Si vous suspectez une activité inhabituelle sur votre compte, veuillez nous contacter immédiatement pour assurer la sécurité de votre compte.</p>

    <p>Nous apprécions votre engagement envers la sécurité de votre compte et la protection de vos données personnelles.</p>

    <p>Si vous avez des questions ou avez besoin d'assistance, n'hésitez pas à nous contacter via <a href="mailto:assistance@votreplateforme.com">assistance@votreplateforme.com</a>.</p>

    <p>Encore une fois, félicitations pour cette étape vers une sécurité renforcée !</p>

    <p>Merci,</p>

    <p>L'équipe de la plateforme</p>
</body>
</html>
