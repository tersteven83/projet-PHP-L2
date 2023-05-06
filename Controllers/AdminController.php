<?php

namespace App\Controllers;

use App\Models\CoursModel;
use App\Models\PersModel;

class AdminController extends Controller
{
    /**
     * emploi du temps de la semaine
     * @param string $deb debut de la semaine
     * @param string $fin fin de la semaine
     * @param boolean $isPers personnel ou non
     * @param string $classe 
     * @param int $id_pers id du personnel à chercher edt
     */
    public function edtDeSemaine(string $deb, string $fin, bool $isPers, string $classe='%', int $id_pers=null)
    {
        $coursModel = new CoursModel;
        $persModel = new PersModel;
        if($this->isAdmin()){
            if(!$isPers){
                $edt = $coursModel->findByDate($deb, $fin, $classe);
                $this->render('cours/edtDeSemaine', compact('edt', 'deb', 'classe'), 'admin');
            }else{
                $edt = $coursModel->findByDatePers($deb, $fin, $id_pers);
                //nom du personnel ho alefa eny am view
                $pers = $persModel->find($id_pers);
                $nomPers = $pers->nom;
                $sexePers = (strtolower($pers->sexe)  == 'f') ? 'Mme' : 'M.';
                $this->render('cours/edtDeSemaine', compact('edt', 'deb', 'nomPers', 'sexePers'), 'admin');
            }
        }
           
    }
}