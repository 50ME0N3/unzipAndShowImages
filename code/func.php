<?php
//constante pour la taille des images
const width = 273.6;
const height = 182.4;
//enlève les messages d'erreurs
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//modifie le temps d'execution maximale a infinie parce que la fonction unzip met beaucoup de temps a s'effectuer
ini_set('max_execution_time', -1);
session_start();
if (isset($_GET["directory"])) {
    echo echoSpecifiedDirectory($_GET["directory"]);
}
/**
 * envoie les images demandée par un requète en get sur le fichier
 *
 * @param string $directory nom du dossier dans lequel son stockée les images que vous voullez afficher
 *
 * @return string un tableau json contenant le nom des images et leurs taille
 */
function echoSpecifiedDirectory(string $directory): string
{
    $pic = array();
    foreach (scandir('..\..\exctractedFile\\' . $directory) as $item) {
        if ($item != "." && $item != "..") {
            if (exif_imagetype('..\..\exctractedFile\\' . $directory . '\\' . $item) == IMAGETYPE_JPEG) {
                if (exif_read_data('..\..\exctractedFile\\' . $directory . '\\' . $item)["Orientation"] == 1) {
                    $pic[$item] = array(height, width);
                } elseif (exif_read_data('..\..\exctractedFile\\' . $directory . '\\' . $item)["Orientation"] == 6 || exif_read_data('..\..\exctractedFile\\' . $directory . '\\' . $item)["Orientation"] == 8) {
                    $pic[$item] = array(width, height);
                }
            }
        }
    }
    return json_encode($pic);
}

/**
 * extrait tout les fichier zip du dossier dans un autre dossier
 */
function unzip()
{
    foreach (scandir("..\..\zippedFile") as $value) {
        if (scandir('..\..\exctractedFile\\' . $value) == null) {
            $zip = new ZipArchive;
            $res = $zip->open('..\..\zippedFile\\' . $value);
            if ($res === TRUE) {
                $zip->extractTo('..\..\exctractedFile');
                $zip->close();
            }
        }
        unlink("..\..\zippedFile\\" . $value);
    }
}

/**
 * Fonction de test pour savoir si les photos possède bien les données exif nécessaire
 */
function TestExif(string $directory)
{
    foreach (scandir('..\..\exctractedFile\\' . $directory) as $item) {
        if ($item != "." && $item != "..") {
            echo $item;
            echo "<br>";
            if (exif_read_data('..\..\exctractedFile\\' . $directory . '\\' . $item)["Orientation"] == null) {
                var_dump(exif_read_data('..\..\exctractedFile\\' . $directory . '\\' . $item));
            }
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";

        }
    }
}

/**
 * Affiche les images présente dans le dernier dossier modifier
 */
function echoImage()
{
    $lastModified = "test";
    $files = array();
    //regarde quel est le dernier dossier modifier
    if ($handle = opendir('..\..\exctractedFile')) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
                if (file_exists('..\..\exctractedFile\\' . $file)) {
                    $stat = stat('..\..\exctractedFile\\' . $file);
                    $files[$stat["ctime"]] = $file;

                }
            }
        }
        closedir($handle);
        ksort($files);
        $reallyLastModified = end($files);
        foreach ($files as $file) {
            $stat = stat('..\..\exctractedFile\\' . $file);
            global $lastModified;
            $lastModified = date('F d Y, H:i:s', $stat["ctime"]);
            if ($file == $reallyLastModified) {
                $lastModified = $file;
            }
        }
    }
    $i = 0;

    //affiche toutes les images du dossier dans le tableau
    foreach (scandir('..\..\exctractedFile\\' . $lastModified) as $item) {
        if ($item != "." && $item != "..") {
            //var_dump(exif_read_data('..\..\exctractedFile\\' . substr($lastModified, 0, -4) . '\\' . $item)["Orientation"]);
            if ($i % 3 == 0) {
                echo "<tr></tr>";
            }
            if (exif_read_data('..\..\exctractedFile\\' . $lastModified . '\\' . $item)["Orientation"] == 1) {
                echo '<td><center><a target="_blank" href="..\..\exctractedFile\\' . $lastModified . '\\' . $item . '"><img class="rounded img-thumbnail" height="' . height . '" width="' . width . '" src="..\..\exctractedFile\\' . $lastModified . '\\' . $item . '" alt="' . $item . '"/></a><center></td>';
            } elseif (exif_read_data('..\..\exctractedFile\\' . $lastModified . '\\' . $item)["Orientation"] == 6 || exif_read_data('..\..\exctractedFile\\' . $lastModified . '\\' . $item)["Orientation"] == 8) {
                echo '<td><center><a target="_blank" href="..\..\exctractedFile\\' . $lastModified . '\\' . $item . '"><img class="rounded img-thumbnail" height="' . width . '" width="' . height . '" href="" src="..\..\exctractedFile\\' . $lastModified . '\\' . $item . '" alt="' . $item . '"/></a></center></td>';
            }
            $i++;
        }
    }
}

/**
 * affiche un boutton pour chaque dossier
 */
function echoDirectory()
{
    foreach (scandir("..\..\\exctractedFile") as $value) {
        if ($value != "." && $value != "..")
            echo '<button class="btn btn-outline-danger directory">' . $value . '</button><br>';
    }
}

/**
 * Upload un fichier zip dans le dossier zippedFile
 * TODO: Gestion du chemin a l'appele de la fonction
 * @param array $FILES le fichier envoyé via l'input
 *
 */
function fileUpload(array $FILES)
{
    $target_dir = "..\..\zippedFile\\";
    $target_file = $target_dir . basename($FILES["upload"]["name"]);
    $uploadOk = 1;

// Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
    }

// Check file size
    if ($FILES["fileToUpload"]["size"] > 500000) {
        $uploadOk = 0;
    }

// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
// if everything is ok, try to upload file
    } else {
        move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file);
    }
}