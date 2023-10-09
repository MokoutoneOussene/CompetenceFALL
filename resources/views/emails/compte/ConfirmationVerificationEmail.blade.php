<!DOCTYPE html>
<html>
<head>
    <title>Vérification d'adresse email - {{ env('APP_NAME') }}</title>
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

    <p>Félicitations ! Votre adresse email a été vérifiée avec succès sur {{ env('APP_NAME') }}. Cela signifie que vous pouvez désormais profiter pleinement de nos services et rester informé(e) des dernières mises à jour.</p>

    <p>Nous sommes heureux de vous compter parmi notre communauté dédiée aux ressources humaines. Votre compte est désormais activé et vous pouvez commencer à explorer nos formations en ligne, parcourir nos offres d'emploi et accéder à nos autres services RH.</p>

    <p>Si vous avez des questions, des suggestions ou si vous avez besoin d'assistance, n'hésitez pas à nous contacter via <a href="mailto:assistance@competenceforall.com">assistance@competenceforall.com</a>. Notre équipe est là pour vous aider dans votre parcours professionnel.</p>

    <p>Merci de nous rejoindre sur {{ env('APP_NAME') }} ! ous sommes convaincus que notre plateforme vous aidera à atteindre vos objectifs professionnels.</p>

    <p>Cordialement,<br>
        L'équipe de {{ env('APP_NAME') }}
    </p>
</body>
</html>
