<!DOCTYPE html>
<html>
<head>
    <title>Notification de Mise à Jour du Profil Utilisateur</title>
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
    <h1>Notification de Mise à Jour du Profil Utilisateur</h1>

    <p>Bonjour {{ $utilisateur->prenom }},</p>

    <p>Nous vous informons que votre profil sur notre plateforme a été mis à jour avec succès.</p>

    <p>Voici les informations mises à jour :</p>
    <ul>
        @if($utilisateur->nom)
        <li>Nom : {{ $utilisateur->nom }}</li>
        @endif

        @if($utilisateur->email)
        <li>Adresse email : {{ $utilisateur->email }}</li>
        @endif

        @if($utilisateur->telephone)
        <li>Téléphone : {{ $utilisateur->telephone }}</li>
        @endif

        @if($utilisateur->boitePostale)
        <li>Boîte postale : {{ $utilisateur->boitePostale }}</li>
        @endif

        @if($utilisateur->siteWeb)
        <li>Site Web : <a href="{{ $utilisateur->siteWeb }}">{{ $utilisateur->siteWeb }}</a></li>
        @endif

        @if($utilisateur->description)
        <li>Description : {{ $utilisateur->description }}</li>
        @endif
    </ul>

    <p>Si vous n'avez pas effectué ces modifications, veuillez nous contacter immédiatement pour vérifier et résoudre le problème.</p>

    <p>Nous vous remercions d'avoir maintenu vos informations à jour. Si vous avez des questions ou avez besoin d'assistance, n'hésitez pas à nous contacter via <a href="mailto:assistance@votreplateforme.com">assistance@votreplateforme.com</a>.</p>

    <p>Merci,</p>

    <p>L'équipe de la plateforme</p>
</body>
</html>
