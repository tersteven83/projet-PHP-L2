<div class="d-flex justify-content-center align-items-center vh-100">
    <form method="POST" action="#" class="shadow w-450 p-3">
        <h4 class="display-4  fs-1"> Ajouter une matière</h4>
        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['success']; unset($_SESSION['success']);?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="nom" class="form-label"> Nom de la matière </label>
            <input type="text" name="nom" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="resp" class="form-label">Responsable: <a href="/pers/ajouter"><img style="width:15px;cursor:pointer;" src="../../img/icons8-add-67.png"  alt="icon" ></a> </label>
            <select name="resp" id="resp" class="form-control">
                <?php $tabResp = []; foreach($personnels as $personnel):?>
                <!-- <option value="rakoto/{son id}">RAKOTO</option> -->
                <option value="<?=strtolower($personnel->nom).'/'.$personnel->id?>"><?=$personnel->nom?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="newPass" class="form-label"> Classe de: </label>
            <select name="classe" class="form-control" id="classe">
                <option value="l1">L1</option>
                <option value="l2">L2</option>
                <option value="l3">L3</option>
                <option value="m1">M1</option>
                <option value="m2">M2</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary"> Enregistrer</button>
    </form>
</div>