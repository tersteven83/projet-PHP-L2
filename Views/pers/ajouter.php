<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-12 col-lg-9 col-xl-7">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Ajouter un personnel</h3>
                        <?php if(isset($_SESSION['success'])): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $_SESSION['success']; unset($_SESSION['success']);?>
                        </div>
                        <?php endif; ?>
                        <form method="post" action="#">

                            <div class="row">
                                <div class="col-md-6 mb-4">

                                    <label class="form-label" for="nom">Nom</label>
                                    <input type="text" id="nom" name="nom" class="form-control form-control-lg"
                                        required />

                                </div>
                                <div class="col-md-6 mb-4">

                                    <label class="form-label" for="prenom">Prénoms</label>
                                    <input type="text" id="prenom" name="prenom" class="form-control form-control-lg" />

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4 d-flex align-items-center">

                                    <div class="datepicker w-100">
                                        <label for="ddn" class="form-label">Date de naissance</label>
                                        <input type="date" class="form-control form-control-lg" id="ddn" name="ddn"/>

                                    </div>

                                </div>
                                <div class="col-md-6 mb-4">

                                    <h6 class="mb-2 pb-1">Sexe: </h6>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="sexe" id="femelle" value="F"
                                            checked />
                                        <label class="form-check-label" for="femelle">Femelle</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="sexe" id="male" value="M" />
                                        <label class="form-check-label" for="male">Male</label>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4 pb-2">

                                    <label class="form-label" for="email">Adress E-mail</label>
                                    <input type="email" id="email" class="form-control form-control-lg" name="email" />



                                </div>
                                <div class="col-md-6 mb-4 pb-2">

                                    <label class="form-label" for="tel">Numéro téléphone</label>
                                    <input type="tel" id="tel" class="form-control form-control-lg" name="tel" />


                                </div>
                            </div>
                            <!-- ty nataoko -->
                            <div class="row">
                                <div class="col-md-6 mb-4 pb-2">

                                    <label class="form-label" for="cin">CIN</label>
                                    <input type="text" id="cin" class="form-control form-control-lg" name="cin" />



                                </div>
                                <div class="col-md-6 mb-4 pb-2">

                                    <label class="form-label" for="adresse">Adresse</label>
                                    <input type="text" id="adresse" class="form-control form-control-lg"
                                        name="adresse" />

                                </div>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="roles"
                                    value="ROLE_USER,ROLE_ADMIN" id="role">
                                <label class="form-check-label" for="role">
                                    Admin
                                </label>
                            </div>


                            <div class="mt-4 pt-2">
                                <input class="btn btn-primary btn-lg" type="submit" value="Enregistrer" />
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>