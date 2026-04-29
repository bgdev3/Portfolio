<?php

namespace Portfolio\Entities;

class Production
{
    private int $idProduction;
    private string $title;
    private string $url;
    private string $path;
    private string $description;
    private string $createdAt;
    private ?string $html = null;
    private ?string $sass = null;
    private ?string $bootstrap = null;
    private ?string $js = null;
    private ?string $php = null;
    private ?string $symfony = null;
    private ?string $react = null;
    private ?string $wordpress = null;
    private int $idUser;
    

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
    public function setIdProduction(int $idProduction)
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
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of url
     */ 
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the value of url
     *
     * @return  self
     */ 
    public function setUrl(string $url)
    {
        $this->url = $url;

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
    public function setPath(string $path)
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
    public function setDescription(string $description)
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
    public function setCreatedAt(string $createdAt)
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
    public function setHtml( ?string $html): self
    {
        $this->html = $html;

        return $this;
    }

     /**
     * Get the value of sass
     */ 
    public function getSass()
    {
        return $this->sass;
    }

    /**
     * Set the value of sass
     *
     * @return  self
     */ 
    public function setSass(?string $sass): self
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
    public function setBootstrap(?string $bootstrap): self
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
    public function setJs(?string $js): self
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
    public function setPhp(?string $php): self
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
    public function setSymfony(?string $symfony): self
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
    public function setWordpress(?string $wordpress): self
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
    public function setReact(?string $react): self
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
    public function setIdUser(int $idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }
}
