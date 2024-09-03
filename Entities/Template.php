<?php
namespace Portfolio\Entities;

class Template 
{
    private $idTemplate;
    private $path1;
    private $path2;
    private $path3;
    private $path4;
    private $comments;
    private $idProduction;

    
    /**
     * Get the value of idTemplate
     */ 
    public function getIdTemplate()
    {
        return $this->idTemplate;
    }

    /**
     * Set the value of idTemplate
     *
     * @return  self
     */ 
    public function setIdTemplate($idTemplate)
    {
        $this->idTemplate = $idTemplate;

        return $this;
    }

    /**
     * Get the value of path2
     */ 
    public function getPath1()
    {
        return $this->path1;
    }

    /**
     * Set the value of path2
     *
     * @return  self
     */ 
    public function setPath1($path1)
    {
        $this->path1 = $path1;

        return $this;
    }

    /**
     * Get the value of path3
     */ 
    public function getPath2()
    {
        return $this->path2;
    }

    /**
     * Set the value of path3
     *
     * @return  self
     */ 
    public function setPath2($path2)
    {
        $this->path2 = $path2;

        return $this;
    }

    /**
     * Get the value of path4
     */ 
    public function getPath3()
    {
        return $this->path3;
    }

    /**
     * Set the value of path4
     *
     * @return  self
     */ 
    public function setPath3($path3)
    {
        $this->path3 = $path3;

        return $this;
    }

    /**
     * Get the value of path5
     */ 
    public function getPath4()
    {
        return $this->path4;
    }

    /**
     * Set the value of path5
     *
     * @return  self
     */ 
    public function setPath4($path4)
    {
        $this->path4 = $path4;

        return $this;
    }
   

    /**
     * Get the value of comments
     */ 
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set the value of comments
     *
     * @return  self
     */ 
    public function setComments($comments)
    {
        $this->comments = $comments;

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