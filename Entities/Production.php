<?php

namespace Portfolio\Entities;

class Production
{
    private $idProduction;
    private $title;
    private $url;
    private $path;
    private $description;
    private $createdAt;
    private $html;
    private $sass;
    private $bootstrap;
    private $js;
    private $php;
    private $symfony;
    private $react;
    private $wordpress;
    private $idUser;
    

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

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of title
     */ 
    public function getUrl()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setUrl($title)
    {
        $this->title = $title;

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
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of createAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createAt
     *
     * @return  self
     */ 
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }


    /**
     * Get the value of html
     */ 
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * Set the value of html
     *
     * @return  self
     */ 
    public function setHtml($html)
    {
        $this->html = $html;

        return $this;
    }

     /**
     * Get the value of html
     */ 
    public function getSass()
    {
        return $this->sass;
    }

    /**
     * Set the value of html
     *
     * @return  self
     */ 
    public function setSass($sass)
    {
        $this->sass = $sass;

        return $this;
    }
   

    /**
     * Get the value of bootstrap
     */ 
    public function getBootstrap()
    {
        return $this->bootstrap;
    }

    /**
     * Set the value of bootstrap
     *
     * @return  self
     */ 
    public function setBootstrap($bootstrap)
    {
        $this->bootstrap = $bootstrap;

        return $this;
    }

    
    /**
     * Get the value of html
     */ 
    public function getJs()
    {
        return $this->js;
    }

    /**
     * Set the value of html
     *
     * @return  self
     */ 
    public function setJs($js)
    {
        $this->js = $js;

        return $this;
    }

    /**
     * Get the value of html
     */ 
    public function getPhp()
    {
        return $this->php;
    }

    /**
     * Set the value of html
     *
     * @return  self
     */ 
    public function setPhp($php)
    {
        $this->php = $php;

        return $this;
    }
    /**
     * Get the value of symfony
     */ 
    public function getSymfony()
    {
        return $this->symfony;
    }

    /**
     * Set the value of symfony
     *
     * @return  self
     */ 
    public function setSymfony($symfony)
    {
        $this->symfony = $symfony;

        return $this;
    }

    /**
     * Get the value of wordpress
     */ 
    public function getWordpress()
    {
        return $this->wordpress;
    }

    /**
     * Set the value of wordpress
     *
     * @return  self
     */ 
    public function setWordpress($wordpress)
    {
        $this->wordpress = $wordpress;

        return $this;
    }
     /**
     * Get the value of react
     */ 
    public function getReact()
    {
        return $this->react;
    }

    /**
     * Set the value of react
     *
     * @return  self
     */ 
    public function setReact($react)
    {
        $this->react = $react;

        return $this;
    }


      /**
     * Get the value of idUser
     */ 
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set the value of idUser
     *
     * @return  self
     */ 
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }
}
