<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 19.11.2015
 * Time: 14:18
 */

namespace MKWeb\ImgDB\Controller;

use MKWeb\ImgDB\Model\Entity\User;
use MKWeb\ImgDB\Model\UserTable;
use MKWeb\ImgDB\Util\Validator;

class LoginController extends Controller {

    public function index() {
    }

    public function login() {
        $userTable = new UserTable();
        
        if (!Validator::validateEmail($this->request->params['passed']['login_email']) || empty($this->request->params['passed']['login_password'])) {
            return $this->redirect('/login/index' . generateFlash('Login failed. Some Information is missing or wrong.', 'error'));
        }
        $email = h($this->request->params['passed']['login_email']);
        $pw = h($this->request->params['passed']['login_password']);
        $user = $userTable->constructUserByEmail($email);
        if ($user && $userTable->checkLogin($pw, $user)) {
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['nickname'] = $user->getNickname();
            return $this->redirect('/index/index' . generateFlash('Login completed', 'success'));
        }
        return $this->redirect('/login/index' . generateFlash('Login failed. Your password or username is incorrect.', 'error'));
    }

    public function logout() {
        unset($_SESSION);
        session_destroy();
        return $this->redirect('/index/index' .generateFlash('Logout successful.', 'success'));
    }

    public function add() {
        if (empty($this->request->params['passed']['username']) || empty($this->request->params['passed']['email']) || empty($this->request->params['passed']['password']) || empty($this->request->params['passed']['password_confirmed'])) {
            return $this->redirect('/login/index' . generateFlash('Registration failed. Some information is missing or wrong.', 'error'));
        }
        $userTable = new UserTable();
        
        $name = $this->request->params['passed']['username'];
        $email = $this->request->params['passed']['email'];
        $pw = $this->request->params['passed']['password'];
        $pwc = $this->request->params['passed']['password_confirmed'];

        error_log(Validator::validateEmail($email));
        error_log($userTable->isUniqueEmail($email));
        error_log(Validator::validatePW($pw));
        error_log(Validator::confirmPW($pw, $pwc));

        if (!empty($name) && Validator::validateEmail($email) && $userTable->isUniqueEmail($email) && Validator::validatePW($pw) && Validator::confirmPW($pw, $pwc)) {
            $user = $userTable->create(new User(null, $email, $name, $pw));
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['nickname'] = $user->getNickname();
            return $this->redirect('/index/index' . generateFlash('Registration completed. You are now logged in', 'success'));
        }
        return $this->redirect('/login/index' .generateFlash('Registration failed. Please adjust the wrong input fields.', 'error'));
    }

}
