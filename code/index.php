<!DOCTYPE html>
<html lang="en">
<?php
include "func.php";
$file = unzip();
// var_dump($_GET);
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery-3.6.0.min.js"></script>
    <script>
        $(function() {
            $(".directory").click(function() {
                console.log(this.innerText);
                var day = this.innerText;
                $.ajax({
                    type: "GET",
                    url: "func.php",
                    data: {
                        directory: this.innerText
                    },
                    dataType: 'json',
                    error: function(test) {
                        console.log(test);
                    },
                    success: function(response) {
                        console.log(response);
                        $("div").empty();
                        $.each(Object.keys(response), function() {
                            $("div").append('<img height="' + response[this][0] + '" width="' + response[this][1] + '" src="..\..\exctractedFile\\' + day + '\\' + this + '" alt="' + this + '">')
                        })
                    }
                })
            });
        });
    </script>

    <title>Index</title>
</head>

<body>
    <?php echoDirectory(); ?>
    <div>
        <?php
        echoImage($file);
        ?>
    </div>
</body>

</html>