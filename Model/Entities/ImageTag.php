<?php
/**
 * Created by PhpStorm.
 * User: M4R1KU
 * Date: 08.06.2016
 * Time: 22:41
 */

namespace MKWeb\ImgDB\Model\Entity;


class ImageTag extends Entity {
    
    /**
     * @var Image
     */
    private $image;
    /**
     * @var Tag
     */
    private $tag;

    /**
     * ImageTag constructor.
     * @param $id
     * @param Image $image
     * @param Tag $tag
     */
    public function __construct($id, Image $image, Tag $tag)
    {
        $this->id = $id;
        $this->image = $image;
        $this->tag = $tag;
    }


    /**
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param Image $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return Tag
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param Tag $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }
    
    
    

}