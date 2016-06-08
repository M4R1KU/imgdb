<?php
/**
 * Created by PhpStorm.
 * User: M4R1KU
 * Date: 04.06.2016
 * Time: 15:27
 */

namespace MKWeb\ImgDB\Controller;


use MKWeb\ImgDB\Model\Ajax;

class AjaxController extends Controller
{

    public function gallery() {
        $needle = $this->request->params['passed']['needle'];
        $this->response->header('Content-type', 'application/json');
        $galleries = (new Ajax())->getSimilarGalleriesByName($needle);
        if (!$galleries) {
            return $this->response->body(json_encode([]));
        }
        for ($i = 0; $i < count($galleries); $i++) {
            $user = (new Ajax())->getUserById($galleries[$i]['id_user']);
            unset($galleries[$i]['id_user']);
            $galleries[$i]['user'] = $user;
        }
        $galleries = prepareGalleries($galleries);
        return $this->response->body(json_encode($galleries));
    }
    
    public function image() {
        if (empty($this->request->params['passed']['gallery_id']) || empty($this->request->params['passed']['needle'])){
            return $this->response->body(json_encode([]));
        }
        $needle = $this->request->params['passed']['needle'];
        $gid = $this->request->params['passed']['gallery_id'];
        $images = (new Ajax())->getImageByTagAndGallery($needle, $gid);
        if (!$images) return $this->response->body(json_encode([]));
        $hash = sha1($images[0]['name'] . $gid);
        for ($i = 0; $i < count($images); $i++) {
            $images[$i]['hash'] = $hash;
        }
        return $this->response->body(json_encode($images));
    }

}