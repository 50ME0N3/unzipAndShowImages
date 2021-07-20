<!DOCTYPE html>
<html lang="en">
<?php
include "func.php";
// var_dump($_GET);
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="jquery-3.6.0.min.js"></script>
    <script>
        /**
         * envoie une requète get sur le fichier func.php et affiche les images envoyée en réponse
         */
        $(function() {
            $(".directory").click(function() {
                console.log(this.innerText);
                let day = this.innerText;
                $.ajax({
                    type: "GET",
                    url: "func.php",
                    data: {
                        directory: this.innerText
                    },
                    dataType: 'json',
                    /**
                     * en cas d'erreur de la requète affiche error et la reponse en console
                     * @param response la réponse a la requète ajax
                     */
                    error: function(response) {
                        console.log("error");
                        console.log(response);
                    },
                    /**
                     * récupère le tableau envoyé via la requète et en affiche les images
                     * @param response la réponse a la requète ajax
                     */
                    success: function(response) {
                        console.log(response);
                        $("#test").empty();
                        let i = 0;
                        $.each(Object.keys(response), function() {
                            if(i % 3 == 0) {
                                $("table").append('<tr>')
                            }
                            $("table").append('<td><center><img height="' + response[this][0] + '" width="' + response[this][1] + '" src="../../exctractedFile\\' + day + '\\' + this + '" alt="' + this + '"></></td>')
                            i++;
                        })
                    }
                })
            });
        });
    </script>

    <title>Index</title>
</head>

<body>
<header>
    <?php
        //si l'utilisateur est connecter lui met un lien lui permettant de voir son profil sinon lui met les boutton pour le redirigé sur les page de login ou signin
        if($_SESSION["username"] != null){
            echo "<a href='User.php'>Montre moi qui je suis</a>";
        }
        else{
            echo "<a href='login.php'><button>se connecter</button></a><br><a href='signin.php'><button>s'inscrire</button></a>";
        }
    ?>
</header>
    <aside>
        <?php
            //affiche un boutton pour chaque dossier
            echoDirectory();
            //si l'utilisateur est un admin on affiche un boutton lui permettant de reload tout les fichier zip
            if($_SESSION["admin"]){
        ?>
        <button onclick="document.location.href = 'unzip.php'">Reload files</button>
        <?php
            }
        ?>
    </aside>
    <?php
        //pour les test
        //TestExif();
    ?>
    <table class="container" id="test">
        <?php
            //affiche les images du dernier dossier modifier
            echoImage();
        ?>
    </table>
</body>

</html>