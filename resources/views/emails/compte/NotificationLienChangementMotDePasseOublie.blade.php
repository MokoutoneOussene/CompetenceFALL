<!DOCTYPE html>
<html>
<head>
    <title>Réinitialisation de Mot de Passe</title>
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
    <h1>Réinitialisation de Mot de Passe</h1>

    <p>Bonjour,</p>

    <p>Nous avons reçu une demande de réinitialisation de mot de passe pour votre compte. Veuillez remplir les informations requises ci-dessous pour effectuer le changement :</p>

    <form action="{{ route('route_pour_reinitialisation') }}" method="POST">
        @csrf

        <label for="email">Adresse e-mail :</label>
        <input type="email" name="email" id="email" required><br>

        <label for="jetonEmail">Jeton d'Email :</label>
        <input type="text" name="jetonEmail" id="jetonEmail" required><br>

        <label for="nouveauMotDePasse">Nouveau Mot de Passe :</label>
        <input type="password" name="nouveauMotDePasse" id="nouveauMotDePasse" required><br>

        <label for="confirmationMotDePasse">Confirmer le Nouveau Mot de Passe :</label>
        <input type="password" name="confirmationMotDePasse" id="confirmationMotDePasse" required><br>

        <button type="submit" class="btn">Réinitialiser le Mot de Passe</button>
    </form>

    <p>Si vous n'avez pas demandé cette réinitialisation, veuillez ignorer ce message. Votre compte restera sécurisé.</p>

    <p>Si vous avez des questions ou avez besoin d'assistance, n'hésitez pas à nous contacter via <a href="mailto:assistance@votreplateforme.com">assistance@votreplateforme.com</a>.</p>

    <p>Merci,</p>

    <p>L'équipe de la plateforme</p>
</body>
</html>
