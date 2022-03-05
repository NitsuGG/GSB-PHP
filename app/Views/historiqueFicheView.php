    <?php if($result):?>
    <form action="" method="POST">
        <select class="form-select" name="selectMonth" id="selectMonth" onchange="this.form.submit()">
            <option value="<?=$result[0]->mois?>">Séléctionner un mois</option>
            <?php foreach($result as $key => $value):?>
            <option value="<?=$result[$key]->mois?>"><?=$result[$key]->mois?></option>
            <?php endforeach;?>
        </select>
    </form>
    <?php else:?>
    <select class="form-select">
        <option value="0">Aucune fiche disponnible</option>
    </select>
    <?php endif; ?>
    </div>

    <?php if($_POST):?>
    <div class="container d-flex justify-content-center mt-5">
        <h1 class="text-light">Fiche <?=$_POST["selectMonth"]?></h1>
    </div>

    <div class="container d-flex justify-content-left mt-5">
        <div class="border rounded col-lg-5 bg-light p-5 m-5">

            <h4>Frais Forfait :</h4>
            <ul>
                <li>Frais étape : <?=$fraisForfais[0]?> pour un total de <?=$fraisForfais[1]?>€</li>
                <li>Frais kilométrique : <?=$fraisForfais[2]?> pour un total de <?=$fraisForfais[3]?>€</li>
                <li>Frais nuitée à l'hotel : <?=$fraisForfais[4]?> pour un total de <?=$fraisForfais[5]?>€</li>
                <li>Frais repas : <?=$fraisForfais[6]?> pour un total de <?=$fraisForfais[7]?>€</li>
            </ul>
        </div>

        <div class="border rounded col-lg-5 bg-light p-5 m-5">

            <h4>Liste des Frais Hors Forfait :</h4>
            <ul>
                <?php foreach($ligneHF as $key =>$value): ?>
                <li><?=$value->libelle?> pour <?=$value->montant?>€ </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php endif; ?>