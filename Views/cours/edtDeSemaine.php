<!-- user conncté en mode admin -->
<?php if(isset($_SESSION['admin'])):?>
    <!-- user dans la page des étudiants -->
    <?php if(!strchr($_SERVER['REQUEST_URI'], 'pers')):?>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top">
        <ul class="navbar-nav row">
            <li class="nav-item  col-1">
                <a href="/etudiant/afficheEdt/<?=date('Y-m-d')?>/L1" id="l1" class="nav-link">L1</a>
            </li>
            <li class="nav-item  col-1">
                <a href="/etudiant/afficheEdt/<?=date('Y-m-d')?>/l2" id="l2" class="nav-link">L2</a>
            </li>
            <li class="nav-item  col-1">
                <a href="/etudiant/afficheEdt/<?=date('Y-m-d')?>/l3" id="l3" class="nav-link">L3</a>
            </li>
            <li class="nav-item  col-1">
                <a href="/etudiant/afficheEdt/<?=date('Y-m-d')?>/m1" id='m1' class="nav-link">M1</a>
            </li>
            <li class="nav-item  col-1">
                <a href="/etudiant/afficheEdt/<?=date('Y-m-d')?>/m2" id="m2" class="nav-link">M2</a>
            </li>
            <li class="nav-item col" style="transform: translateX(155%)">
                <!-- <nav class="navbar navbar-expand-sm bg-dark navbar-dark"> -->
                <div class="form-inline">
                    <input type="date" id="searchDate" class="form-control datepicker w-70"  name="searchDate" />
                    <button class="btn btn-success" id="btnSearch">Rechercher</button>
                </div>
                <!-- </nav> -->
            </li>

        </ul>
    </nav>
    <?php endif; ?>
    <div class="row">
        <div class="col">
            <!-- affiche edt d'un prof -->
            <?php if(isset($sexePers) && isset($nomPers)){?>
            <h2>Emploi du temps de la semaine de
                <?php echo date('d-m-Y',strtotime($deb) ) . ' de ' . $sexePers . ' '. $nomPers?> </h2>
            <?php }else{?>
            <h2>Emploi du temps de la semaine de <?php echo date('d-m-Y',strtotime($deb))?> de la classe <?=$classe?></h2>
            <?php }?>
        </div>
        <!-- raha misy hoe pers ny eny am url de tsy aseho ireto -->
        <?php if(!strchr($_SERVER['REQUEST_URI'], 'pers')):?>
        <div class="col-2" style="right: 1.5%;">
            <div class="btn-group">
                <!-- alaina ny date eo am url, ka raha latsaky ny debut de semaine amzao de esorina teo le btn modifier -->
                <?php $dateUrl = explode('/', $_SERVER['REQUEST_URI']); $dateUrl = $dateUrl[3]; if(date_create($dateUrl) >= date_create(date('Y-m-d')) ): ?>
                <a href="/cours/create_timetable/<?=$classe . '/' .date('Y-m-d')?>" class="btn btn-primary"
                    role="button">Modifier</a>
                <?php endif; ?>
                <a href="/cours/create_timetable/<?=$classe?>" class="btn btn-primary" role="button">Ajouter</a>
            </div>
        </div>
        <?php endif;?>
    </div>

<?php endif; ?>
<div class="EDT ">
    <table class="table table-bordered">
        <?php if((isset($_SESSION['user']['classe']) || isset($_SESSION['user']['roles'])) && !isset($_SESSION['admin'])):?>
        <caption>
            <h2>Emploi du temps de la semaine de <?=date('d-m-Y',strtotime($deb))?></h2>
        </caption>
        <?php endif; ?>
        <tr>
            <th>Heures de cours</th>
            <th>LUNDI</th>
            <th>MARDI</th>
            <th>MERCREDI</th>
            <th>JEUDI</th>
            <th>VENDREDI</th>
        </tr>
        <tr id="H7:30">
            <td>07h30-9h</td>
            <td class="lundi"></td>
            <td class="mardi"></td>
            <td class="mercredi"></td>
            <td class="jeudi"></td>
            <td class="vendredi"></td>
        </tr>
        <tr id="H9:0">
            <td>9h-10h30</td>
            <td class="lundi"></td>
            <td class="mardi"></td>
            <td class="mercredi"></td>
            <td class="jeudi"></td>
            <td class="vendredi"></td>
        </tr>
        <tr id="H10:30">
            <td>10h30-12h</td>
            <td class="lundi"></td>
            <td class="mardi"></td>
            <td class="mercredi"></td>
            <td class="jeudi"></td>
            <td class="vendredi"></td>
        </tr>
        <tr id="H13:30">
            <td>13h30-15h</td>
            <td class="lundi"></td>
            <td class="mardi"></td>
            <td class="mercredi"></td>
            <td class="jeudi"></td>
            <td class="vendredi"></td>
        </tr>
        <tr id="H15:0">
            <td>15h-16h30</td>
            <td class="lundi"></td>
            <td class="mardi"></td>
            <td class="mercredi"></td>
            <td class="jeudi"></td>
            <td class="vendredi"></td>
        </tr>
        <tr id="H16:30">
            <td>16h30-18h</td>
            <td class="lundi"></td>
            <td class="mardi"></td>
            <td class="mercredi"></td>
            <td class="jeudi"></td>
            <td class="vendredi"></td>
        </tr>
    </table>
    <?php if(!isset($_SESSION['admin'])): ?>
    <?php if(isset($_SESSION['user']['classe']) || isset($_SESSION['user']['roles'])):?>
    <div class="appel">
        <a id='cahier' href="/etudiant/appel/<?= $_SESSION['user']['classe'] . '/' .date('Y-m-d') ?>"><button>Cahier d'appel</button></a>
    </div>
    <?php endif;?>
    <?php endif; ?>
