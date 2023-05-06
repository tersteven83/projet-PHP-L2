<div class="d-flex justify-content-center align-items-center vh-100">
    <form method="POST" action="#" class="shadow w-450 p-3">
        <h4 class="display-4  fs-1"> Se connecter</h4>
        <?php if(!empty($_SESSION['info'])):?>
            <div class="alert alert-info" role="alert">
				<?php echo $_SESSION['info']; unset($_SESSION['info']); ?>
			</div>
        <?php endif ?>
        <?php if(!empty($_SESSION['erreur'])):?>
            <div class="alert alert-danger" role="alert">
				<?php echo $_SESSION['erreur']; unset($_SESSION['erreur']); ?>
			</div>
        <?php endif ?>
        <div class="mb-3"> <label for="email" class="form-label"> E-mail </label><input type="email" name="email"
                class="form-control" required=""> </div>
        <div class="mb-3"> <label for="pass" class="form-label"> Password </label><input type="password" name="pass"
                class="form-control" required=""> </div>
        <a style="font-size: smaller;" href="/pers/login">Se connecter en tant que personnel</a><br>
        <button type="submit" class="btn btn-primary"> Connecter
        </button>
    </form>
</div>