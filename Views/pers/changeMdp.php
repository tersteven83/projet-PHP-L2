<div class="mdp">
    <form method="POST" action="#" class="shadow w-450 p-3">
    <?php if(!empty($_SESSION['erreur'])):?>
            <div class="alert-danger" role="alert">
                <?php echo $_SESSION['erreur']; unset($_SESSION['erreur']); ?>
            </div>
        <?php endif ?> 
        <h4 class="display-4  fs-1"> Changer le mot de passe</h4>
        
        <div class="mb-3"> 
            <p><label for="antPass" class="form-label"> Ancien mot de passe: </label></p>
            <p><input type="password" name="antPass" class="form-control" required=""> </p>
        </div>
        <div class="mb-3"> 
            <p><label for="newPass" class="form-label"> Nouveau mot de passe: </label></p>
            <p><input type="password" name="newPass" class="form-control" required=""> </p>
        </div>
        <div class="mb-3"> 
            <p><label for="newPass" class="form-label"> Confirmer le mot de passe: </label></p>
            <p><input type="password" name="newPassCon" class="form-control" required=""> </p>
        </div>
        <button type="submit" class="btn btn-primary"> Enregistrer</button>
    </form>
</div>

<!-- <div class="mdp">
    
    <article>
        <h4>MOT DE PASSE</h4>
        <?php if(!empty($_SESSION['erreur'])):?>
            <div class="alert-danger" role="alert">
                <?php echo $_SESSION['erreur']; unset($_SESSION['erreur']); ?>
            </div>
        <?php endif ?>  
        <form action="#" method="post">
            <label for="antPass">Mot de passe actuel</label>
            <input type="password" name="antPass:" id="mdp"><br>
            <label for="newPass">Nouveau mot de passe:</label>
            <input type="password" name="newPass" id="newmdp"><br>
            <label for="newPassCon">Confirmer votre nouveau mot de passe:</label>
            <input type="password" name="newPassCon" id="newmdp"><br>
            <input type="submit" value="Terminer"  class="Terminer">
        </form>
        
    </article>  
</div> -->