<?php

namespace App\Models;

class MatiereModel extends Model
{
    protected $id;
    protected $nom;
    protected $id_resp;
    protected $id_classe;

    public function __construct()
    {
        $this->table = 'matiere';
    }

    /**
     * afficher le tableau de matiere avec les noms des responsables
     * @param string $classe classe à rechercher
     */
    public function findAllWithClass(string $classe)
    {
        $query = $this->requete("SELECT matiere.id, matiere.nom as nom, personnel.nom as 'resp', id_classe, personnel.id as id_resp FROM matiere INNER JOIN personnel ON matiere.id_resp=personnel.id WHERE id_classe='$classe'");
        return $query->fetchAll();
    }

    public function findAllButWithName()
    {
        $query = $this->requete("SELECT matiere.id, matiere.nom as nom, personnel.nom as 'resp', id_classe, personnel.id as id_resp FROM matiere INNER JOIN personnel ON matiere.id_resp=personnel.id");
        return $query->fetchAll();
    }
    /**
     * 
     */
    public function getIdMatiere(array $criteres)
    {
        
        $champs = [];
        $valeurs = [];

        //on boucle pour éclater le tableau
        foreach ($criteres as $champ => $valeur) {
            // SELECT * FROM tabname WHERE colName1 = ? AND colName2 = ?
            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
        }

        //on transforme le tab en string
        $liste_champs = implode(' AND ', $champs);

        //on execute la requete
        return $this->requete('SELECT id FROM ' . $this->table . ' WHERE ' . $liste_champs, $valeurs)->fetch();
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
     * Get the value of id_resp
     */ 
    public function getId_resp()
    {
        return $this->id_resp;
    }

    /**
     * Set the value of id_resp
     *
     * @return  self
     */ 
    public function setId_resp($id_resp)
    {
        $this->id_resp = $id_resp;

        return $this;
    }

    /**
     * Get the value of id_classe
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
}