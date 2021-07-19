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
                    error: function(test) {
                        console.log("error");
                        console.log(test);
                    },
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
            echoDirectory();
        ?>
    </aside>
    <?php
        //TestExif();
    ?>
    <table class="container" id="test">
        <?php
            //echoImage($file);
        ?>
    </table>
    <button onclick="document.location.href = 'unzip.php'">Reload files</button>
</body>

</html>