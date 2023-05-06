<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Administrateur</title>
  <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>


<!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css'>
    <link rel="stylesheet" href="http://tests.yazz/bootstrap-sidebar/dist/style.css">

    <?php if(strchr($_SERVER['REQUEST_URI'], "appel")):?>
        <link rel="stylesheet" href="http://tests.yazz/bazouka/css/admin/appel.css" type="text/css">
    <?php endif; ?>

    
</head>
<body>
<!-- partial:index.partial.html -->
<div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><?=$_SESSION['user']['nom']?> vous êtes en mode Admin</h3>
            </div>

            <ul class="list-unstyled components">
                <li class="active">
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Etudiant</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                            <a href="/etudiant/index/l1">L1</a>
                        </li>
                        <li>
                            <a href="/etudiant/index/l2">L2</a>
                        </li>
                        <li>
                            <a href="/etudiant/index/l3">L3</a>
                        </li>
                        <li>
                            <a href="/etudiant/index/m1">M1</a>
                        </li>
                        <li>
                            <a href="/etudiant/index/m2">M2</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="/pers">Personnel</a>
                </li>
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Assuduité</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                            <a href="/assiduite/presence/l1/<?=date('Y-m-d')?>">L1</a>
                        </li>
                        <li>
                            <a href="/assiduite/presence/l2/<?=date('Y-m-d')?>">L2</a>
                        </li>
                        <li>
                            <a href="/assiduite/presence/l3/<?=date('Y-m-d')?>">L3</a>
                        </li>
                        <li>
                            <a href="/assiduite/presence/m1/<?=date('Y-m-d')?>">M1</a>
                        </li>
                        <li>
                            <a href="/assiduite/presence/m2/<?=date('Y-m-d')?>">M2</a>
                        </li>
                    </ul>
                </li>
              <!--  
            </ul>

            <ul class="list-unstyled CTAs">
                <li>
                    <a href="https://bootstrapious.com/tutorial/files/sidebar.zip" class="download">Download source</a>
                </li>
                <li>
                    <a href="https://bootstrapious.com/p/bootstrap-sidebar" class="article">Back to article</a>
                </li>
            </ul>-->
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span></span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            
                            <!-- <li  class="nav-item active">
                                <a style="font-weight: bold;" class="nav-link" href="#">Gestion des information</a>
                            </li> -->
        <!-- Rehefa misy oe 'etudiant eo am url de apiana an'ireto' -->
                            <?php if(!strchr($_SERVER['REQUEST_URI'], 'assiduite') && !strchr($_SERVER['REQUEST_URI'], 'pers') && !strchr($_SERVER['REQUEST_URI'], 'matiere/ajouter') ): ?>
                                <li class="nav-item">
                                    <a href="/etudiant/index/<?=strtoupper($classe)?>" class="btn btn-outline-info" role="button">Liste</a>
                                </li>
                                <li class="nav-item">
                                    <a href="/etudiant/appel/<?= strtoupper($classe) . '/' . date('Y-m-d')?>" class="btn btn-outline-info" role="button">Cahier d'appel</a>
                                </li>
                                <li class="nav-item">
                                    <a href="/etudiant/afficheEdt/<?=date('y-m-d')?>/<?= strtoupper($classe); ?>" class="btn btn-outline-info" role="button">Emploi du temps</a>
                                </li>
                            <?php endif; ?>
                            
                            
                            <li class="nav-item">
                                <a class="btn btn-info" role="button" href="/pers/profil">Sortir</a>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </nav>

            

            <!-- raha misy mot edt eo am url de mi'ajouter anreto ambany ireto -->
            <?php if(strchr($_SERVER['REQUEST_URI'], 'Edt')):?>
                
            <?php endif; ?>

            <?php if(!empty($_SESSION['success'])): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $_SESSION['success']; unset($_SESSION['success']);?>
                </div>
                <?php endif; ?>
                <?php if(!empty($_SESSION['erreur'])): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_SESSION['erreur']; unset($_SESSION['erreur']);?>
                </div>
            <?php endif; ?>
                
            <?=$content?>
            
        </div>
    </div>
<!-- partial -->
  <script>
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });
    });
  </script>

</body>
</html>
