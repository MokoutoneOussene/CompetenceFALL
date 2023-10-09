<!DOCTYPE html>
<html>
<head>
    <title>Bienvenue sur [Nom de la plateforme RH] !</title>
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

        .btn {
            display: inline-block;
            background-color: #ff5722;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Cher/chère {{ $utilisateur->nom }},</h1>

    <p>Bienvenue sur {{ env('APP_NAME') }} ! Nous sommes ravis de vous accueillir dans notre communauté. Vous venez de créer avec succès votre compte, et nous sommes impatients de vous aider à développer vos compétences et à explorer de nouvelles opportunités professionnelles.</p>

    <h2>Détails de votre compte :</h2>
    <ul>
        <li>Nom d'utilisateur : {{ $utilisateur->nom }}</li>
        <li>Adresse email : {{ $utilisateur->email }}</li>

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

    <p>Pour commencer, nous vous recommandons de :</p>
    <ol>
        <li>Explorer nos formations en ligne : Accédez à notre catalogue de formations variées, conçues pour améliorer vos compétences et enrichir votre parcours professionnel. <a href="{{ route('cfai.ano.formations.lister') }}">Voir les formations</a></li>
        <li>Parcourir nos offres d'emploi : Consultez nos annonces d'emploi régulièrement mises à jour pour trouver des opportunités correspondant à votre profil. <a href="{{ route('cfai.roo.emplois.lister') }}">Voir les offres d'emploi</a></li>
        <li>Découvrir nos autres services RH : Profitez de nos autres services, tels que l'audit, l'externalistion, les études, la consultation, le coaching, les formations pour bénéficier d'une expérience complète et adaptée à vos besoins.</li>
    </ol>

    <p>Avant de plonger dans notre plateforme, veuillez prendre un instant pour vérifier votre adresse email en cliquant sur le lien ci-dessous. Cela nous permettra de vous tenir informé(e) des dernières mises à jour et de vous aider en cas de besoin.</p>
    <a href="{{ route('cfai.auth.compte.verifierEmail') . '?email=' . $utilisateur->email . '&jetonEmail=' . $utilisateur->jetonEmail }}" class="btn">Vérifier mon adresse email</a>

    <p>La confidentialité et la sécurité de vos données sont primordiales pour nous. Pour en savoir plus sur notre politique de confidentialité, veuillez consulter le lien ci-dessous :</p>
    <a href="{{ route('cfai.ano.politiques.lister') }}">Politiques de la plateforme.</a>

    <p>Si vous avez des questions, besoin d'assistance ou si vous rencontrez des problèmes, n'hésitez pas à contacter notre équipe d'assistance dédiée à tout moment via <a href="assistance@competenceforall.com">assistance@competenceforall.com</a>.</p>

    <p>Encore une fois, bienvenue sur {{ env('APP_NAME') }} ! Nous sommes convaincus que vous allez tirer le meilleur parti de nos services pour développer votre carrière et vos compétences professionnelles.</p>

    <p>Cordialement,<br>
        L'équipe de la plateforme {{ env('APP_NAME') }}
    </p>
</body>
</html>
