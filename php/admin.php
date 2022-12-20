<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION['login']) or $_SESSION['role'] != "adminClient"){
    session_destroy();
    header("Location:../index.html");
    exit;
}
?>

<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>TP3_SRW Admin</title>

        <link href="../css/admin.css" rel="stylesheet" type="text/css" />

        <script type="text/javascript" src="../js/manageComplexity.js"></script>
        <script type="text/javascript" src="../js/manageSettings.js"></script>
        <script type="text/javascript" src="../js/changeMdP.js"></script>

        <script type="text/javascript" src="../js/mainAdmin.js"></script>
    </head>

    <body>
        <header id="header">
            <h1>ADMINISTRATEUR :  <span id="SessionID"><?php
                    echo $_SESSION['login'] . " ";
                    echo $_SESSION['role'];
            ?></span></h1>
            <p>Administrez votre site Web et gérez ses options de sécurité de façon super secrète</p>
        </header>

        <div id="options">
            <button onclick="changeWrapper(2)">Affichage des Clients Résidentiels</button>
            <button onclick="changeWrapper(1)">Affichage des Clients d'Affaires</button>
            <button onclick="changeWrapper(0)">Modification des paramètres de sécurité</button>
            <button onclick="changeWrapper(3)">Modification du mot de passe</button>
            <a href="deconnexion.php"><button>Déconnexion</button></a>
        </div>

        <div class="wrapper" id="wrapReglages">
            <form class="user">
                <h2>Complexité des Mots de Passe</h2>
                <div id="complexitySettings">
                    <div class="settingTitle">Paramètre</div>
                    <div class="settingTitle">Minimal</div>
                    <div class="settingTitle">Moyen</div>
                    <div class="settingTitle">Optimal</div>

                    <div class="settingCategory">Nombre de caractères</div>
                    <input type="number" name = "min_car" class="nbCara" value="" min="0" oninput="validity.valid||(value='');">
                    <input type="number" name = "med_car" class="nbCara" value="" min="0" oninput="validity.valid||(value='');">
                    <input type="number" name = "opti_car" class="nbCara" value="" min="0" oninput="validity.valid||(value='');">

                    <div class="settingCategory">Nombre de chiffres</div>
                    <input type="number" name = "min_digit" class="nbChiffres" value="" min="0" oninput="validity.valid||(value='');">
                    <input type="number" name = "med_digit" class="nbChiffres" value="" min="0" oninput="validity.valid||(value='');">
                    <input type="number" name = "opti_digit" class="nbChiffres" value="" min="0" oninput="validity.valid||(value='');">

                    <div class="settingCategory">Nombre de caractères spéciaux</div>
                    <input type="number" name = "min_spec" class="nbSpeciaux" value="" min="0" oninput="validity.valid||(value='');">
                    <input type="number" name = "med_spec" class="nbSpeciaux" value="" min="0" oninput="validity.valid||(value='');">
                    <input type="number" name = "opti_spec" class="nbSpeciaux" value="" min="0" oninput="validity.valid||(value='');">

                    <div class="settingCategory">Nombre de majuscules</div>
                    <input type="number" name = "min_maj" class="nbMaj" value="" min="0" oninput="validity.valid||(value='');">
                    <input type="number" name = "med_maj" class="nbMaj" value="" min="0" oninput="validity.valid||(value='');">
                    <input type="number" name = "opti_maj" class="nbMaj" value="" min="0" oninput="validity.valid||(value='');">
                </div>
                <button class="formButton" id="reset" onclick="setLastSettingsComplexity()">réinitialiser</button>
                <input class="formButton" id="validate" type="submit" value="Valider">
                <div class="error">Oh Oh... messing with number order</div>
            </form>

            <form class="user">
                <h2>Validité des Mots de Passe</h2>
                <div id="ValiditySettings">

                    <div class="grid2">
                        <div class="settingCategory"></div>
                        <div>Années</div>
                        <div>Mois</div>
                        <div>Jours</div>
                        <div></div>
                    </div>

                    <div class="grid2">
                        <div class="settingCategory">Durée de validité d'un mot de passe</div>
                        <input class="nbT1" name="years" type="number" value="" placeholder="années" min="0" oninput="validity.valid||(value='');">
                        <input class="nbT1" name="months" type="number" value="" placeholder="mois" min="0" oninput="validity.valid||(value='');">
                        <input class="nbT1" name="days" type="number" value="" placeholder="jours" min="0" oninput="validity.valid||(value='');">
                        <div></div>
                    </div>

                    <div class="grid1">
                        <div class="settingCategory">Nombre max de tentatives d'authentification</div>
                        <input class="nbTry" name="max_attempt" type="number" value="" min="0" oninput="validity.valid||(value='');">
                        <div></div>
                    </div>
                </div>
                <button class="formButton" id="reset2" onclick="setLastSettingsValidity()">réinitialiser</button>
                <input class="formButton" id="validate2" type="submit" value="Valider">
                <div class="error">Oh Oh... messing with number order</div>
            </form>

            <form class="user">
                <h2>Gestion des tentatives</h2>
                <div id="TrySettings">
                    <div class="grid1">
                        <div class="settingCategory">Nombre max de tentatives successives</div>
                        <input class="nbTry" name="successives_attempts" type="number" value="" min="0" oninput="validity.valid||(value='');">
                        <div></div>
                    </div>

                    <div class="grid2">
                        <div class="settingCategory"></div>
                        <div>Heures</div>
                        <div>Minutes</div>
                        <div>Secondes</div>
                        <div></div>
                    </div>

                    <div class="grid2">
                        <div class="settingCategory">Délai d'attente après dépassement</div>
                        <input class="nbT2" name="heures" type="number" value="" placeholder="heures" min="0" oninput="validity.valid||(value='');">
                        <input class="nbT2" name="minutes" type="number" value="" placeholder="minutes" min="0" oninput="validity.valid||(value='');">
                        <input class="nbT2" name="secondes" type="number" value="" placeholder="secondes" min="0" oninput="validity.valid||(value='');">
                        <div></div>
                    </div>
                    <button class="formButton" id="reset3" onclick="setLastSettingsTry()">réinitialiser</button>
                    <input class="formButton" id="validate3" type="submit" value="Valider">
                    <div class="error">Oh Oh... messing with number order</div>
                </div>
            </form>
        </div>

        <div class="wrapper" id="wrapAffaire">
            <h2>Clients d'Affaires</h2>
            <div class="user">
                <span class="FirstName">Allain</span>
                <span class="LastName">DUPONT</span>
            </div>
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
                        <input type="password" name="old" maxlength="12" id="name" placeholder="Votre ancien mot de passe" required />
                    </div>

                    <div class="inputs">
                        <label for="password">Nouveau mot de passe :</label>
                        <input type="password" name="password" maxlength="12" id="password" placeholder="Entrez votre nouveau mot de passe" required />
                    </div>

                    <div class="inputs">
                        <label for="password2">Confirmer le nouveau mot de passe :</label>
                        <input type="password" name="password2" maxlength="12" id="password2" placeholder="Confirmer votre nouveau mot de passe" required />
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
        </div>



        <footer>
            <div></div>
            <div>Hadrien BELLEVILLE - Béatrice GARCIA CEGARRA - Bilal SAFI</div>
            <div>Travail Pratique #3</div>
            <div><a href="https://cours.uqac.ca/8INF138">8INF138 - Sécurité des Réseaux et du Web</a></div>
        </footer>
    </body>
</html>