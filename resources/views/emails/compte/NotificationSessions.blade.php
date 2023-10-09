<!DOCTYPE html>
<html>
<head>
    <title>Sessions Actives</title>
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
    <h1>Sessions Actives</h1>

    <p>Bonjour {{ $utilisateur->prenom }},</p>

    <p>Voici la liste de vos sessions actives sur notre plateforme :</p>
    <ul>
        @foreach($sessionsActives as $session)
            <li>{{ $session->user_agent }} - {{ $session->ip_address }} ({{ $session->last_activity->diffForHumans() }})</li>
        @endforeach
    </ul>

    <p>Si vous remarquez des sessions suspectes ou des activités inhabituelles, veuillez nous contacter immédiatement pour assurer la sécurité de votre compte.</p>

    <p>Merci,</p>

    <p>L'équipe de la plateforme</p>
</body>
</html>
