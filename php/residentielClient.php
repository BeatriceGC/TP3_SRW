<!DOCTYPE html>

<?php
session_start();
if(!isset($_SESSION['login']) or $_SESSION['role'] != "residentielClient"){
    session_destroy();
    header("Location:../index.html");
    exit;
}
?>

<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>TP3_SRW Client Residentiel</title>

        <link href="../css/affichage.css" rel="stylesheet" type="text/css" />

        <script type="text/javascript" src="../js/changeMdP.js"></script>
        <script type="text/javascript" src="../js/manageComplexity.js"></script>
        <script type="text/javascript" src="../js/mainAffichage.js"></script>
    </head>

    <body>
        <header id="header">
            <h1>CLIENT RÉSIDENTIEL :  <span id="SessionID"><?php
                    echo $_SESSION['login'] . " ";
                    echo $_SESSION['role'];
                    ?></span></h1>
            <p>WAOUH, votre liste de clients préférés en temps réel prête à l'emploi !</p>
        </header>

        <div id="options">
            <button onclick="changeWrapper(0)">Affichage des Clients Résidentiels</button>
            <button onclick="changeWrapper(1)">Modification du mot de passe</button>
            <a href="deconnexion.php"><button>Déconnexion</button></a>
        </div>

        <div class="wrapper" id="wrapResidentiel">
            <h2>Clients Résidentiels</h2>
            <div class="user">
                <span class="FirstName">Bill</span>
                <span class="LastName">BOCQUET</span>
            </div>
        </div>

        <div class="wrapper" id="wrapMdP">
            <div class="user">
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
            <div>Hadrien BELLEVILLE - Béatrice GARCIA CEGARRA - Bilal SAFI</div>
            <div>Travail Pratique #3</div>
            <div><a href="https://cours.uqac.ca/8INF138">8INF138 - Sécurité des Réseaux et du Web</a></div>
        </footer>
    </body>
</html>