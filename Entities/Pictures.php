<?php 
namespace Portfolio\Entities;

class Pictures
{
    private $idPicture;
    private $size_slide;
    private $path;
    private $idProduction;


    /**
     * Get the value of idPicture
     */ 
    public function getIdPicture()
    {
        return $this->idPicture;
    }

    /**
     * Set the value of idPicture
     *
     * @return  self
     */ 
    public function setIdPicture($idPicture)
    {
        $this->idPicture = $idPicture;

        return $this;
    }

    /**
     * Get the value of size_slide
     */ 
    public function getSize_slide()
    {
        return $this->size_slide;
    }

    /**
     * Set the value of size_slide
     *
     * @return  self
     */ 
    public function setSize_slide($size_slide)
    {
        $this->size_slide = $size_slide;

        return $this;
    }

    /**
     * Get the value of path
     */ 
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the value of path
     *
     * @return  self
     */ 
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get the value of idProduction
     */ 
    public function getIdProduction()
    {
        return $this->idProduction;
    }

    /**
     * Set the value of idProduction
     *
     * @return  self
     */ 
    public function setIdProduction($idProduction)
    {
        $this->idProduction = $idProduction;

        return $this;
    }
}