<?php

namespace MKWeb\ImgDB\Controller;

class ErrorController extends Controller {

    public function index() {
        if (!isset($this->request->params['passed']['error'])) return $this->redirect(ROOT. '/error/index?error=404');
        $status_code = array("100","101","200","201","202","203","204","205","206","300","301","302","303","304","305","306","307","400","401","402","403","404","405","406","407","408","409","410","411","412","413","414","415","416","417","500","501","502","503","504","505");
        
        if (isset($this->request->params['passed']['msg'])) $this->view->assign('msg', $this->request->params['passed']['msg']);
        
        if (in_array($this->request->params['passed']['error'], $status_code)) {
            $this->view->assign('status_code', $this->request->params['passed']['error']);
        } else {
            return $this->redirect(ROOT. '/error/index?error=404');
        }
    }

}