<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 19.11.2015
 * Time: 14:18
 */
require_once('Controller.php');
require_once('lib/Validator.php');

class LoginController extends Controller {

    public function index() {
        if (isset($this->request->params['passed']['flash']) && isset($this->request->params['passed']['title'])) {
            $this->view->assign('flash', urldecode($this->request->params['passed']['flash']));
            $this->view->assign('title', urldecode($this->request->params['passed']['title']));
        }
        $user = ModelFactory::createModel('User');
        $this->view->assign('test', $user->constructUserByID(1));
    }

    public function login() {
        if (!Validator::validateEmail($this->request->params['passed']['login_email']) || empty($this->request->params['passed']['login_password'])) {
            return $this->redirect(ROOT . '/login/index?flash=Some Information is missing or wrong&title=Login failed');
        }
        $email = $this->h($this->request->params['passed']['login_email']);
        $pw = $this->h($this->request->params['passed']['login_password']);
        $user = ModelFactory::createModel('User');
        $user2 = $user->constructUserByEmail($email);
        $user->setPassword($pw);
        $user->setEmail($email);
        if ($user2 !== null && $user->_equals($user2)) {
            $_SESSION['user_id'] = $user2->getId();
            $_SESSION['nickname'] = $user2->getNickname();
            return $this->redirect(ROOT . '/blogs/index');
        }
        return $this->redirect(ROOT . '/login/index?flash=Your password or username is incorrect&title=Login failed');
    }

    public function logout() {
        unset($_SESSION);
        session_destroy();
        return $this->redirect(ROOT . '/index/index');
    }

    public function add() {
        $user = ModelFactory::createModel('User');
        $name = $this->request->params['passed']['username'];
        $email = $this->request->params['passed']['email'];
        $pw = $this->request->params['passed']['password'];
        $pwconfirm = $this->request->params['passed']['password_confirmed'];
        if (!empty($name) && Validator::validateEmail($email) && $user->isUniqueEmail($email) && !Validator::validatePW($pw) && Validator::confirmPW($pw, $pwconfirm)) {
            $user->setNickname($name);
            $user->setEmail($email);
            $user->setPassword($pw);
            $user->create();
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['nickname'] = $user->getNickname();
            return $this->redirect(ROOT . '/blogs/index');
        }
        return $this->redirect(ROOT . '/login/index?flash=Please adjust the wrong input fields&title=Registration failed');
    }

}
