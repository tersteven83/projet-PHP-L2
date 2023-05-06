<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\CoursModel;
use App\Models\EtudiantModel;

class EtudiantController extends Controller
{

    public function index(string $classe)
    {
        if ($this->isConnected()) {


            $etudiantModel = new EtudiantModel;
            $etudiants = $etudiantModel->findBy(['id_classe' => $classe]);

            $this->render('etudiant/index', compact('etudiants', 'classe'), 'admin');
        }
    }

    /**
     * cachier d'appel
     * @param string $classe
     * @param string $date date du cahier d'appel
     */
    public function appel(string $classe, $date)
    {
        //connecté en tant que personnnel
        if ($this->isConnected() && isset($_SESSION['user']['roles'])) {
            //alaina ny fiche de presence avy any am post
            if (isset($_POST['absents'])) {
                //on instancie une classe etudiant
                $etudiantModel = new EtudiantModel();


                //otrzao ny poziny tonga avy any
                //12,3,4,10  <= ireo id
                $absents = explode(',', $_POST['absents']);

                //avadika ho int daholo ny type donnée ao anatinle $absents
                $absentIDs = array_map('intval', explode(',', $_POST['absents']));
                //var_dump($absentIDs);die;

                //si l'user est admin, il peut modifier les présences des él1eves à une date donnée
                if ($this->isAdmin() && isset($_SESSION['admin'])) {
                    //on modifie la valeur du colonne absebce de la table etudiant en 0 s'il a été chécké par l'admin
                    $etudiantPresArray = $etudiantModel->findNotIn('id', $absentIDs, $classe);
                    //var_dump($etudiantPresArray);die("coucou");

                    //parcourir la tableau des etudiants present et chécker son absence si egale à 'o'
                    //si c'est égale à 'o', on modifie en 'n'
                    foreach ($etudiantPresArray as $etudiantPres) {
                        if ($etudiantPres->absence == 'n') {
                            continue;
                        } elseif ($etudiantPres->absence == 'o') {
                            //sinon on modifie absence = 'n' 
                            //fa tsy maintsy avadika string ny chiffre fa mitady tsy ho raisinle update
                            $etudiantPres->absence = 'n';
                            //var_dump($etudiantPres);die;

                            $etudiantModel->hydrate($etudiantPres);
                            //var_dump($etudiantModel);die;
                            $etudiantModel->update($etudiantPres->id);
                            header('Location: ' . $_SERVER['HTTP_REFERER']);
                            $_SESSION['success'] = "Vos modifications ont été pris en compte";
                        }
                    }
                }

                //on prend le nb d'absent dans la classe à la date donnée
                $nbAbs = count($absents);

                //inserer le nombre d'absent dans la colonne cours.nb_absents de la table cours avec consideration la $date
                //on instancie une classe cours
                $coursModel = new CoursModel;
                $coursArray = $coursModel->findByDateWithoutHours($classe, $date);

                //parcourir tous les coursArray
                //mettre à jour le nb_absents de chacun
                foreach ($coursArray as $cours) {
                    $cours->nb_absents = $nbAbs;

                    $coursModel->hydrate($cours);
                    $coursModel->update($cours->id);
                }

                //on modifie la valeur de absence du colonne absence de la table etudiant en 1 => absent


                for ($i = 0; $i < $nbAbs; $i++) {
                    $eleveAbs =  (int)$absents[$i];

                    //on recherche l'élève avec l'id specifié
                    $etudiant = $etudiantModel->find($eleveAbs);
                    //var_dump($etudiant);die;
                    $etudiant->absence = "o";

                    $etudiantModel->hydrate($etudiant);
                    $etudiantModel->update($eleveAbs);
                    $_SESSION['success'] = "Vos modifications ont été pris en compte";
                }
            }

            //on instancie une classe model
            $etudiantModel = new EtudiantModel;
            $etudiants = $etudiantModel->findBy(['id_classe' => $classe]);
            // var_dump($etudiants);die;

            $isStudent = false;

            if ($this->isAdmin() && isset($_SESSION['admin'])) {
                $this->render('admin/appel', compact('etudiants', 'classe', 'date'), 'admin');
            } else {
                //die('coucou');
                $this->render('etudiant/appel', compact('etudiants', 'classe', 'isStudent', 'date'));
            }
        }
        //connecté mais en tant qu'Etudiant
        elseif ($this->isConnected() && isset($_SESSION['user']['classe'])) {
            //on instancie une classe model
            $etudiantModel = new EtudiantModel;
            $etudiants = $etudiantModel->findBy(['id_classe' => $classe]);

            $isStudent = true;

            $this->render('etudiant/appel', compact('etudiants', 'classe', 'isStudent', 'date'));
        }

        //connect
    }

    public function profil()
    {
        
        if ($this->isConnected()) {
            $etudiantModel = new EtudiantModel;
            $etudiant = $etudiantModel->find($_SESSION['user']['id']);

            $this->render('etudiant/profil', ['content' => $etudiant]);
        }
    }

    public function afficheEdt(string $date, string $classe = null)
    {
        //lundi de la semaine à la date donnée
        $date = $this->debutSemaine($date);
        $deb = $date;

        //date de fin
        $date = date_create($date);
        date_modify($date, "+5 days");
        $fin = date_format($date, 'Y-m-d');

        //connecté en tant qu'étudiant
        if (isset($_SESSION['user']) && isset($_SESSION['user']['classe'])) {

            $edt = new CoursController;
            $edt->edtDeSemaine($deb, $fin, $_SESSION['user']['classe']);
        }
        //connecter en tant qu'admin
        if ($this->isAdmin()) {
            $edt = new AdminController;
            $edt->edtDeSemaine($deb, $fin, false, $classe);
        }
    }

