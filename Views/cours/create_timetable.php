<!-- <form action="#"> -->
<div class="container">
    <h2><?=$classe?></h2>
    <!-- esorina ilay date raha hanao modification -->
    <?php if(!strchr($_SERVER['REQUEST_URI'], 'modifier')): ?>
        <div class="date">
            <label for="debutDate">Emploi du temps du</label>
            <input type="date" id="debutDate" name="debutDate" value="">
            <a style="float:right;" href="/matiere/index/<?=$classe?>" role="button" class="btn btn-outline-dark">Modifier les matières</a>
        </div>
    <?php endif; ?>

    <table class="table table-bordered">
        <tr>
            <th></th>
            <th class="lundi">lundi</th>
            <th class="mardi">mardi</th>
            <th class="mercredi">mercredi</th>
            <th class="jeudi">jeudi</th>
            <th class="vendredi">vendredi</th>
        </tr>
        <!-- première heure -->
        <tr id="H7:30">
            <td>7h30-9h</td>
        </tr>
        <tr id="H9:0"">
            <td>9h-10h30</td>
        </tr>
        <tr id="H10:30">
            <td>10h30-12h</td>
        </tr>
        <tr id="H13:30">
            <td>13h30-15h</td>
        </tr>
        <tr id="H15:0">
            <td>15h-16h30</td>
        </tr>
        <tr id="H16:30">
            <td>16h-18h</td>
        </tr>
    </table>
    <!-- <input type="button" id="btn" name="btn" value="enregistrer"> -->
    <div class="enregistrer ">
        <button class="btn btn-outline-primary" id="btn">Enregistrer</button>
    </div>

    <!-- </form> -->

    <form id="form" method="post" action="#" style="display: none;">
        <input type="text" name="semaineDe" id="semaineDe" value="">
        <input type="text" name="matieres" id="matieres" value="<?=$matieres?>">
        <input type="submit" id="submit">
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.3.js"></script>
<script src="../../../JS/create_timetable.js"></script>
<!-- <script src="http://tests.yazz/bazouka/js/create_timetable.js"></script> -->


<!-- Modification de l'emploi du temps -->
<script>
    $(document).ready(function() {
        //var semaineDe = ;
        var cours;
        var date;

        <?php if(isset($edt)): ?>
            <?php foreach($edt as $cours): ?>
                cours = "<?php echo $cours->matiere; ?>".toLowerCase();
                date = "<?= $cours->date ?>";
                date = new Date(date);
                //console.log(cours + " " + date);

                //alaina ny jour
                var jour = date.getUTCDay();

                //alaina ny heure
                var heure = date.getHours() + ":" + date.getMinutes();

                //console.log(cours + " " + heure + " " +jour);

                //apidirina anaty switch ilay jour ho atao verif
                switch (jour) {
                    case 1:
                        $('.lundi').each(function() {
                            //alaina ny id an parent <tr>
                            var id = $(this).parent().attr('id');
                            //
                            if(id != undefined)id = id.substr(1);

                            if (heure.includes(id)) {
                                $(this).children().val(cours);
                                return false;
                            }
                        })
                        break;
                    case 2:
                        $('.mardi').each(function() {
                            //alaina ny id an parent <tr>
                            var id = $(this).parent().attr('id');
                            //
                            if(id != undefined)id = id.substr(1);
                            //console.log(id);

                            if (heure.includes(id)) {
                                $(this).children().val(cours);
                                return false;
                            }
                        })
                        break;
                    case 3:
                        $('.mercredi').each(function() {
                            //alaina ny id an parent <tr>
                            var id = $(this).parent().attr('id');
                            //
                            if(id != undefined)id = id.substr(1);
                            //console.log(id);

                            if (heure.includes(id)) {
                                $(this).children().val(cours);
                                return false;
                            }
                        })
                        break;
                    case 4:
                        $('.jeudi').each(function() {
                            //console.log("coucou");
                            //alaina ny id an parent <tr>
                            var id = $(this).parent().attr('id');
                            //
                            if(id != undefined)id = id.substr(1);
                            

                            if (heure.includes(id)) {
                                //console.log(id);
                                $(this).children().val(cours);
                                return false;
                            }
                        })
                        break;
                    case 5:
                        $('.vendredi').each(function() {
                            //alaina ny id an parent <tr>
                            var id = $(this).parent().attr('id');
                            //
                            if(id != undefined)id = id.substr(1);
                            //console.log(id);

                            if (heure.includes(id)) {
                                $(this).children().val(cours);
                                return false;
                            }
                        })
                        break;

                    default:
                        break;
                }
            <?php endforeach; ?>
        <?php endif; ?>
    });
</script>