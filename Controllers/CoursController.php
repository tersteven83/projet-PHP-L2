<?php

namespace App\Controllers;

use App\Models\CoursModel;
use App\Models\MatiereModel;
use App\Models\PersModel;

class CoursController extends Controller
{
    /**
     * créer un edt
     * @param string $classe 
     */
    public function create_timetable(string $classe, $semaineDe = null)
    {
        //récupérer la date
        if((isset($_POST['semaineDe']) && is_null($semaineDe))){
            //récupérer le jour de lundi ex 2014-04-05 => i=05 mois=2014-04-
            $semaineDe = $_POST['semaineDe'];
            $i = (int)substr($semaineDe, -2);
            $mois = substr($semaineDe, 0, -2);
        }
        elseif(!is_null($semaineDe)){
            $semaineDe = $this->debutSemaine($semaineDe);
            $i = (int)substr($semaineDe, -2);
            $mois = substr($semaineDe, 0, -2);
            
            //jerena raha efa misy edt zalah anatinle herinandro
            $coursModel = new CoursModel;
            if($coursModel->findByDate($semaineDe, $mois.($i+5), $classe)){
                $edt = $coursModel->findByDate($semaineDe, $mois.($i+5), $classe);
            }else{
                header('Location: /cours/create_timetable/' . $classe);
            }
        }
        
        //verifier si l'edt du jour n'est pas vide
        if (isset($_POST['lundi'])) $this->createEdtJour('lundi', $mois, $i, $classe);
        if (isset($_POST['mardi'])) $this->createEdtJour('mardi', $mois, $i + 1, $classe);
        if (isset($_POST['mercredi'])) $this->createEdtJour('mercredi', $mois, $i + 2, $classe);
        if (isset($_POST['jeudi'])) $this->createEdtJour('jeudi', $mois, $i + 3, $classe);
        if (isset($_POST['vendredi'])) $this->createEdtJour('vendredi', $mois, $i + 4, $classe);


        //atao ato ireo matieres ho alefa am cookies
        $matieres = [];

        //manokatra table matiere
        $matiereModel = new MatiereModel;
        $infoMatieres = $matiereModel->findBy(['id_classe' => $classe]);
        foreach ($infoMatieres as $infoMatiere) {
            $matieres[] = $infoMatiere->nom;
        }

        //matiere ho alefa any am cookies
        $matieres = implode(";", $matieres);
        //die($matieres);

        
        $this->render('cours/create_timetable', (isset($edt)) ? compact('edt', 'classe', 'matieres') : compact('classe', 'matieres'), 'admin');
    }



    /**
     * @param string $jour
     * @param string $mois yyyy-mm
     * @param int $jr lundi= +0, mardi= +1, mercredi= +2....
     * @param string $classe
     */
    private function createEdtJour(string $jour, string $mois, int $jr,  string $classe)
    {
        // 'lun_h1:php, lun_h2:java'....
        $jour = explode(',', $_POST["$jour"]);
        //$jour = ['lun_h1:php', 'lun_h2:java',....]


        //tokony oe 09, 06,.... ny miditra etsy am date_heure rehfa latsaky ny 10
        $jr = ($jr < 10) ? '0' . $jr : $jr;
        $date = $mois . $jr;

        foreach ($jour as $seance) {
            //raha misy 'h1' ao anatinle seance
            if (strstr($seance, 'h1')) $this->createSeance($seance, $date . " 07:30:00", $classe);
            if (strstr($seance, 'h2')) $this->createSeance($seance, $date . " 09:00:00", $classe);
            if (strstr($seance, 'h3')) $this->createSeance($seance, $date . " 10:30:00", $classe);
            if (strstr($seance, 'h4')) $this->createSeance($seance, $date . " 13:30:00", $classe);
            if (strstr($seance, 'h5')) $this->createSeance($seance, $date . " 15:00:00", $classe);
            if (strstr($seance, 'h6')) $this->createSeance($seance, $date . " 16:30:00", $classe);
        }
    }
    /**
     * crée un emploi du temps par séance
     * @param string $cour 
     * @param string $heure_date
     * @param string $classe
     * @return void
     */
    private function createSeance(string $cour, string $heure_date, string $classe)
    {
        //alaina le semaineDe hanaovana redirection aveo
        //$semaineDe = date_create($heure_date);
        $semaineDe = date('Y-m-d', strtotime($heure_date));

        //lun_h1:php => php
        $matiere = explode(':', $cour);
        $matiere = $matiere[1];
        

        // //si le matiere n'est pas null
        if ($matiere != 'null') {
            //on instancie une classe matiere pour récupére l'id_matiere de $matiere
            $matiereModel = new MatiereModel;
            $matiere = $matiereModel->findBy(['nom' => $matiere]);
            foreach($matiere as $matiere){
                $id_matiere = $matiere->id;
            }
            //on instancie une classe cours pours inserer l'edt
            $coursModel = new CoursModel;

            //on vérifie si il y a déjà un cours à la date donnée en paramètre
            //si oui, on update
            //sinon, on crée
            if ($coursModel->isEdtExist($heure_date, $classe)) {
                //on prend l'id du cours
                $id_cours = $coursModel->getIdCours(['date' => $heure_date, 'classe' => $classe]);
                //die($heure_date.' '.$classe);
                $id_cours = $id_cours->id;
                

                //on selecte la ligne à l'id_cours correspondant
                $cours = $coursModel->find($id_cours);

                //on mis à jour le nouveau id_matiere
                $cours->id_matiere = $id_matiere;
                $coursModel->hydrate($cours);
                // var_dump($coursModel);die;

                //on update
                $coursModel->update($id_cours);
                header('Location: /etudiant/afficheEdt/' . $semaineDe . '/' . $classe);
            }else {
                //on le crée
                $coursModel->setId_matiere($id_matiere)
                    ->setDate($heure_date)
                    ->setClasse($classe);

                //créer l'edt
                $coursModel->create();
                header('Location: /etudiant/afficheEdt/' . $semaineDe . '/' . $classe);
            }
        } else {
            // matiere = null
            $coursModel = new CoursModel;

            //vérifier si un cours est déja existant à cette date
            //on le supprime
            if($coursModel->isEdtExist($heure_date, $classe)) {
                //on prend l'id du cours
                $cours = $coursModel->findBy(['date' => $heure_date, 'classe' => $classe]);
                foreach($cours as $cour){
                    $id_cours = $cour->id;
                }
                $coursModel->delete($id_cours);
            }
            header('Location: /etudiant/afficheEdt/' . $semaineDe . '/' . $classe);
        }
    }

    /**
     * affichage de l'emploi du temps de la semaine
     */
    public function edtDeSemaine(string $deb, string $fin, string $classe='%')
    {
        $coursModel = new CoursModel;
        $persModel = new PersModel;
        
        //si l'utilisateur connecté est un personnel
        if(isset($_SESSION['user']['roles'])){
            $edt = $coursModel->findByDatePers($deb, $fin, $_SESSION['user']['id']);

            //nom du personnel ho alefa eny am view
            $nomPers = $persModel->find($_SESSION['user']['id']);
            $nomPers = $nomPers->nom;
        }else{
            $edt = $coursModel->findByDate($deb, $fin, $classe);
        }
        

        $this->render('cours/edtDeSemaine', compact('edt', 'deb'));
    }

    

}
