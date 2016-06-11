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

/**
 * generates an a tag with the given options
 *
 * linkHelper('/index/index/', 'Back to Main site', ['class' => ['btn', 'waves-effect']]);
 *  results in
 * <a class="btn waves-effect" href="/index/index">Back to Main site"</a>
 *
 *
 * @param $link
 * @param $name
 * @param array|null $options
 * @return string
 */
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

/**
 * 
 * resizes the image in the galleryDir to a height of 200px and moves the new image to the thumbnailDir 
 * 
 * @param $galleryDir
 * @param $galleryThumbnailDir
 * @param $newFilename
 */
function resizeAndMoveImage($galleryDir, $galleryThumbnailDir, $newFilename)
{
    list($width, $height) = getimagesize($galleryDir . $newFilename);
    $newHeight = THUMBNAIL_HEIGHT;
    $newWidth = $width / ($height / THUMBNAIL_HEIGHT);

    $thumb = imagecreatetruecolor($newWidth, $newHeight);
    $source = getImageByType($galleryDir . $newFilename);

    imagecopyresized($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    imagejpeg($thumb, $galleryThumbnailDir . $newFilename);
}

/**
 * 
 * returns a resource of an image by its path
 * 
 * @param $image
 * @return null|resource
 */
function getImageByType($image) {
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    if ($ext == "png")
        return imagecreatefrompng($image);
    if ($ext == "gif")
        return imagecreatefromgif($image);
    if ($ext == "jpg" || $ext == "png")
        return imagecreatefromjpeg($image);

    return null;
}

/**
 * returns a hash of the galleryName and galleryId
 * 
 * used to make the image directories
 * 
 * @param \MKWeb\ImgDB\Model\Entity\Gallery $gallery
 * @return string
 */
function getGalleryHash(\MKWeb\ImgDB\Model\Entity\Gallery $gallery)
{
    return sha1($gallery->getName() . $gallery->getId());
}

/**
 * returns a hash of the current time the filename and the filetype
 * 
 * prevents same image name
 * 
 * @param $fileNameWithType
 * @return string
 */
function getImageHash($fileNameWithType)
{
    return hash('sha256', $fileNameWithType . time()) . '.' . end(explode('.', $fileNameWithType));
}

/**
 * generates the flash parameters for the url
 * 
 * @param $message
 * @param string $type
 * @return string
 */
function generateFlash($message, $type = 'warning')
{
    $time = time();

    return '?flash=' . urlencode($message) . '&flashHash=' . hash('sha256', $message . SECRET . $time . $type) . "&flashTime=$time&flashType=$type";
}

/**
 * returns if the flash which is given in the URI is valid
 * 
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

/**
 * prepares multiple gallery objects for the use in the template
 * 
 * @param $out
 * @return array
 */
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

/**
 * deletes a directory recursively
 * 
 * @param $dir
 */
function deleteDir($dir) {
    if (! is_dir($dir)) {
        throw new InvalidArgumentException("$dir must be a directory");
    }
    if (substr($dir, strlen($dir) - 1, 1) != '/') {
        $dir .= '/';
    }
    $files = glob($dir . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dir);

}