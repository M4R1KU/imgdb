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