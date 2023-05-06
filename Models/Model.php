<?php

namespace App\Models;

use App\Core\Db;
use Exception;
use PDOException;

class Model extends Db
{
    //table de la base de donnée
    protected $table;

    //instance 
    private $db;
    

    public function requete(string $sql, array $attributs = null)
    {
        //on récupère l'instance du db
        $this->db = Db::getInstance();
        //var_dump($sql);

        if ($attributs != null) {
            $query = $this->db->prepare($sql);
            try {
                $query->execute($attributs);
            } catch (PDOException $th) {
                echo $sql . "\n";
                echo $th->getMessage();
            }
            
            return $query;
        } else {
            //requete simple
            try{
                return $this->db->query($sql);
            }catch(PDOException $e){
                echo $e->getMessage();
            }
            
        }
    }

    /**
     * Afficher le tableau tout entier
     */
    public function findAll()
    {
        $query = $this->requete('SELECT * FROM ' . $this->table);
        return $query->fetchAll();
    }

    /**
     * afficher la table depuis des critères
     * @param array $criteres 
     */
    public function findBy(array $criteres)
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
        return $this->requete('SELECT * FROM ' . $this->table . ' WHERE ' . $liste_champs, $valeurs)->fetchAll();
    }

    /**
     * rechercher depuis un id
     */
    public function find(int $id)
    {
        return $this->requete('SELECT * FROM ' . $this->table . ' WHERE id = ' . $id)->fetch();
    }

    /**
     * Ajouter à la table
     */
    public function create()
    {
        $champs = [];
        $inter = [];
        $valeurs = [];

        //On boucle pour éclater le tab
        foreach ($this as $champ => $valeur) {
            //INSERT INTO annonces (titre, description, actif) VALUES(?, ?, ?) 
            if ($valeur != null && $champ != 'db' && $champ != 'table') {
                $champs[] = $champ;
                $inter[] = "?";
                $valeurs[] = $valeur;
            }
        }

        //on transforme le tab champ en string
        $liste_champs = implode(', ', $champs);
        $liste_inter = implode(', ', $inter);

        //on execute la requete
        return $this->requete('INSERT INTO ' . $this->table . '  (' . $liste_champs . ') VALUES (' . $liste_inter . ')', $valeurs);

    }

    public function hydrate($donnees)
    {
        foreach ( $donnees as $key => $value ) {
            //on recupere le nom du setter correspondant à la clé
            //titre -> setTitre()
            $setter = 'set' . ucfirst($key);

            //on vérifie si le setter existe
            if(method_exists($this, $setter)){
                //on appelle le setter
                //echo "$setter($value) \n";continue;
                $this->$setter($value);
            }
        }
        return $this;
    }

    public function update(int $id)
    {
        $champs = [];
        $valeurs = [];
        
        foreach($this as $champ => $valeur){
            // UPDATE tabname SET col1 = ?, col2 =?, ... WHERE id = ?
            if($champ != 'db' && $champ != 'table' && $valeur != null && $champ != 'id'){
                $champs[] = "$champ=?";
                $valeurs[] = $valeur;
            }
        }
        $valeurs[]  = $id;
        $liste_champs = implode(', ', $champs);
        //var_dump($liste_champs);die;
        return $this->requete('UPDATE ' . $this->table . ' SET ' . $liste_champs . ' WHERE id=?', $valeurs);
    }

    public function delete(int $id)
    {
        return $this->requete('DELETE FROM ' . $this->table . ' WHERE id = ?', [$id]);
    }

    
   
}
