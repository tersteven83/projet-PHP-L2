<?php

namespace App\Models;

class EtudiantModel extends Model
{
    protected $id;
    protected $nom;
    protected $prenom;
    protected $ddn;
    protected $cin;
    protected $sexe;
    protected $adresse;
    protected $tel;
    protected $email;
    protected $id_classe;
    protected $mdp;
    protected $absence;
    
    public function __construct()  
    {
        $this->table  = "tb_etudiant";
    }

    public function setSession()
    {
        $_SESSION['user'] = [
            'id' => $this->id,
            'email' => $this->email,
            'classe' => $this->id_classe,
            'nom' => $this->nom
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

   
    public function findNotIn(string $colName, array $notIn, string $classe='%')
    {
        //SELECT * FROM tb_etudiant WHERE id NOT IN(?, ?, ?)
        
        $inter = [];
        for($i=0; $i<count($notIn); $i++) {
            $inter[] = '?';
        }$list_inter = implode(',', $inter);
        //var_dump($notIn);

        $query = "SELECT * FROM $this->table WHERE $colName NOT IN ($list_inter) AND id_classe LIKE '$classe'";
        //var_dump($query);die;
        return $this->requete($query, $notIn)->fetchAll();
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
     * Get the value of id_classee
     */ 
    public function getId_classe()
    {
        return $this->id_classe;
    }

    /**
     * Set the value of id_classe
     *
     * @return  self
     */ 
    public function setId_classe($id_classe)
    {
        $this->id_classe = $id_classe;

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

    /**
     * Get the value of absence
     */ 
    public function getAbsence()
    {
        return $this->absence;
    }

    /**
     * Set the value of absence
     *
     * @return  self
     */ 
    public function setAbsence($absence)
    {
        $this->absence = $absence;

        return $this;
    }
}