</div>
<script src="https://code.jquery.com/jquery-3.6.3.js"></script>


<!-- si l'utilisateur est connecté en tant que personnel -->
<?php if(strchr($_SERVER['REQUEST_URI'], 'pers')): ?>
<script>
$(document).ready(function() {
    $('#cahier').remove();
    $('.appel').append("<p>Cahier d'appel:</p><br><ul id='cahierClasse'></ul>");

    //les classes sous responsabilitées du personnel
    var classe = [];
    <?php foreach($edt as $cours): ?>
    classe.push("<?= strtoupper($cours->classe)?>");
    <?php endforeach; ?>
    console.log(classe);

    //filter les doublons dans la classe
    classe = array_unique(classe);
    for (var i = 0; i < classe.length; i++) {
        let currentDate = new Date().toJSON().slice(0, 10);
        let addBtn = "<li><a href=\"/etudiant/appel/" + classe[i] + "/" + currentDate + "\"><button>" + classe[
                i]
            .toLocaleUpperCase() + "</button></a></li>";
        $(addBtn).appendTo('#cahierClasse');
    }

    // pass an array with duplicates into the function
    // returns an array with unique values
    function array_unique(arr) {
        return [...new Set(arr)];
    }
});
</script>
<?php endif; ?>
<script>
$(document).ready(function() {
    //var semaineDe = ;
    var cours;
    var date;
    var classe;
    <?php foreach($edt as $cours): ?>
    cours = "<?php echo $cours->matiere; ?>";
    date = "<?= $cours->date ?>";
    // <!-- si l'utilisateur est connecté en tant que personnel -->
    <?php if(strchr($_SERVER['REQUEST_URI'], 'pers')): ?>
    classe = "<?= strtoupper($cours->classe)?>";
    <?php endif; ?>
    date = new Date(date);

    //alaina ny jour
    var jour = date.getUTCDay();

    //alaina ny heure
    var heure = date.getHours() + ":" + date.getMinutes();

    //apidirina anaty switch ilay jour ho atao verif
    switch (jour) {
        case 1:
            $('.lundi').each(function() {
                //alaina ny id an parent <tr>
                var id = $(this).parent().attr('id');
                //
                id = id.substr(1);

                if (heure.includes(id)) {
                    $(this).html((classe != undefined) ? cours + "<sub class='indClasse'> " + classe +
                        "</sub>" : cours);
                    return false;
                }
            })
            break;
        case 2:
            $('.mardi').each(function() {
                //alaina ny id an parent <tr>
                var id = $(this).parent().attr('id');
                //
                id = id.substr(1);
                //console.log(id);

                if (heure.includes(id)) {
                    $(this).html((classe != undefined) ? cours + "<sub class='indClasse'> " + classe +
                        "</sub>" : cours);
                    return false;
                }
            })
            break;
        case 3:
            $('.mercredi').each(function() {
                //alaina ny id an parent <tr>
                var id = $(this).parent().attr('id');
                //
                id = id.substr(1);
                //console.log(id);

                if (heure.includes(id)) {
                    $(this).html((classe != undefined) ? cours + "<sub class='indClasse'> " + classe +
                        "</sub>" : cours);
                    return false;
                }
            })
            break;
        case 4:
            $('.jeudi').each(function() {
                //alaina ny id an parent <tr>
                var id = $(this).parent().attr('id');
                //
                id = id.substr(1);
                //console.log(id);

                if (heure.includes(id)) {
                    $(this).html((classe != undefined) ? cours + "<sub class='indClasse'> " + classe +
                        "</sub>" : cours);
                    return false;
                }
            })
            break;
        case 5:
            $('.vendredi').each(function() {
                //alaina ny id an parent <tr>
                var id = $(this).parent().attr('id');
                //
                id = id.substr(1);
                //console.log(id);

                if (heure.includes(id)) {
                    $(this).html((classe != undefined) ? cours + "<sub class='indClasse'> " + classe +
                        "</sub>" : cours);
                    return false;
                }
            })
            break;

        default:
            break;
    }
    <?php endforeach; ?>

    //on ajoute du css aux indices classes
    $('.indClasse').css({
        'transform': 'translateX(50%)',
        'color': 'red',
        'margin-bottom': '0px'
    });
    $('td').css('text-align', 'center');

    //alaina ny classe active
    var classe = "<?php $tabUrl = explode('/',$_SERVER['REQUEST_URI']); echo $tabUrl[count($tabUrl)-1];  ?>";
    $('#' + classe + '').addClass('active');


    //cilck sur btnSearch et on change de page
    $('#btnSearch').on('click', function(){
        //on récupere la date saisi dans la bar de recherche
        var dateSearch = $('#searchDate').val();

        //raha tsy vide le date de manao recherche
        if(dateSearch) window.location.href = "/etudiant/afficheEdt/"+dateSearch+"/"+classe;
        else{
            alert('Veuillez entrez la date à rechercher');
            $('#searchDate').focus();
        }
    })

});
</script>