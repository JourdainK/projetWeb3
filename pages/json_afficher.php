<div class="container-fluid pt-5">
    <div class="row mx-auto pt-5">
        <div class="col-lg-4 mx-auto p-2">
            <form class="form-group" action="<?php print $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                <h3><u>Recherche de produit</u></h3>
                <div class="mb-3">
                    <label for="formMarque" class="form-label"><b>Marque : </b></label>
                    <input name="marque" type="text" class="form-control" id="formMarque" aria-describedby="marHelp">
                    <div id="marHelp" class="form-text">Entrer la marque recherchée</div>
                </div>
                <p><b>Ou</b></p>
                <div class="mb-3">
                    <label for="formType" class="form-label"><b>Type : </b></label>
                    <input name="type" type="text" class="form-control" id="formMarque" aria-describedby="typHelp">
                    <div id="typHelp" class="form-text">Entrer la type de produit recherché (Croquettes, Pâté ou Bâtonnets)</div>
                </div>
                <button name ="submit_json" type="submit" class="btn btn-primary">Rechercher</button>
                <button type="reset" class="btn btn-secondary">Effacer</button>
            </form>
        </div>
        <div class="col-lg-6">
            <div class="row mx-auto p-2">
                <img class="img-fluid rounded float-start" src="../images/felix.png" style="width: 30%"/>
                <img src="../images/gourmet.png" style="width: 30%"/>
                <img src="../images/pedigree.png" style="width: 30%"/>
            </div>
            <div class="row">
                <img src="../images/purinaBrd.png" style="width: 30%"/>
                <img src="../images/roycan.png" style="width: 30%"/>
                <img src="../images/vitakraft.png" style="width: 30%"/>
            </div>
        </div>

    </div>

<?php
// https://www.taniarascia.com/how-to-use-json-data-with-php-or-javascript/
print '<br><br><br><br>';
$jsonurl = './lib/JSON/marques.json';
$jsonbrand = file_get_contents($jsonurl);
$marques = json_decode($jsonbrand);
print '<div class="row">';
if(isset($_POST['submit_json'])){
    extract($_POST, EXTR_OVERWRITE);
    foreach ($marques as $prod){
        if(strtoupper($prod->marque) == strtoupper($marque)){
            print '<div class="col-lg-4">';
            print '<div class="card mx-auto m-3 bg-info" style="width: 18rem;">
                      <div class="card-header mx-auto">
                        <b>Produit</b>
                      </div>
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item"><b>Marque : </b>'.$prod->marque;
            print '</li>
                        <li class="list-group-item"><b>Type : </b>'.$prod->type.'</li>
                        <li class="list-group-item"><b>Poids : </b>'.$prod->poids.'</li>
                        <li class="list-group-item"><b>Goût : </b>'.$prod->gout.'</li>
                        <li class="list-group-item"><b>Prix : </b>'.$prod->prix.' €</li>
                      </ul>
                    </div></div>';
        }
        if(empty($marque) && strtoupper($prod->type) == strtoupper($type)){
            print '<div class="col-lg-4">';
            print '<div class="card mx-auto m-3 bg-info" style="width: 18rem;">
                      <div class="card-header mx-auto">
                        <b>Produit</b>
                      </div>
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item"><b>Marque : </b>'.$prod->marque;
            print '</li>
                        <li class="list-group-item"><b>Type : </b>'.$prod->type.'</li>
                        <li class="list-group-item"><b>Poids : </b>'.$prod->poids.'</li>
                        <li class="list-group-item"><b>Goût : </b>'.$prod->gout.'</li>
                        <li class="list-group-item"><b>Prix : </b>'.$prod->prix.' €</li>
                      </ul>
                    </div></div>';
        }
    }

}



print '</div></div>';

?>

    </div>
</div>