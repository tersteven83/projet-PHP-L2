<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile utilisateur</title>
    <link rel="stylesheet" href="http://tests.yazz/bazouka/css/default.css">
    <?php if(strchr($_SERVER['REQUEST_URI'], "afficheEdt")):?>
        <link rel="stylesheet" href="http://tests.yazz/bazouka/css/EtudiantEDT.css" type="text/css">
    <?php endif; ?>
    <?php if(strchr($_SERVER['REQUEST_URI'], "create_timetable")):?>
        <link rel="stylesheet" href="http://tests.yazz/bazouka/css/create_timetable.css" type="text/css">
    <?php endif;?>
    <?php if(strchr($_SERVER['REQUEST_URI'], "appel")):?>
        <link rel="stylesheet" href="http://tests.yazz/bazouka/css/appel.css" type="text/css">
    <?php endif; ?>
    <?php if(strchr($_SERVER['REQUEST_URI'], "changeMdp")):?>
        <link rel="stylesheet" href="http://tests.yazz/PHP/css/mdp.css" type="text/css">
    <?php endif; ?>
</head>

<body>
    <div class="container">
        <nav>
            <div class="navbar">
                <a href="<?php if(strchr($_SERVER['REQUEST_URI'], 'pers')) echo '/pers/profil'; else echo '/etudiant/profil'?>">Profile</a>
                <a href="<?php if(strchr($_SERVER['REQUEST_URI'], 'pers')) echo '/pers/afficheEdt/' . date('y-m-d'); else echo '/etudiant/afficheEdt/' . date('Y-m-d')?>">Emploi du temps</a>
                <?php if(isset($_SESSION['user']['roles']) && strchr($_SESSION['user']['roles'], 'ROLE_ADMIN')): ?>
                    <a href="/assiduite/presence/l1/<?=date('Y-m-d')?>" id="btnAdmin" >Admin</a>
                <?php endif; ?>
            </div>
        </nav>
        <?php if(!empty($_SESSION['succes'])):?>
            <div class="alert-success" role="alert">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif ?> 
        <aside>
            <div class="sidebar">
                <div class="profile">
                    <div class="profileContent">
                        <p>
                            <?= $_SESSION['user']['nom']?><br>
                        </p>
                        <a href="<?php if(strchr($_SERVER['REQUEST_URI'], 'pers')) echo '/pers/changeMdp'; else echo '/etudiant/changeMdp'?>">Changer le mot de passe</a>
                        
                    </div>
                    <!--  -->
                    
                    <div class="btnLogOut">
                        <button class="btn" ><a style="text-decoration: none;color: inherit;" href="<?php if(strchr($_SERVER['REQUEST_URI'], 'pers')) echo '/pers/logout'; else echo '/etudiant/logout'?>">Déconnexion</a></button>
                        <?php if(isset($isStudent) && !$isStudent){?>
                            <input class="btn btn-save" type="button" id="btnSave" value="Enregistrer">
                        <?php }?>
                    </div>
                </div>
            </div>
        </aside>
        <?= $content ?>
    </div>
</body>
<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script> -->
<script>
</script>

</html>