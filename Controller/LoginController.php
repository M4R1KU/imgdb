<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 19.11.2015
 * Time: 14:18
 */

namespace MKWeb\ImgDB\Controller;

use MKWeb\ImgDB\Model\User;
use MKWeb\ImgDB\Util\Validator;

class LoginController extends Controller {

    public function index() {
    }

    public function login() {
        if (!Validator::validateEmail($this->request->params['passed']['login_email']) || empty($this->request->params['passed']['login_password'])) {
            return $this->redirect('/login/index' . generateFlash('Login failed. Some Information is missing or wrong.', 'error'));
        }
        $email = h($this->request->params['passed']['login_email']);
        $pw = h($this->request->params['passed']['login_password']);
        $user = (new User())->constructUserByEmail($email);
        if ($user && $user->checkLogin($pw)) {
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['nickname'] = $user->getNickname();
            return $this->redirect('/index/index');
        }
        return $this->redirect('/login/index' . generateFlash('Login failed. Your password or username is incorrect.', 'error'));
    }

    public function logout() {
        unset($_SESSION);
        session_destroy();
        return $this->redirect('/index/index');
    }

    public function add() {
        $user = new User();
        $name = $this->request->params['passed']['username'];
        $email = $this->request->params['passed']['email'];
        $pw = $this->request->params['passed']['password'];
        $pwc = $this->request->params['passed']['password_confirmed'];
        if (!empty($name) && Validator::validateEmail($email) && $user->isUniqueEmail($email) && !Validator::validatePW($pw) && Validator::confirmPW($pw, $pwc)) {
            $user->setNickname($name);
            $user->setEmail($email);
            $user->setPassword($pw);
            $user->create();
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['nickname'] = $user->getNickname();
            return $this->redirect('/index/index');
        }
        return $this->redirect('/login/index' .generateFlash('Registration failed. Please adjust the wrong input fields.', 'error'));
    }

}
