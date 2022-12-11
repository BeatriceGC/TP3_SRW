<!DOCTYPE html>

<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>TP3_SRW Client d'Affaires</title>

        <link href="../css/affichage.css" rel="stylesheet" type="text/css" />

        <script type="text/javascript" src="../js/changeMdP.js"></script>
        <script type="text/javascript" src="../js/manageComplexity.js"></script>
        <script type="text/javascript" src="../js/mainAffichage.js"></script>
    </head>

    <body>
        <header id="header">
            <h1>CLIENT D'AFFAIRES :  <span id="SessionID">Michel LADEMO</span></h1>
            <p>WAOUH, votre liste de clients préférés en temps réel prête à l'emploi !</p>
        </header>

        <div id="options">
            <button onclick="changeWrapper(0)">Affichage des Clients <br>d'Affaires</button>
            <button onclick="changeWrapper(1)">Modification du mot de passe</button>
            <button>Déconnexion</button>
        </div>

        <div class="wrapper" id="wrapAffaire">
            <h2>Clients d'Affaires</h2>
            <div class="user">
                <span class="FirstName">Allain</span>
                <span class="LastName">DUPONT</span>
            </div>
        </div>

        <div class="wrapper" id="wrapMdP">
            <div class="user">
                <h2>Modification du Mot de Passe</h2>

                <div class="inputs">
                    <span>Ancien Mot de passe :</span>
                    <input type="password" name="last_password" maxlength="12" id="last_password" placeholder="enter your current password" />
                </div>
                <div class="errorUser" id="error_lastpassword">Le mot de passe est invalide, WTF</div>

                <div class="inputs">
                    <span>Nouveau mot de passe :</span>
                    <input type="password" name="password" maxlength="12" id="password" placeholder="enter your new password" />
                </div>

                <div class="inputs">
                    <span>Confirmation nouveau Mot de passe :</span>
                    <input type="password" name="confirm_password" maxlength="12" id="confirm_password" placeholder="confirm your new password" />
                </div>
                <div class="errorUser" id="error_password">Les mots de passe se dévisagent sans se reconnaitre :/</div>

                <div id="complexity">
                    <div></div>
                    <div>Complexité : <span id="complexity_span"></span></div>
                    <div id="complexity_div"></div>
                </div>
                <button id="checkMdP" onclick="changeMdP()">valider</button>
            </div>
        </div>

        <a href="../index.html"><button>Index</button></a>
        <a href="admin.php"><button>admin</button></a>
        <a href="residentielClient.html"><button>Residentiel Client</button></a>

        <footer>
            <div></div>
            <div>Hadrien BELLEVILLE - <a href="https://www.linkedin.com/in/b%C3%A9atrice-garcia-cegarra-bb6a841a2/">Béatrice GARCIA CEGARRA</a></div>
            <div>Travail Pratique #3</div>
            <div><a href="https://cours.uqac.ca/8INF138">8INF138 - Sécurité des Réseaux et du Web</a></div>
        </footer>
    </body>
</html>