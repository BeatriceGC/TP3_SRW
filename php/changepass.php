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

<div id="wrapper">
    <form id="myForm" name="myForm" action="action_changepass.php" method="post">
        <div class="inputs" id="divName">
            <label for="name">Ancien mot de passe :</label>
            <input type="password" name="old" maxlength="12" id="name" placeholder="Votre ancien mot de passe" />
        </div>

        <div class="inputs">
            <label for="password">Nouveau mot de passe :</label>
            <input type="password" name="password" maxlength="12" id="password" placeholder="Entrez votre nouveau mot de passe" />
        </div>

        <div class="inputs">
            <label for="password2">Confirmer le nouveau mot de passe :</label>
            <input type="password" name="password2" maxlength="12" id="password2" placeholder="Confirmer votre nouveau mot de passe" />
        </div>

        <div class="errorUser" id="error_password">Les mots de passe se dévisagent sans se reconnaitre :/</div>

        <div id="complexity">
            <div></div>
            <div>Complexité : <span id="complexity_span"></span></div>
            <div id="complexity_div"></div>
        </div>

        <input id="validate" type="submit" value="Confirmer">
    </form>
</div>

<footer>
    <div></div>
    <div>Hadrien BELLEVILLE - <a href="https://www.linkedin.com/in/b%C3%A9atrice-garcia-cegarra-bb6a841a2/">Béatrice GARCIA CEGARRA</a></div>
    <div>Travail Pratique #3</div>
    <div><a href="https://cours.uqac.ca/8INF138">8INF138 - Sécurité des Réseaux et du Web</a></div>
</footer>
</body>
</html>