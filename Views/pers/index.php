<!-- <h3>Liste des  <?= strtoupper($classe) ?></h3> -->
<div class="input-group">
  <div class="input-group-prepend">
      <span class="input-group-text">@</span>
  </div>
  <input type="text" class="form-control" placeholder="Recherche pour un nom" id="myInput">
  <a role="button" href="/pers/ajouter" class="btn btn-outline-info">Ajouter</a>
</div>

<table id="myTable" class="table table-striped table-sm">
    <thead>
      <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email</th>
        <th>Tel</th>
        <th>CIN</th>
        <th>Action:</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($personnels as $personnel): ?>
        <tr>
            <td><?= $personnel->nom ?></td>
            <td><?= $personnel->prenom ?></td>
            <td><?= $personnel->email ?></td>
            <td><?= $personnel->tel ?></td>
            <td><?= $personnel->cin ?></td>
            <td>
              <a href="/pers/modifier/<?=$personnel->id?>" class="btn btn-warning btn-sm" role="button">Modifier</a>
              <a href="/pers/supprimer/<?=$personnel->id?>" class="btn btn-danger btn-sm" role="button">Supprimer</a>
              <a href="/pers/afficheEdt/<?=date('Y-m-d')?>/<?=$personnel->id?>" class="btn btn-info btn-sm" role="button">Edt</a>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
  </table>
</div>
<script src="https://code.jquery.com/jquery-3.6.3.js"></script>
<script>
  $(document).ready(function() {
    $('#myInput').keyup(myFunction);
    function myFunction() {
      // alert("coucou");
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[0];
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
  });
</script>