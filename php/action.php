<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Session</title>
    <link href="../css/styles.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../js/main.js"></script>
</head>


<body>
    <header id="header">
        <h1>SESSION</h1>
        <p>Page de session</p>
    </header>

    <?php
        $file = "data2.json";
        $json = file_get_contents($file);
        $data = json_decode($json);
        $data[] = array(
            "name" => "Jane Toe",
            "age" => 28,
            "email" => "janedoe@example.com"
        );
        $json = json_encode($data);
        file_put_contents('data2.json', $json);

    ?>


    <a href="../index.html"><h1>GO BACK</h1></a>
            <section>
                <footer>
                    <div></div>
                    <div>Hadrien BELLEVILLE - <a href="https://www.linkedin.com/in/b%C3%A9atrice-garcia-cegarra-bb6a841a2/">Béatrice GARCIA CEGARRA</a></div>
                    <div>Travail Pratique #3</div>
                    <div><a href="https://cours.uqac.ca/8INF138">8INF138 - Sécurité des Réseaux et du Web</a></div>
                </footer>
            </section>

    </body>

</html>