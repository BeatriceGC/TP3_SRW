<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>TP3_SRW</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet" type="text/css">

    <link href="../css/styles.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="../js/JSONComplexity.js"></script>
    <script type="text/javascript" src="../js/manageComplexity.js"></script>

    <script type="text/javascript" src="../js/mainIndex.js"></script>
</head>

<body>
<header id="header">
    <h1>Application sûre 2.0</h1>
    <p>Bienvenue sur cette application sécurisée !<br>Ici vous pouvez changer votre mot de passe en toute sécurité !</p>
</header>

<div class="wrapper">
    <h2>Changement de mot de passe</h2>

    <form class="myForm" id="myForm_forgot" name="myForm_forgot" action="action_changepass.php" method="post">
        <div class="inputs" class="divName" id="divName_forgot">
            <span>Prénom NOM :</span>
            <input type="text" name="name_sign" id="name_forgot" class="name" placeholder="the name of your account" required />
        </div>

        <div class="inputs">
            <span>Identifiant :</span>
            <input type="email" name="email_sign" id="email_forgot" class="email" placeholder="enter your e-mail" required />
        </div>

        <div class="inputs" id="change_password">
            <span>Nouveau Mot de Passe :</span>
            <input type="password" name="password_change" maxlength="12" id="password_change" class="password" placeholder="enter your new password" required />
        </div>

        <div class="inputs" id="change_password">
            <span>Confirmation :</span>
            <input type="password" name="confirm_password_change" maxlength="12" id="password_change" class="password" placeholder="confirm your password" required />
        </div>

        <input id="validate_forgot" class="validate" type="submit" value="Changer mon mot de passe">
    </form>
    <button class="switch" id="switchLog2" onclick="switchMode()">Retour vers une connexion sécurisée</button>
</div>

<footer>
    <div></div>
    <div>Hadrien BELLEVILLE - <a href="https://www.linkedin.com/in/b%C3%A9atrice-garcia-cegarra-bb6a841a2/">Béatrice GARCIA CEGARRA</a></div>
    <div>Travail Pratique #3</div>
    <div><a href="https://cours.uqac.ca/8INF138">8INF138 - Sécurité des Réseaux et du Web</a></div>
</footer>
</body>
</html>