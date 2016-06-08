<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 23.03.2016
 * Time: 17:48
 *
 */


/**
 * escapes html characters
 * could escape an array or just a given string
 * @param mixed $text array or string
 * @return array|string
 */
function h($text)
{

    if (is_string($text)) {
    } elseif (is_array($text)) {
        $texts = array();
        foreach ($text as $k => $t) {
            $texts[$k] = $this->h($t);
        }
        return $texts;
    }
    return htmlspecialchars($text);

}

function linkHelper($link, $name, array $options = null)
{
    $href = $classes = '';
    if (is_array($link)) {
        $href = DS . $link['controller'] . DS . $link['action'];
    } else if (is_string($link)) {
        $href = strpos($link, DS) === false ? DS . $link : $link;
    }
    if (!is_null($options)) {
        if (array_key_exists('class', $options)) {
            if (is_array($options['class'])) {
                $classes = implode(' ', $options['class']);
            } else {
                $classes = $options['class'];
            }
        }
    }
    return '<a href="' . $href . '"' . (strlen($classes) > 0 ? 'class="' . $classes . '"' : '') . ' >' . $name . '</a>';
}

function resizeAndMoveImage($galleryDir, $galleryThumbnailDir, $newFilename)
{
    list($width, $height) = getimagesize($galleryDir . $newFilename);
    $newHeight = THUMBNAIL_HEIGHT;
    $newWidth = $width / ($height / THUMBNAIL_HEIGHT);

    $thumb = imagecreatetruecolor($newWidth, $newHeight);
    $source = imagecreatefromjpeg($galleryDir . $newFilename);

    imagecopyresized($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    imagejpeg($thumb, $galleryThumbnailDir . $newFilename);
}

function getGalleryHash(\MKWeb\ImgDB\Model\Entity\Gallery $gallery)
{
    return sha1($gallery->getName() . $gallery->getId());
}

function getImageHash($fileNameWithType)
{
    return hash('sha256', $fileNameWithType . time()) . '.' . end(explode('.', $fileNameWithType));
}


function generateFlash($message, $type = 'warning')
{
    $time = time();

    return '?flash=' . urlencode($message) . '&flashHash=' . hash('sha256', $message . SECRET . $time . $type) . "&flashTime=$time&flashType=$type";
}

/**
 * @return bool
 */
function validateFlash()
{
    if (!isset($_GET['flash']) || !isset($_GET['flashHash']) || !isset($_GET['flashTime']) || !isset($_GET['flashType'])) {
        return false;
    }

    $message = $_GET['flash'];
    $hash = $_GET['flashHash'];
    $time = $_GET['flashTime'];
    $type = $_GET['flashType'];

    $currentTime = time();
    if (!($currentTime - 1 <= $time && $time <= $currentTime + 1)) {
        return false;
    }

    return hash('sha256', $message . SECRET . $time . $type) === $hash;
}

function prepareGalleries($out) {
    $galleries = [];
    if (count($out) >= 3) {
        $j = 0;
        for ($i = 0; $i < count($out); $i++) {
            $galleries[$j][] = $out[$i];
            if (($i+1) % 3 == 0) $j++;
        }
    } else if ($out) {
        $galleries[0] = $out;
    }
    return $galleries;
}

function deleteDir($dir)
{
    $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
    foreach ($files as $file) {
        if ($file->isDir()) {
            rmdir($file->getRealPath());
        } else {
            unlink($file->getRealPath());
        }
    }
    rmdir($dir);
}