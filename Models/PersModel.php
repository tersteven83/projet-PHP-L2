<?php

namespace App\Models;

class PersModel extends Model
{
    protected $id;
    protected $nom;
    protected $prenom;
    protected $ddn;
    protected $sexe;
    protected $cin;
    protected $adresse;
    protected $email;
    protected $tel;
    protected $mdp;
    protected $roles;

    public function __construct()
    {
        $this->table = 'personnel';
    }

    public function setSession()
    {
        $_SESSION['user'] = [
            'id' => $this->id,
            'nom' => $this->nom,
            'email' => $this->email,
            'roles' => $this->roles
        ];
    }

    /**
     * Récupérer un user à partir de son e-mail
     * @param string $email
     * @return mixed
     */
    public function findOneByEmail(string $email)
    {
        return $this->requete("SELECT * FROM $this->table WHERE email = ?", array($email))->fetch();
    }

    /**
     * Get the value of roles
     */ 
    public function getRoles(): array
    {
        $roles = explode(',', $this->roles); 
        return $roles;
    }

    /**
     * Set the value of roles
     *
     * @return  self
     */ 
    public function setRoles($roles)
    {
        $this->roles = $roles;
        
        return $this;
    }

    /**
     * Get the value of nom
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of prenom
     */ 
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @return  self
     */ 
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of cin
     */ 
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * Set the value of cin
     *
     * @return  self
     */ 
    public function setCin($cin)
    {
        $this->cin = $cin;

        return $this;
    }

    /**
     * Get the value of adresse
     */ 
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set the value of adresse
     *
     * @return  self
     */ 
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of tel
     */ 
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set the value of tel
     *
     * @return  self
     */ 
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get the value of mdp
     */ 
    public function getMdp()
    {
        return $this->mdp;
    }

    /**
     * Set the value of mdp
     *
     * @return  self
     */ 
    public function setMdp($mdp)
    {
        $this->mdp = $mdp;

        return $this;
    }

    /**
     * Get the value of ddn
     */ 
    public function getDdn()
    {
        return $this->ddn;
    }

    /**
     * Set the value of ddn
     *
     * @return  self
     */ 
    public function setDdn($ddn)
    {
        $this->ddn = $ddn;

        return $this;
    }

    /**
     * Get the value of sexe
     */ 
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set the value of sexe
     *
     * @return  self
     */ 
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}