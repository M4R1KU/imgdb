<?php

namespace MKWeb\ImgDB\Util;
/**
 * Basic Validator class for inut fields
 */
class Validator {


    /**
     * validates the given email with the FILTER_VALIDATE_EMAIL constant
     * @param  String $email email
     * @return String
     */
    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }


    /**
     * validates the given password
     * @param  String $pw password
     * @return boolean
     */
    public static function validatePW($pw) {
        $pwpattern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,50}$/';
        return preg_match($pwpattern, $pw);
    }


    /**
     * checks if both passwords are equal
     * @param  String $pw  password
     * @param  String $pwc password_confirm
     * @return boolean
     */
    public static function confirmPW($pw, $pwc) {
        return !empty($pw) && !empty($pwc) && $pw === $pwc;
    }
}


 ?>
