<div class="container d-flex justify-content-left mt-5">
    <div class="border rounded col-lg-5 bg-light p-5 m-5">
        <h1 class="text-center">Frais de déplacement</h1>

        <form class="mt-5" method="POST" name="Forfais">
            <label for="type_frais">Sélectionner un frais</label>
            <select class="form-select" name="type_frais">
                <option value="ETP">Forfait étape</option>
                <option value="KM">Frais kilométrique</option>
                <option value="NUI">Nuité</option>
                <option value="REP">Repas</option>
            </select>

            <label for="value_price">Valeur</label>
            <input class="form-control" type="number" name="value_price" id="value_price">

            <?=$data_sanitizer->generate_csrf_input()?>


            <button class="mt-2 btn btn-dark">Envoyer</button>
        </form>
    </div>

    <div class="border rounded col-lg-5 bg-light p-5 m-5">
        <h1 class="text-center">Remboursement du mois en cours :</h1>
        <p>Étape : <?=$historique[0]->quantite?> €</p>
        <p>Frais kilométrique : <?=$historique[1]->quantite?> €</p>
        <p>Nuité : <?=$historique[2]->quantite?> €</p>
        <p>Repas : <?=$historique[3]->quantite?> €</p>
        <p>Hors Forfais : <?=$totalHf?> €</p>

        <p><strong>Total : <?=$total?> €</strong></p>

    </div>
</div>
<div class="container d-flex justify-content-left">
    <div class="border rounded col-lg-5 bg-light p-5 m-5">
        <h1 class="text-center">Frais de déplacement Hors Forfait</h1>

        <form class="mt-5" method="POST">
            <label for="name_libelle">Nom du frais</label>
            <input class="form-control" type="text" name="name_libelle" id="name_libelle">

            <label for="value_price">Valeur</label>
            <input class="form-control" type="number" name="value_priceHF" id="value_price">

            <?=$data_sanitizer->generate_csrf_input()?>

            <button class="mt-2 btn btn-dark">Envoyer</button>
        </form>
    </div>
</div>

