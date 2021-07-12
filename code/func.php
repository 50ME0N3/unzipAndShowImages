<?php
if (isset($_GET["directory"])) {
    $pic = array();
    $dividedBy = 20;
    foreach (scandir('exctractedFile\\' . $_GET["directory"]) as $item) {
        if ($item != "." && $item != "..") {
            if (exif_imagetype('exctractedFile\\' . $_GET["directory"] . '\\' . $item) == IMAGETYPE_JPEG) {
                $imageInfo = getimagesize('exctractedFile\\' . $_GET["directory"] . '\\' . $item);
                if (exif_read_data('exctractedFile\\' . $_GET["directory"] . '\\' . $item)["Orientation"] == 1) {
                    $pic[$item] = array($imageInfo[1] / $dividedBy, $imageInfo[0] / $dividedBy);
                } elseif (exif_read_data('exctractedFile\\' . $_GET["directory"] . '\\' . $item)["Orientation"] == 6 || exif_read_data('exctractedFile\\' . $_GET["directory"] . '\\' . $item)["Orientation"] == 8) {
                    $pic[$item] = array($imageInfo[0] / $dividedBy, $imageInfo[1] / $dividedBy);
                }
            }
        }
    }
    echo json_encode($pic);
}
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$hour = date('H');
$dividedBy = 20;
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

        ksort($files);
        $reallyLastModified = end($files);
        foreach ($files as $file) {
            $stat = stat('zippedFile\\' . $file);
            $lastModified = date('F d Y, H:i:s', $stat["ctime"]);
            if ($file == $reallyLastModified) {
                $lastModified = $file;
            }
        }
    }

    if (scandir('exctractedFile\\' . substr($lastModified, 0, -4)) == null) {
        $zip = new ZipArchive;
        $res = $zip->open('zippedFile\\' . $lastModified);
        if ($res === TRUE) {
            $zip->extractTo('exctractedFile');
            $zip->close();
        }
    }
    return $lastModified;
}
function echoImage($lastModified)
{
    global $dividedBy;
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
