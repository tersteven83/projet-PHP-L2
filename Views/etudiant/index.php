<nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top">
    <ul class="navbar-nav row">
        <li class="nav-item col-1">
            <a href="/etudiant/index/l1" id="l1" class="nav-link">L1</a>
        </li>
        <li class="nav-item col-1">
            <a href="/etudiant/index/l2" id="l2" class="nav-link">L2</a>
        </li>
        <li class="nav-item col-1">
            <a href="/etudiant/index/l3" id="l3" class="nav-link">L3</a>
        </li>
        <li class="nav-item col-1">
            <a href="/etudiant/index/m1" id='m1' class="nav-link">M1</a>
        </li>
        <li class="nav-item col-1">
            <a href="/etudiant/index/m2" id="m2" class="nav-link">M2</a>
        </li>
        <li class="nav-item col" style="transform: translateX(120%);">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">@</span>
                </div>
                <input type="text" class="form-control" placeholder="Recherche pour un nom" id="myInput">
            </div>
        </li>

    </ul>
</nav>
<div class="row">
    <div class="col">
        <h3>Liste des étudiants en <?= strtoupper($classe) ?></h3>
    </div>
    <div class="col-1 ">
        <a role="button" href="/etudiant/ajouter" class="btn btn-info">Ajouter</a>
    </div>
</div>

<table class="table table-striped table-sm" id="myTable">
    <thead>
        <tr>
            <th>N* matricule</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Présence</th>
            <th>Action:</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($etudiants as $etudiant): ?>
        <tr>
            <td><?= $etudiant->id ?></td>
            <td><?= $etudiant->nom ?></td>
            <td><?= $etudiant->prenom ?></td>
            <td><?= $etudiant->email ?></td>
            <td style="color: red; font-weight:800; padding-left:30px;"><?php if($etudiant->absence == 'o') echo 'A';  ?>
            </td>
            <td><a href="/etudiant/modifier/<?=$etudiant->id?>" class="btn btn-warning btn-sm" role="button">Modifier</a><a href="/etudiant/supprimer/<?=$etudiant->id?>" class="btn btn-danger btn-sm" role="button">Supprimer</a></td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
<script src="https://code.jquery.com/jquery-3.6.3.js"></script>
<!-- js pour la modificcation -->
<script src="../../../JS/etudiant/modifier.js"></script>
<script>
$(document).ready(function() {
    $('#myInput').keyup(myFunction);

    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
    //alaina ny classe active
    var classe = "<?php $tabUrl = explode('/',$_SERVER['REQUEST_URI']); echo $tabUrl[count($tabUrl)-1];  ?>";
    $('#' + classe + '').addClass('active');
})
</script>