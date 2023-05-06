<?php

namespace App\Models;

class CoursModel extends Model
{
    protected $id;
    protected $id_matiere;
    protected $date;
    protected $classe;
    protected $nb_absents;
    
    public function __construct()  
    {
        $this->table  = "cours";
    }

    /**
     * recherche par date des matieres par classe
     * @param string $dep date de départ
     * @param string $fin date de fin
     * @param string $classe
     */
    public function findByDate(string $dep, string $fin, string $classe)
    {
        $query = $this->requete("SELECT matiere.nom as matiere, date, classe FROM $this->table INNER JOIN matiere ON $this->table.id_matiere = matiere.id WHERE classe LIKE ? AND date BETWEEN ? AND ? ORDER BY date;", array($classe,$dep, $fin));
        return $query->fetchAll();
    }

    /**
     * recherche par date sans heure
     * @param string $classe
     * @param string $date
     * @return array
     * 
     */
    public function findByDateWithoutHours(string $classe, string $date)
    {
        $date = $date . '%';
        $query = $this->requete("SELECT * FROM cours WHERE classe LIKE '$classe' AND date LIKE '$date';");
        return $query->fetchAll();
    }

    /**
     * recuperer l'edt du personnel à une durée déterminé
     */
    public function findByDatePers(string $deb, string $fin, int $id_resp)
    {
        $query = $this->requete("SELECT * FROM (SELECT matiere.nom as matiere, date, classe, id_resp FROM $this->table INNER JOIN matiere ON $this->table.id_matiere = matiere.id WHERE date BETWEEN ? AND ?) as a WHERE a.id_resp=?;", array($deb, $fin, $id_resp));
        return $query->fetchAll();
    }

    public function isEdtExist(string $date_heure, string $classe):bool
    {
        $query = $this->requete("SELECT * FROM $this->table WHERE date = ? AND classe = ?;", array($date_heure, $classe))->fetchAll();
        if($query) return true;
        return false;
    }

    public function getIdCours(array $criteres)
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
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }


    /**
     * Get the value of classe
     */ 
    public function getClasse()
    {
        return $this->classe;
    }

    /**
     * Set the value of classe
     *
     * @return  self
     */ 
    public function setClasse($classe)
    {
        $this->classe = $classe;

        return $this;
    }


    /**
     * Get the value of id_matiere
     */ 
    public function getId_matiere()
    {
        return $this->id_matiere;
    }

    /**
     * Set the value of id_matiere
     *
     * @return  self
     */ 
    public function setId_matiere($id_matiere)
    {
        $this->id_matiere = $id_matiere;

        return $this;
    }

    /**
     * Get the value of nb_absents
     */ 
    public function getNb_absents()
    {
        return $this->nb_absents;
    }

    /**
     * Set the value of nb_absents
     *
     * @return  self
     */ 
    public function setNb_absents($nb_absents)
    {
        $this->nb_absents = $nb_absents;

        return $this;
    }
}