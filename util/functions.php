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
        $href = ROOT . DS . $link['controller'] . DS . $link['action'];
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