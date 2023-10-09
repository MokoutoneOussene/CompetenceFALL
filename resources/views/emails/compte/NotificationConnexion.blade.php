<!DOCTYPE html>
<html>
<head>
    <title>Notification de Connexion Réussie</title>
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
    <h1>Notification de Connexion Réussie</h1>

    <p>Bonjour {{ $utilisateur->nom }},</p>

    <p>Nous vous informons que vous vous êtes connecté avec succès à votre compte sur notre plateforme.</p>

    <p>Si cette connexion ne provient pas de vous ou si vous remarquez une activité suspecte sur votre compte, veuillez nous contacter immédiatement pour assurer la sécurité de vos informations.</p>

    <p>Nous vous remercions pour votre confiance en notre plateforme. Si vous avez des questions ou avez besoin d'assistance, n'hésitez pas à nous contacter via <a href="mailto:assistance@votreplateforme.com">assistance@votreplateforme.com</a>.</p>

    <p>Merci,</p>

    <p>L'équipe de la plateforme</p>
</body>
</html>
