<!DOCTYPE html>
<html>
<head>
    <title>Notification d'Activation de Compte</title>
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
    <h1>Notification d'Activation de Compte</h1>

    <p>Bonjour {{ $utilisateur->nom }},</p>

    <p>Votre compte sur notre plateforme a été activé avec succès ! Vous êtes maintenant membre de notre communauté.</p>

    <p>Vous pouvez désormais vous connecter à votre compte en utilisant votre adresse email et votre mot de passe.</p>

    <p>Si vous n'avez pas créé de compte sur notre plateforme, veuillez nous contacter immédiatement pour assurer la sécurité de vos informations personnelles.</p>

    <p>Nous vous souhaitons une excellente expérience sur notre plateforme. Si vous avez des questions ou avez besoin d'assistance, n'hésitez pas à nous contacter via <a href="mailto:assistance@votreplateforme.com">assistance@votreplateforme.com</a>.</p>

    <p>Merci,</p>

    <p>L'équipe de la plateforme</p>
</body>
</html>
