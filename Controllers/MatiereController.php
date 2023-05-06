<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\MatiereModel;
use App\Models\PersModel;

class MatiereController extends Controller
{
    /**
     * Afficher tous les matières d'une classe
     * @param string $classe
     */
    public function index(string $classe)
    {
        $matiereModel = new MatiereModel;
        $matiereModel = $matiereModel->findAllWithClass($classe);
        //var_dump($matiereModel);die;

        $this->render('matiere/index', ['matieres' => $matiereModel, 'classe' => $classe], 'admin');
    }
    /**
     * Modifier une matiere
     * @param string $classe
     * @param int $id id de la matière
     */
    public function modifier(string $classe, int $id)
    {
        
        $data = (!empty(file_get_contents("php://input"))) ? json_decode(file_get_contents("php://input"), true) : null;
        
        if(!is_null($data)){

            //on prend les contenus du $data
            $matiere = $data['nom'];
            //eto le mbola rakoto/1
            $resp_with_id = $data['resp'];

            //sarahana amzay ny nom du responsable sy ny id any
            $resp_with_id = explode('/', $resp_with_id);
            //ilay id ao am tab[1]
            $id_resp = (int)$resp_with_id[1];

            $matiereAjour = new MatiereModel;
            $matiereAjour->setNom($matiere)
                ->setId_resp($id_resp)
                ->setId_classe($classe)
            ;
            $matiereAjour->update($id);

            $_SESSION['success'] = "Votre modification a été enregistré";

        }else{

        } 
    }

    /**
     * Supprimer un matière
     * @param string $classe
     * @param int $id
     */
    public function supprimer(int $id)
    {
        $matiereModel = new MatiereModel;
        $matiereModel->delete($id);
        $_SESSION['success'] = "La suppression est réussi";
        //back tp preview url
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }

    /**
     * Ajouter une matiere
     */
    public function ajouter()
    {
        if(Form::validate($_POST, ['nom'])){
            $nom = $_POST['nom'];
            $nom = strip_tags($nom);

            //on prend l'id du responsable
            $resp = explode('/', $_POST['resp']);
            $id_resp = (int)$resp[1];

            $classe = $_POST['classe'];

            //on instancie une classe maatiere
            $matiereModel = new MatiereModel;
            $matiereModel->setNom($nom)
                ->setId_resp($id_resp)
                ->setId_classe($classe)
            ;

            $matiereModel->create();

            
            
            //url précédent
            $previewURL = $_SERVER['HTTP_REFERER'];
            header('Location: ' . $previewURL);
            $_SESSION['success'] = "La matière a été bien enregistrée";
            exit;
            
        }
        //ireto no hakana anle nom de personnel 
        $persModel = new PersModel;
        $persModel = $persModel->findAll();

        
        $this->render('matiere/ajouter', ['personnels'=>$persModel], 'admin');
    }
}