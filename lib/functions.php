<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 23.03.2016
 * Time: 17:48
 *
 */


 /**
 * @param string $salt
 * @return string
 */
function getNewCSRFToken($salt = SALT) {
    return hash('sha256', uniqid($salt, true));
}