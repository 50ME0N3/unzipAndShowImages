<?php
if (isset($_GET["directory"])) {
    $pic = array();

    echo json_encode(scandir('exctractedFile\\' . $_GET["directory"]));
}
ini_set('display_errors', 0);
$dividedBy = 20;
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$hour = date('H');
function unzip()
{
    $files = array();
    if ($handle = opendir('zippedFile')) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
                if (file_exists('zippedFile\\' . $file)) {
                    $stat = stat('zippedFile\\' . $file);
                    $filedate = date_create(date("Y-m-d", $stat['ctime']));
                    $files[$stat["ctime"]] = $file;
                }
            }
        }
        closedir($handle);

        // sort
        ksort($files);
        // find the last modification
        $reallyLastModified = end($files);
        //var_dump($files);
        foreach ($files as $file) {
            $stat = stat('zippedFile\\' . $file);
            $lastModified = date('F d Y, H:i:s', $stat["ctime"]);
            if ($file == $reallyLastModified) {
                $lastModified = $file;
                return $lastModified;
            }
            //echo "<tr><td><input type=\"checkbox\" name=\"box[]\"></td><td><a href=\"$file\" target=\"_blank\">$file</a></td><td>$lastModified</td></tr>";
        }
    }
}
function echoImage($lastModified)
{
    global $dividedBy;
    if (scandir('exctractedFile\\' . substr($lastModified, 0, -4)) == null) {
        $zip = new ZipArchive;
        $res = $zip->open('zippedFile\\' . $lastModified);
        if ($res === TRUE) {
            $zip->extractTo('exctractedFile');
            $zip->close();
        } else {
        }
    }
    foreach (scandir('exctractedFile\\' . substr($lastModified, 0, -4)) as $item) {
        if ($item != "." && $item != "..") {
            $imageInfo = getimagesize('exctractedFile\\' . substr($lastModified, 0, -4) . '\\' . $item);
            //var_dump(exif_read_data('exctractedFile\\' . substr($lastModified, 0, -4) . '\\' . $item)["Orientation"]);
            if (exif_read_data('exctractedFile\\' . substr($lastModified, 0, -4) . '\\' . $item)["Orientation"] == 1) {
                echo '<img height="' . $imageInfo[1] / $dividedBy . '" width="' . $imageInfo[0] / $dividedBy . '" src="exctractedFile\\' . substr($lastModified, 0, -4) . '\\' . $item . '" alt="' . $item . '"/>';
            } elseif (exif_read_data('exctractedFile\\' . substr($lastModified, 0, -4) . '\\' . $item)["Orientation"] == 6) {
                echo '<img height="' . $imageInfo[0] / $dividedBy . '" width="' . $imageInfo[1] / $dividedBy . '" src="exctractedFile\\' . substr($lastModified, 0, -4) . '\\' . $item . '" alt="' . $item . '"/>';
            } elseif (exif_read_data('exctractedFile\\' . substr($lastModified, 0, -4) . '\\' . $item)["Orientation"] == 8) {
                echo '<img height="' . $imageInfo[0] / $dividedBy . '" width="' . $imageInfo[1] / $dividedBy . '" src="exctractedFile\\' . substr($lastModified, 0, -4) . '\\' . $item . '" alt="' . $item . '"/>';
            }
        }
    }
}

function echoDirectory()
{
    foreach (scandir("exctractedFile") as $value) {
        if ($value != "." && $value != "..")
            echo '<button class="directory">' . $value . '</button>';
    }
}

function echoSpecifiedDirectory($directory)
{
    global $dividedBy;
    foreach (scandir('exctractedFile\\' . $directory) as $item) {
        if ($item != "." && $item != "..") {
            $imageInfo = getimagesize('exctractedFile\\' . $directory . '\\' . $item);
            //var_dump(exif_read_data('exctractedFile\\' . substr($lastModified, 0, -4) . '\\' . $item)["Orientation"]);
            if (exif_read_data('exctractedFile\\' . $directory . '\\' . $item)["Orientation"] == 1) {
                echo '<img height="' . $imageInfo[1] / $dividedBy . '" width="' . $imageInfo[0] / $dividedBy . '" src="exctractedFile\\' . $directory . '\\' . $item . '" alt="' . $item . '"/>';
            } elseif (exif_read_data('exctractedFile\\' . $directory . '\\' . $item)["Orientation"] == 6) {
                echo '<img height="' . $imageInfo[0] / $dividedBy . '" width="' . $imageInfo[1] / $dividedBy . '" src="exctractedFile\\' . $directory . '\\' . $item . '" alt="' . $item . '"/>';
            } elseif (exif_read_data('exctractedFile\\' . $directory . '\\' . $item)["Orientation"] == 8) {
                echo '<img height="' . $imageInfo[0] / $dividedBy . '" width="' . $imageInfo[1] / $dividedBy . '" src="exctractedFile\\' . $directory . '\\' . $item . '" alt="' . $item . '"/>';
            }
        }
    }
}
