<!DOCTYPE html>
<html lang="en">
<?php
include "func.php";
$file = unzip();
// var_dump($_GET);
if (isset($_GET["directory"])) {
    //echoSpecifiedDirectory($_GET["directory"]);
    echo "test";
} else {
    echoImage($file);
}
var_dump(exif_read_data("exctractedFile\\20210705\\P1110051.JPG"));
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery-3.6.0.min.js"></script>
    <script src="node_modules\exif-js\exif.js"></script>
    <script>
        window.onload = getExif;
        img1 = "exctractedFile\\20210705\\P1110051.JPG";
        EXIF.getData(img1, function() {
            var make = EXIF.getTag(this, "Make");
            var model = EXIF.getTag(this, "Model");
            var makeAndModel = document.getElementById("makeAndModel");
            makeAndModel.innerHTML = `${make} ${model}`;
        });

        $(function() {
            $(".directory").click(function() {
                var day = this.innerText;
                $.ajax({
                    type: "GET",
                    url: "func.php",
                    data: {
                        directory: this.innerText
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response)
                        $("div").append('<img src="exctractedFile\\' + day + '\\' + response[2] + '" alt="">')
                    }
                })
            });
        });
    </script>

    <title>Index</title>
</head>

<body>
    <?php
    //echoSpecifiedDirectory("20210705");
    ?>
    <?php echoDirectory(); ?>
    <div></div>
</body>

</html>