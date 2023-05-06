
<div class="container">
    <h3>Les Matières en <?= ucfirst(substr($_SERVER['REQUEST_URI'], -2));?><a href="/matiere/ajouter" class="btn btn-outline-dark" style="float:right;">Ajouter</a></h3>
    <table class="table">
        <tr>
            <th>Matieres</th>
            <th>Responsable</th>
            <th>Action</th>
        </tr>
        <!-- mameno tableau matiere -->
        <?php foreach($matieres as $matiere):?>
            <tr>
                <td class="nom"><?=$matiere->nom?></td>
                <td class="resp"><?=$matiere->resp?></td>
                <td>
                    <button class="btnModif<?=$matiere->id_classe.'/'.$matiere->id?>">Modifier</button>
                    <button class="btn btn-danger"><a href="/matiere/supprimer/<?=$matiere->id?>" >Supprimer</a></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<style>
    * {
    box-sizing: border-box;
    }

    .modifPopup {
        position: relative;
        /* text-align: center; */
        width: 100%;
    }
    .formPopup {
        display: none;
        position: fixed;
        left: 50%;
        top: 10%;
        transform: translate(-50%, 5%);
        border: 3px solid #999999;
        z-index: 9;
    }
    .formContainer {
        max-width: 300px;
        padding: 20px;
        background-color: #fff;
    }
    .formContainer input[type=text],
    .formContainer select {
        width: 100%;
        padding: 15px;
        margin: 5px 0 20px 0;
        border: none;
        background: #eee;
    }
    .formContainer input[type=text]:focus,
    .formContainer select:focus {
        background-color: #ddd;
        outline: none;
    }
    .formContainer .btn {
        padding: 12px 10px;
        margin: 10px;
        border: none;
        color: #fff;
        cursor: pointer;
        width: 40%;
        margin-bottom: 15px;
        opacity: 0.8;
        border-radius: 5px;
    }
    .formContainer .confirm {
        background-color: #8ebf42;
        float: right;
    }
    .formContainer .cancel {
        background-color: #cc0000;
        float: left;
        text-align: center;
    }
    .formContainer .btn:hover,
    .openButton:hover {
    opacity: 1;
    }
    #icon-image{
        width: 15px;
        transform: translateY(3px);
        cursor: pointer;
    }
    button[class*=btnModif]{
        color: #212529;
        background-color: #ffc107;
        border-color: #ffc107;
        display: inline-block;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border: 1px solid transparent;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.25rem;
        transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        transition-duration: 0.15s, 0.15s, 0.15s, 0.15s;
        transition-timing-function: ease-in-out, ease-in-out, ease-in-out, ease-in-out;
        transition-delay: 0s, 0s, 0s, 0s;
        transition-property: color, background-color, border-color, box-shadow;

    }
</style>
    

<div class="modifPopup">
    <div class="formPopup" id="popupForm">
        <form method="post" class="formContainer">
            <h2 style="text-align:center;">Modifier</h2><br><br>
            <label for="nom">
                <strong>Matière:</strong>
            </label>
            <input type="text" id="nomMatiere" name="nomMatiere" required>
            <label for="resp">
                <strong>Responsable: <a href="/pers/ajouter"><img src="../../img/icons8-add-67.png" alt="icon" id="icon-image"></a> </strong>
            </label>
            <select name="resp" id="resp">
                <?php $tabResp = []; foreach($matieres as $matiere):?>
                    <!-- Raha efa miexiste le anaran le mpampianatra de tsy apidirina anaty option tsony -->
                    <?php 
                        if(in_array($matiere->resp, $tabResp)) continue;
                        $tabResp[] = $matiere->resp;
                    ?>
                    <!-- <option value="rakoto/{son id}">RAKOTO</option> -->
                    <option value="<?=strtolower($matiere->resp).'/'.$matiere->id_resp?>"><?=$matiere->resp?></option>
                <?php endforeach; ?>
            </select>
            
            <div class="">
                <span id="btnSave" class="btn confirm">Enregistrer</span>
                <span type="button" class="btn cancel" id="btnClose">Annuler</span>
            </div>
            
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.3.js"></script>
<script src="../../JS/matiere/modifier.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>