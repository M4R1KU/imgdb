<?php
/**
 * Created by PhpStorm.
 * User: M4R1KU
 * Date: 04.06.2016
 * Time: 15:42
 */

namespace MKWeb\ImgDB\Model;


class Ajax extends Model
{

    public function getSimilarGalleriesByName($name) {
        $name = "%".$name."%";
        $query = $this->connection->prepare("SELECT * FROM gallery WHERE name LIKE ?");
        $query->bind_param('s', $name);
        return $this->readAllArray($query);
    }

    public function getUserById($id)
    {
        $query = $this->connection->prepare("SELECT * FROM user WHERE user_id = ?");
        $query->bind_param('i', intval($id));
        return $this->readAllOrSingle($query);
    }
    
    public function getImageByTagAndGallery($tag, $gallery_id) {
        $tag = '%' . $tag . '%';
        $query = $this->connection->prepare("SELECT i.*, g.* FROM imgdb.gallery AS g JOIN image AS i ON g.gallery_id = i.id_gallery JOIN image_tag AS it ON i.image_id = it.id_image JOIN tag AS t ON it.id_tag = t.tag_id WHERE g.gallery_id = ? AND t.name LIKE ?");
        $query->bind_param('is', intval($gallery_id), $tag);
        return $this->readAllArray($query);
    }

}