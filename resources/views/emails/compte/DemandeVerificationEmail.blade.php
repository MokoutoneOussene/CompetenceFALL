<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmez votre adresse email sur {{ env('APP_NAME') }} !</title>
    <style>
        /* Styles CSS pour le corps de l'e-mail */
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
    <div class="container">
        <h1>Confirmez votre adresse email sur {{ env('APP_NAME') }} !</h1>
        <p class="instructions">Bonjour {{ $utilisateur->nom }},</p>
        <p>Nous sommes ravis que vous ayez rejoint notre communauté sur {{ env('APP_NAME') }} !</p>
        <p>Pour profiter pleinement de nos services, veuillez confirmer votre adresse e-mail en suivant le lien ci-dessous :</p>
        <p><a href={{ route('cfai.auth.compte.verifierEmail') . '?email=' . $utilisateur->email . '&jetonEmail=' . $utilisateur->jetonEmail }} class="btn">Lien de vérification</a></p>
		<p>Le lien de vérification est valable jusqu'au {{ $utilisateur->dateJetonEmail }}. Assurez-vous de le confirmer avant cette date.</p>
		<p>Une fois votre adresse e-mail confirmée, vous serez membre vérifié de notre plateforme et pourrez accéder à toutes ses fonctionnalités.</p>
        <p>N'hésitez pas à explorer notre site pour découvrir une multitude de services proposés par notre communauté d'utilisateurs.</p>
        <p>Si vous avez des questions ou besoin d'aide, n'hésitez pas à nous contacter via <a href="mailto:{{ env('MAIL_ADRESS') }}">{{ env('MAIL_ADRESS') }}</a> ou en utilisant notre formulaire de contact sur le site.</p>
        <p class="thank-you">Merci encore de nous rejoindre !</p>
        <p class="signature">L'équipe de {{ env('APP_NAME') }}</p>
    </div>
</body>
</html>
