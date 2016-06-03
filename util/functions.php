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
function h($text) {

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

function linkHelper($link, $name, array $options = null) {
    $href = $classes = '';
    if (is_array($link)) {
        $href = ROOT . $link['controller'] . DS . $link['action'];
    } else if (is_string($link)) {
        $href = strpos($link, ROOT) === false ? ROOT . $link : $link;
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
    return '<a href="' . $href . '"' . (strlen($classes) > 0 ? 'class="' . $classes . '"':'') . ' >' . $name . '</a>';
}

function resizeAndMoveImage($galleryDir, $galleryThumbnailDir, $newFilename) {
    list($width, $height) = getimagesize($galleryDir . $newFilename);
    $newHeight = THUMBNAIL_HEIGHT;
    $newWidth = $width / ($height / THUMBNAIL_HEIGHT);

    $thumb = imagecreatetruecolor($newWidth, $newHeight);
    $source = imagecreatefromjpeg($galleryDir . $newFilename);

    imagecopyresized($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    imagejpeg($thumb, $galleryThumbnailDir . $newFilename);
}

function getGalleryHash(\MKWeb\ImgDB\Model\Gallery $gallery) {

}

function getImageHas(\MKWeb\ImgDB\Model\Image $imasge) {

}