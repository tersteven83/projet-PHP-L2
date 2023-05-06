<?php

namespace App\Controllers;

use App\Models\CoursModel;
use App\Models\EtudiantModel;

class AssiduiteController extends Controller
{
    /**
     * Assuidité de la présence des éltudiants
     */
    //eto no mandeh any am page admin
    public function presence(string $classe, string $date)
    {
        //vo mandeh am page admin izy de mamorona session admin
        $_SESSION['admin'] = true;
        //rehefa mikitika anle sortie ao amle page admin izy de mila vonoina io

        
        //vérifier si on est admin 
        if($this->isAdmin()){
            //raha anelanelam-potoana be ilay date de atao miverina lundi
            $week = date('w', strtotime($date));
            $day = date('d', strtotime($date));
            $month = date('m', strtotime($date));
            $year = date('Y', strtotime($date));
            if($week != 1){
                $day = $day-$week+1;
            }

            $date = $year . '-' . $month . '-' . $day;
            $semaineDe = $day . '/' . $month . '/' . $year;
            //créer une date
            $date = date_create($date);

            //on parcours toutes les dates de la semaine
            //on rempli les datapoints suivants
            $dataPoints = [
                ['label' => 'Lundi', 'y' => null],
                ['label' => 'Mardi', 'y' => null],
                ['label' => 'Mercredi', 'y' => null],
                ['label' => 'Jeudi', 'y' => null],
                ['label' => 'Vendredi', 'y' => null]
            ];
            $coursModel = new CoursModel;
            $etudiantModel = new EtudiantModel;
            for($i = 0; $i <5; $i += 1){
                //on modifie la date
                if($i != 0) date_modify($date, '+1 days');

                //var_dump($date);continue;

                //on récupère le nombre d'absent dans la classe à la date précédent
                $dateToString  = date_format($date, 'Y-m-d');
                $cours = $coursModel->findByDateWithoutHours($classe, $dateToString);
                
                
                //s'il n'y a pas de cours à la date donnée, on continue directement la boucle
                if(is_null($cours) || empty($cours[0]))continue;
                
                $nbAbs = $cours[0]->nb_absents;

                //on recupere le nombre total des étudiants à la classe donnée
                $etudiants = $etudiantModel->findBy(['id_classe' => $classe]);
                $nbTotal = count($etudiants);

                //tonga de mivoaka raha ny nb total anle etudiatn = 0
                if($nbTotal==0)break;

                //on récupère le pourcentage des étudiants présents
                $nbPres = $nbTotal - $nbAbs;
                $pourcentPres = 100 * $nbPres / $nbTotal;

                //on affecte le pourcentage des presents dans l'ordonnée du jour
                $dataPoints[$i]['y'] = $pourcentPres;
                
                
            }

            $this->render('assiduite/presence', compact('dataPoints', 'classe', 'semaineDe'), 'admin');
        }
    }
}