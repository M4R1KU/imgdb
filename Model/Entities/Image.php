<?php
/**
 * Created by PhpStorm.
 * User: M4R1KU
 * Date: 08.06.2016
 * Time: 22:41
 */

namespace MKWeb\ImgDB\Model\Entity;


class Image extends Entity{

    private $title;
    private $description;
    /**
     * @var Gallery
     */
    private $gallery;
    private $file_path;

    /**
     * Image constructor.
     * @param $id
     * @param $title
     * @param $description
     * @param Gallery $gallery
     * @param $file_path
     */
    public function __construct($id, $title, $description, Gallery $gallery, $file_path)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->gallery = $gallery;
        $this->file_path = $file_path;
    }


    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return Gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * @param Gallery $gallery
     */
    public function setGallery($gallery)
    {
        $this->gallery = $gallery;
    }

    /**
     * @return mixed
     */
    public function getFilePath()
    {
        return $this->file_path;
    }

    /**
     * @param mixed $file_path
     */
    public function setFilePath($file_path)
    {
        $this->file_path = $file_path;
    }
    
    

}