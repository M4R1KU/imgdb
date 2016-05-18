<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 19.11.2015
 * Time: 14:18
 */

namespace MKWeb\ImgDB\Controller;

use MKWeb\ImgDB\Util\Validator;

class LoginController extends Controller {

    public function index() {
        if (isset($this->request->params['passed']['flash']) && isset($this->request->params['passed']['title'])) {
            $this->view->assign('flash', urldecode($this->request->params['passed']['flash']));
            $this->view->assign('title', urldecode($this->request->params['passed']['title']));
        }
    }

    public function login() {
        if (!Validator::validateEmail($this->request->params['passed']['login_email']) || empty($this->request->params['passed']['login_password'])) {
            return $this->redirect(ROOT . '/login/index?flash=Some Information is missing or wrong&title=Login failed');
        }
        $email = h($this->request->params['passed']['login_email']);
        $pw = h($this->request->params['passed']['login_password']);
        $user = (new User())->constructUserByEmail($email);
        if ($user->checkLogin($pw)) {
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['nickname'] = $user->getNickname();
            return $this->redirect(ROOT . '/index/index');
        }
        return $this->redirect(ROOT . '/login/index?flash=Your password or username is incorrect&title=Login failed');
    }

    public function logout() {
        unset($_SESSION);
        session_destroy();
        return $this->redirect(ROOT . '/index/index');
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
            return $this->redirect(ROOT . '/index/index');
        }
        return $this->redirect(ROOT . '/login/index?flash=Please adjust the wrong input fields&title=Registration failed');
    }

}
