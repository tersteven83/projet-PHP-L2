<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\PersModel;

class PersController extends Controller
{
    public function index()
    {
        if($this->isConnected()){
            $persModel = new PersModel;
            $personnels = $persModel->findAll();
    
            $this->render('pers/index', compact('personnels'), 'admin');
        }
       
    }

    public function profil()
    {
        //vonoina ny session admin
        unset($_SESSION['admin']);
        if ($this->isConnected()) {
            $persModel = new PersModel;
            $pers = $persModel->find($_SESSION['user']['id']);
            // var_dump($_SESSION);die;

            $this->render('etudiant/profil', ['content' => $pers]);
        } 
    }

    public function afficheEdt(string $date, int $id_pers=null)
    {
        $deb = $this->debutSemaine($date);
        
        //date de fin
        $date = date_create($deb);
        date_modify($date, "+5 days");
        $fin = date_format($date, 'Y-m-d');

        //connecté en tant que simple personnel
        if($this->isConnected() && !isset($_SESSION['admin'])){
            $edt = new CoursController;
            $edt->edtDeSemaine($deb, $fin);
            return;
        }
        //connecté en tant qu'admin
        elseif ($this->isAdmin()){
            $edt = new AdminController;
            $edt->edtDeSemaine($deb, $fin, true, '%', $id_pers);
        }
        
    }

    public function login()
    {
        //on vérifie si le formulaire est complet
        if (Form::validate($_POST, ['email', 'pass'])) {
            //on va chercher dans la base de donnée l'user avec l'enail entré
            $persModel = new PersModel;
            $persArray = $persModel->findBy(['email' => $_POST['email']]);

            //si le personnel n'existe pas
            if (!$persArray) {
                //on envoie une message de session
                $_SESSION['erreur'] = 'L\'adresse e-mail et/ou le mot de passe est incorrect';
                header('Location: /pers/login');
                exit;
            }

            //var_dump($persArray);die;
            //le personnel existe
            $pers = $persModel->hydrate($persArray[0]);

            //on vérifie si le mdp est correct
            if (password_verify($_POST['pass'], $pers->getMdp()) || $pers->getMdp() == $_POST['pass']) {
                // die('coucou');
                $pers->setSession();
                header('Location: /pers/profil');
            } else {
                //die('coucou');
                //mauvais mdp
                // on envoie un message de session
                $_SESSION['erreur'] = 'L\'adresse e-mail et/ou le mot de passe est incorrect';
                header('Location: /pers/login');
                exit();
            }
        }
        $this->render('pers/login', [], 'formulaire');
    }

    public function changeMdp()
    {
        if ($this->isConnected()) {
            //var_dump($_POST);
            //vérifié si tous les champs sont remplis
            if (Form::validate($_POST, ['antPass', 'newPass', 'newPassCon'])) {
                //var_dump($_POST);die;
                //on verifier si l'ancien mdp correspond à l'utilisateur connecté
                $persModel = new PersModel;
                $persArray = $persModel->find($_SESSION['user']['id']);

                //si c'est son mdp est encore son nom, on vérifie directement avec l'ancien mdp entrée par l'user sinon on verifie le cryptage
                if (($persArray->mdp == $_POST['antPass'] || password_verify($_POST['antPass'], $persArray->mdp)) && $_POST['newPass'] == $_POST['newPassCon']) {
                    //afenina le mdp
                    $persArray->mdp = password_hash($_POST['newPass'], PASSWORD_BCRYPT);
                    $persModel->hydrate($persArray);
                    $persModel->update($_SESSION['user']['id']);
                    header('Location: /pers/profil');
                    $_SESSION['success'] = "Votre modification a étébien enregistré";
                    exit;
                } else {
                    // echo "diso";
                    $_SESSION['erreur'] = "Votre mot de passe est incorrect";
                    header('Location: /pers/changeMdp');
                    
                    exit;
                }
            }
            $this->render('pers/changeMdp', []);
        }
    }

    public function ajouter()
    {
        //if(isset($_POST)) var_dump($_POST);
        if($this->isConnected()){
            if (isset($_POST)) {
                if (Form::validate($_POST, ['nom', 'prenom', 'ddn', 'tel', 'cin', 'adresse'])) {
    
                    // var_dump($_POST);die;
    
                    //on instancie une model 
                    $persModel = new PersModel;
    
                    $persModel->hydrate([
                        'nom' => $_POST['nom'],
                        'prenom' => $_POST['prenom'],
                        'ddn' => $_POST['ddn'],
                        'sexe' => $_POST['sexe'],
                        'email' => $_POST['email'],
                        'tel' => $_POST['tel'],
                        'cin' => $_POST['cin'],
                        'adresse' => $_POST['adresse'],
                        'mdp' => strtolower($_POST['nom']),
                        'roles' => (isset($_POST['roles'])) ? $_POST['roles'] : null
                    ]);
    
                    //var_dump($persModel);die;
    
                    $persModel->create();
                    $_SESSION['success'] = "Votre requête a été bien enregistré.";
                }
            }
            $this->render('pers/ajouter', [], 'admin');
        }
        
    }

    public function modifier(int $id)
    {
        $persModel = new PersModel;
        if ($this->isAdmin()) {
            if (isset($_POST) && !empty($_POST)) {
                
                if(Form::validate($_POST, ['nom', 'prenom', 'ddn', 'tel', 'cin', 'adresse'])){
                    //var_dump($_POST);die;
                    //die('coucouo');
                    $persModel->hydrate([
                        'nom' => $_POST['nom'],
                        'prenom' => $_POST['prenom'],
                        'ddn' => $_POST['ddn'],
                        'sexe' => $_POST['sexe'],
                        'email' => $_POST['email'],
                        'tel' => $_POST['tel'],
                        'cin' => $_POST['cin'],
                        'adresse' => $_POST['adresse'],
                        'mdp' => strtolower($_POST['nom']),
                        'roles' => (isset($_POST['roles'])) ? $_POST['roles'] : 'ROLE_USER'
                    ]);

                    //raha ilay admin no manala ny tenany ho admin de mideconnect le compte
                    $persModel->update($id);
                    if($id == $_SESSION['user']['id']){
                        $_SESSION['info'] = "Votre session a expiré";
                        $this->logout();
                    }
                    // var_dump($persModel);die;
                    $_SESSION['success'] = "Votre modification a été bien enregistré.";
                    header('Location: /pers');
                    exit;
                }else{
                    $_SESSION['erreur'] = "Veuillez bien remplir la formulaire";
                    header('Location: /pers/modifier/'.$id);
                }
            }
            $pers = $persModel->find($id);
            // var_dump($pers->tel);die;


            $this->render('pers/modifier', compact('pers'), 'admin');
        }
    }

    public function supprimer(int $id)
    {
        $persModel = new PersModel;
        $persModel->delete($id);
        //back tp preview url
        $_SESSION['success'] = "La suppression a été effectué avec succés";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        
    }


    /**
    * deconnexion
    */
    public function logout()
    {
        unset($_SESSION['user']);
        unset($_SESSION['erreur']);
        unset($_SESSION['admin']);
        header('Location: /pers/login');
        exit();
    }
}