    public function login()
    {
        //on vérifie si le formulaire est complet
        if (Form::validate($_POST, ['email', 'pass'])) {
            //mesure de securite
            $email = strip_tags($_POST['email']);
            //on va chercher dans la base de donnée l'user avec l'enail entré
            $etudiantModel = new EtudiantModel;
            $etudiantArray = $etudiantModel->findOneByEmail($email);

            //si l'étudiant n'existe pas
            if (!$etudiantArray) {
                //on envoie une message de session
                $_SESSION['erreur'] = 'L\'adresse e-mail et/ou le mot de passe est incorrect';
                header('Location: /etudiant/login');
                exit;
            }

            //l'etudiant existe
            $etudiant = $etudiantModel->hydrate($etudiantArray);

            //on vérifie si le mdp est correct
            if (password_verify($_POST['pass'], $etudiant->getMdp()) || $etudiant->getMdp() == $_POST['pass']) {
                //die('coucou');
                $etudiant->setSession();
                header('Location: /etudiant/profil');
            } else {
                //die('coucou');
                //mauvais mdp
                // on envoie un message de session
                $_SESSION['erreur'] = 'L\'adresse e-mail et/ou le mot de passe est incorrect';
                header('Location: /etudiant/login');
                exit();
            }
        }

        $this->render('etudiant/login', [], 'formulaire');
    }

    public function changeMdp()
    {
        //vérifié si tous les champs sont remplis
        if (Form::validate($_POST, ['antPass', 'newPass', 'newPassCon'])) {
            //on verifier si l'ancien mdp correspond à l'utilisateur connecté
            $etudiantModel = new EtudiantModel;
            $etudiantArray = $etudiantModel->find($_SESSION['user']['id']);

            //si c'est son mdp est encore son nom, on vérifie directement avec l'ancien mdp entrée par l'user sinon on verifie le cryptage
            if (($etudiantArray->mdp == $_POST['antPass'] || password_verify($_POST['antPass'], $etudiantArray->mdp)) && $_POST['newPass'] == $_POST['newPassCon']) {
                //afenina le mdp
                $etudiantArray->mdp = password_hash($_POST['newPass'], PASSWORD_BCRYPT);
                $etudiantModel->hydrate($etudiantArray);
                $etudiantModel->update($_SESSION['user']['id']);
            } else {
                $_SESSION['erreur'] = "Votre mot de passe est incorrect";
                header('Location: /etudiant/changeMdp');
                exit;
            }
        }
        $this->render('etudiant/changeMdp', []);
    }

    public function ajouter()
    {
        //vérifier si l'utilisateur est un administrateur
        if ($this->isAdmin()) {
            if (isset($_POST) && !empty($_POST)) {
                if (Form::validate($_POST, ['nom', 'ddn', 'tel', 'adresse'])) {

                    //on instancie une model 
                    $etudiantModel = new EtudiantModel;

                    $etudiantModel->hydrate([
                        'nom' => $_POST['nom'],
                        'prenom' => $_POST['prenom'],
                        'ddn' => $_POST['ddn'],
                        'sexe' => $_POST['sexe'],
                        'email' => $_POST['email'],
                        'tel' => $_POST['tel'],
                        'cin' => $_POST['cin'],
                        'adresse' => $_POST['adresse'],
                        'mdp' => strtolower($_POST['nom']),
                        'id_classe' => $_POST['classe']
                    ]);


                    $etudiantModel->create();
                    $_SESSION['success'] = "Votre requête a été bien enregistré.";
                    header('Location: /etudiant/index/'.$etudiantModel->getId_classe());
                    exit;

                } else {
                    $_SESSION['erreur'] = "Veuillez bien remplir la formulaire";
                    header('Location: /etudiant/ajouter');
                    var_dump($_SESSION);die;
                    //unset($_SESSION['erreur']);
                }
            } else {
            }

            $this->render('etudiant/ajouter', [], 'admin');
        }
    }

    public function modifier(int $id)
    {
        $etudiantModel = new etudiantModel;
        if ($this->isAdmin()) {
            if (isset($_POST) && !empty($_POST)) {
                
                if(Form::validate($_POST, ['nom', 'ddn', 'tel', 'adresse'])){
                    $etudiantModel->hydrate([
                        'nom' => $_POST['nom'],
                        'prenom' => $_POST['prenom'],
                        'ddn' => $_POST['ddn'],
                        'sexe' => $_POST['sexe'],
                        'email' => $_POST['email'],
                        'tel' => $_POST['tel'],
                        'cin' => $_POST['cin'],
                        'adresse' => $_POST['adresse'],
                        'mdp' => strtolower($_POST['nom']),
                        'id_classe' => $_POST['classe']
                    ]);

                    $etudiantModel->update($id);
                    $_SESSION['success'] = "Votre modification a été bien enregistré.";
                    header('Location: /etudiant/index/'. $etudiantModel->getId_classe());
                    exit;
                }else{
                    $_SESSION['erreur'] = "Veuillez bien remplir la formulaire";
                    header('Location: /etudiant/modfier/'.$id);
                }
            }
            $etud = $etudiantModel->find($id);
            //var_dump($etud);die;

            $this->render('etudiant/modifier', compact('etud'), 'admin');
        }
    }

    public function supprimer(int $id)
    {
        $etudiantModel = new EtudiantModel;
        $etudiantModel->delete($id);
        //back tp preview url
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }



    /**
     * deconnexion
     */
    public function logout()
    {
        unset($_SESSION['user']);
        unset($_SESSION['erreur']);
        header('Location: /etudiant/login');
        exit();
    }
}
