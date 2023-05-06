<h3>Cahier d'appel <?= strtoupper($classe); ?> du <?=date('d-m-Y', strtotime($date))?></h3><br>
<div>
    <table class="table table-sm table-striped">

        <tr>
            <th>Nom:</th>
            <th>Prénom(s):</th>
            <th>Absence:</th>
        </tr>

        <?php foreach($etudiants as $etudiant): ?>
        <tr>
            <td><?= $etudiant->nom ?></td>
            <td><?= $etudiant->prenom ?></td>
            <td class="td-check">
                <?php if($etudiant->absence == 'n'){?>
                        <input type="checkbox" id="switch/<?= $etudiant->id ?>" /><label for="switch/<?= $etudiant->id ?>">Toggle</label>
                <?php }else{?>
                        <input type="checkbox" id="switch/<?= $etudiant->id ?>" checked /><label for="switch/<?= $etudiant->id ?>">Toggle</label>
                <?php }?>
            </td>
        </tr>
        <?php endforeach; ?>
        

    </table>

    <button class="btn btn-outline-primary" id="btnSave">Enregistrer</button>

    <form action="#" method="post" style="display:none">
        <input type="text" value="" id="absents" name="absents">
        <input type="submit" id="submit">
    </form>
    
</div>
<script src="https://code.jquery.com/jquery-3.6.3.js"></script>
<script>
   
    $(document).ready(function() {
        $('#btnSave').click(function(){
            var absents = [];
            $('input[type=checkbox]').each(function(){
                if($(this).prop('checked')) {
                    //alaina ny id anze absent 
                    // otrzao le ao switch/${id}
                    let id = $(this).attr('id');
                    id = id.split('/');
                    id = id[1];
                    absents.push(id);
                }
            });
            //console.log(absents);return;

            //atambatra ho string mielanelana , ny tab id
            absents = absents.join(',');
            //console.log(absents);return;
            
            //alefa ao amle val anle form
            $('#absents').val(absents);

            //console.log($('#absents').val());return;

            //alefa any am post amzay
            $('#submit').click();
        })
        
    });
</script>