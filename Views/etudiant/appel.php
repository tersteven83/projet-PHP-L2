<h3>Cahier d'appel <?= strtoupper($classe); ?> du <?= date('d-m-Y', strtotime($date))?></h3><br>
<div>
    <table id="maTable">

        <tr>
            <th>Nom:</th>
            <th>Prénom(s):</th>
            <?php if($isStudent){?>
                <th>Présence:</th>
            <?php } else{ ?>
                <th>Absent(e)s</th>
            <?php } ?>
        </tr>

        <?php foreach($etudiants as $etudiant): ?>
        <tr>
            <td><?= $etudiant->nom ?></td>
            <td><?= $etudiant->prenom ?></td>
            <td>
                <?php if($etudiant->absence == 'n'){?>
                    <?php if(!$isStudent){?>
                        <input type="checkbox" id="switch/<?= $etudiant->id ?>" /><label for="switch/<?= $etudiant->id ?>">Toggle</label>
                    <?php }?>
                <?php }else{?>
                    <?php if(!$isStudent){?>
                        <input type="checkbox" id="switch/<?= $etudiant->id ?>" checked disabled /><label for="switch/<?= $etudiant->id ?>">Toggle</label>
                    <?php }else{?>
                        <span style="font-weight: 700; color:red; font-size:20px;padding-left:15%;">A</span>
                    <?php } ?>
                <?php }?>
            </td>
        </tr>
        <?php endforeach; ?>
        

    </table>

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