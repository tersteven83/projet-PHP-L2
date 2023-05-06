<div class="about">
    <h1>A propos</h1>
</div>
<main>
    <div class="main">
        <p>Nom : <?= $content->nom ?><br></p>
        <p>Prénom : <?= $content->prenom ?><br></p>
        <p>Date de naissance : <?php $date = date_create($content->ddn); echo date_format($date, 'd/m/Y');  ?><br></p>
        <?php if (strchr($_SERVER['REQUEST_URI'], 'etudiant')):?>  
            <p>Classe : <?= strtoupper($content->id_classe) ?><br></p>
        <?php endif; ?>
        <p>Adresse : <?= $content->adresse ?><br></p>
        <p>E-mail : <?= $content->email ?><br></p>
        <p> Numéro de téléphone : <?= $content->tel ?><br></p>
    </div>
</main>