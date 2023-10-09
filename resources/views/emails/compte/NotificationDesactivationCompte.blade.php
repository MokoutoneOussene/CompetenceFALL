<!DOCTYPE html>
<html>
<head>
    <title>Notification de Désactivation de Compte</title>
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
    <h1>Notification de Désactivation de Compte</h1>

    <p>Bonjour {{ $utilisateur->nom }},</p>

    <p>Nous vous informons que votre compte sur notre plateforme a été désactivé.</p>

    <p>Si vous n'avez pas demandé la désactivation de votre compte, veuillez nous contacter immédiatement pour vérifier et résoudre le problème.</p>

    <p>Nous vous remercions pour le temps que vous avez passé sur notre plateforme. Si vous avez des questions ou avez besoin d'assistance, n'hésitez pas à nous contacter via <a href="mailto:assistance@votreplateforme.com">assistance@votreplateforme.com</a>.</p>

    <p>Merci,</p>

    <p>L'équipe de la plateforme</p>
</body>
</html>
