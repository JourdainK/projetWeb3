<div class="container-fluid">
    <div class="row d-flex justify-content-center pt-3">
        <?php
        print '<div class="row pt-5">';

        $service = [
            'Coupons de vos marques préférées',
            'Adoptions des refuges de votre pays',
            'Compétitions canines',
            'Compétitions félines',
            'Concours'
        ];

        $contact = [
            'Email',
            'Téléphone',
            'Courrier (LaPoste)'
        ];

        if (isset($_POST['submit_form'])) {
            extract($_POST, EXTR_OVERWRITE);
            
            if (!empty($login) && !empty($pwd) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                /* https://www.w3schools.com/php/php_file_upload.asp */
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["file"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                if (isset($_POST["file"])) {
                    $check = getimagesize($_FILES["file"]["tmp_name"]);
                    print 'echo echo echo test est file';

                    if ($check !== false) {
                        echo "Le fichier est une image : " . $check["mime"] . ".";
                        $uploadOk = 1;
                    } else {
                        echo "Erreur : le fichier n'est pas une image.";
                        $uploadOk = 0;
                    }

                }
                if (!empty($imageFileType)) {
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                        echo "<br>Désolé, seuls les formats JPG, JPEG, PNG et GIF sont autorisés.";
                        $uploadOk = 0;
                    }

                    if (file_exists($target_file)) {
                        echo "<br>Désolé, le fichier a déjà été chargé.";
                        $uploadOk = 0;
                    }
                }


                if ($uploadOk == 0) {
                    echo "<br>Erreur lors du chargement du fichier.";
                } else {
                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                        echo '<p class="text-center mx-auto">Le fichier : ' . htmlspecialchars(basename($_FILES["file"]["name"])) . ' a été chargé correctement.</p>';
                        print '<br><p class="text-center mx-auto">Fichier uploadé : <br><img class="mx-auto" style="width: 20%;" src="uploads/' . htmlspecialchars(basename($_FILES["file"]["name"])) . '"></p>';
                    } else {
                        echo "<br>Pas de fichier chargé par l'utilisateur.";
                    }

                }

                $dom = new DOMDocument('1.0', 'utf-8');
                if (file_exists('./lib/XML/members.xml')) {
                    $dom->load('./lib/XML/members.xml');
                    $members = $dom->documentElement;
                } else {
                    $members = $dom->createElement('members');
                }

                $dom->preserveWhiteSpace = false;
                $dom->formatOutput = true;

                $member = $dom ->createElement('member');
                $members->appendChild($member);
                $log = $dom->createElement('login',$_POST['login']);
                $member->appendChild($log);
                $pass = $dom->createElement('password',$_POST['pwd']);
                $member->appendChild($pass);
                $mail = $dom->createElement('email',$_POST['email']);
                $member->appendChild($mail);

                if(!empty($_POST['age'])){
                    $agepost = $dom -> createElement('age',$_POST['age']);
                    $member -> appendChild($agepost);
                }

                if(!empty($_POST['address'])){
                    $adres = $dom -> createElement('adresse',$_POST['address']);
                    $member -> appendChild($adres);
                }

                if(!empty($_POST['country'])){
                    $pays = $dom -> createElement('pays',$_POST['country']);
                    $member -> appendChild($pays);
                }

                if(!empty($_POST['telephone'])){
                    $tel = $dom -> createElement('telephone',$_POST['telephone']);
                    $member -> appendChild($tel);
                }

                if(!empty($cat) || !empty($dog) || !empty($otherpet) || !empty($nopet)){
                    $animx = $dom ->createElement('animaux');
                    $member -> appendChild($animx);

                    if(!empty($cat)){
                        $anim = $dom -> createElement('animal',$_POST['cat']);
                        $animx -> appendChild($anim);
                    }
                    if(!empty($dog)){
                        $anim = $dom -> createElement('animal',$_POST['dog']);
                        $animx -> appendChild($anim);
                    }
                    if(!empty($otherpet)){
                        $anim = $dom -> createElement('animal',$_POST['otherpet']);
                        $animx -> appendChild($anim);
                    }

                }

                if(!empty($brands)){
                    $bds = $dom -> createElement('marques');
                    $member -> appendChild($bds);
                    foreach ($_POST["brands"] as $brand){
                        $brd = $dom -> createElement('marque',$brand);
                        $bds -> appendChild($brd);
                    }
                }

                if(!empty($comment)){
                    $comt = $dom -> createElement('commentaire',$_POST['comment']);
                    $member -> appendChild($comt);
                }

                if($uploadOk==1 && $target_file !='uploads/'){
                    $picture = $dom -> createElement('photo',$target_file);
                    $member -> appendChild($picture);
                }

                if(!empty($cont)){
                    $contact = $dom -> createElement('contact',$cont);
                    $member -> appendChild($contact);
                }

                if(!empty($_POST['service'])){
                    $svcs = $dom -> createElement('services');
                    $member -> appendChild($svcs);
                    foreach ($_POST["service"] as $sv){
                        $serv = $dom -> createElement('service',$sv);
                        $svcs -> appendChild($serv);
                    }
                }

                if(!empty($_POST['newslet'])){
                    $letter = $dom -> createElement('newsletter',$newslet);
                    $member -> appendChild($letter);
                }

                $dom->appendChild($members);
                if($dom->schemaValidate('./lib/XML/members.xsd')) {
                    $dom->save('./lib/XML/members.xml');
                    print '<p class="text-center text-success bg-light mx-auto px-4" style="width: 30%">Données validées</p>';
                }
                else{
                    print '<p class="text-center text-alert bg-light mx-auto px-4" style="width: 30%">Données invalides</p>';
                }




            }
        }
        print '</div>';
        ?>

        <div class="col-lg-6 mx-auto px-5">

            <form class="form-group" action="<?php print $_SERVER['PHP_SELF']; ?>" method="POST"
                  enctype="multipart/form-data">
                <legend><br>Vos informations :</legend>

                <div class="row">
                    <div class="col-md-6">
                        <label for="login">*Login : </label>
                        <input name="login" class="form-control" type="text" placeholder="Entrez votre login">
                        <?php
                        if (isset($_POST['submit_form'])) {
                            if (empty($login)) {
                                print '<p class="text-danger bg-light rounded p-1">Veuillez entrer le login.</p>';
                            }
                        }
                        ?>
                    </div>

                    <div class="col-md-6">
                        <label for="pwd">*Password : </label>
                        <input name="pwd" class="form-control" type="password" placeholder="Entrez votre mot de passe">
                        <?php
                        if (isset($_POST['submit_form'])) {
                            if (empty($pwd)) {
                                print '<p class="red">Veuillez entrer votre mot de passe</p>';
                            }

                        }
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="email">*Email : </label>
                        <input name="email" class="form-control" type="email" placeholder="Entrez votre email">
                        <?php
                        if (isset($_POST['submit_form'])) {
                            if (empty($email)) {
                                print '<p class="red">Veuillez entrer votre e-mail</p>';
                            }
                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                print '<p class="text-danger bg-light rounded p-1">erreur, l\'email entré n\'est pas correct</p>';
                            }
                        }
                        ?>
                    </div>

                    <div class="col-md-6">
                        <label for="age">Âge : </label>
                        <input name="age" class="form-control" type="number" placeholder="Entrez votre age">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="address">Adresse :</label>
                        <input type="text" class="form-control" id="address" name="address"
                               placeholder="numéro et adresse">
                    </div>

                    <div class="col-md-6">
                        <label for="country">Pays : </label>
                        <select class="form-control" name="country">
                            <option value="Allemagne">Allemagne</option>
                            <option value="Autriche">Autriche</option>
                            <option value="Belgique">Belgique</option>
                            <option value="Bulgarie">Bulgarie</option>
                            <option value="Croatie">Croatie</option>
                            <option value="Danemark">Danemark</option>
                            <option value="Espagne">Espagne</option>
                            <option value="France">France</option>
                            <option value="Grèce">Grèce</option>
                            <option value="Irlande">Irlande</option>
                            <option value="Italie">Italie</option>
                            <option value="Luxembourg">Luxembourg</option>
                            <option value="Paysbas">Pays-Bas</option>
                            <option value="Pologne">Pologne</option>
                            <option value="Portugal">Portugal</option>
                            <option value="Républiquetchèque">République-tchèque</option>
                            <option value="Roumanie">Roumanie</option>
                            <option value="Slovaquie">Slovaquie</option>
                            <option value="Slovénie">Slovénie</option>
                            <option value="Suède">Suède</option>
                            <option value="Turquie">Turquie</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="telephone">Téléphone : </label>
                        <input name="telephone" class="form-control" type="tel" placeholder="Entrez votre numéro" pattern="^[0-9]{3,4}/[0-9]{2}.[0-9]{2}.[0-9]{2}$" title="Le numéro de téléphone doit être du type 0479/99.99.99 ou 065/65.65.65">
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <br>
                        <p>Avez-vous un animal domestique : </p>
                        <input type="checkbox" id="pet1" name="cat" value="Chat">
                        <label for="pet1">J'ai un chat</label>
                        <br>
                        <input type="checkbox" id="pet2" name="dog" value="Chien">
                        <label for="pet2">J'ai un chien</label>
                        <br>
                        <input type="checkbox" id="pet3" name="otherpet" value="Autre">
                        <label for="pet3">Autre animal domestique</label>
                        <br>
                        <input type="checkbox" id="petNo" name="nopet" value="Aucun">
                        <label for="petNo">Je n'ai pas d'animal.</label>
                    </div>

                    <div class="col-md-6">
                        <br><label for="brands">Vos marques préférées :<br>(Ctrl : sélection multiple)</label>
                        <br>
                        <select name="brands[]" class="form-control" id="brands" multiple>

                            <option value="felix">Felix</option>
                            <option value="gourmet">Gourmet</option>
                            <option value="pedigree">Pedigree</option>
                            <option value="purina">Purina</option>
                            <option value="royalC">Royal Canin</option>
                            <option value="vitakraft">Vitakraft</option>
                            <option value="whiskas">Whiskas</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <br><label for="comment">Un commentaire :</label>
                        <br>
                        <textarea class="form-control" name="comment" rows="3" cols="25" id="comment"
                                  placeholder="Entrez vos remarques "></textarea>
                    </div>

                    <div class="col-md-6">
                        <br><label for="file">Ajouter une photo de votre animal :</label><br>
                        <input type="file" class="form-control" name="file" accept="image/png,image/jpeg">
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <p>Moyen de contact au choix :</p>
                        <?php foreach ($contact as $cnt) : ?>
                            <input type="radio" name="cont" id="cont_<?php echo $cnt ?>" value="<?php echo $cnt ?>"/>
                            <label for="cont_<?php echo $cnt ?>"><?php echo $cnt ?></label><br>
                        <?php endforeach; ?>
                    </div>

                    <div class="col md-6">
                        <p>S'inscrire à nos services : </p>
                        <ul>
                            <?php foreach ($service as $serv) : ?>
                                <li>
                                    <input type="checkbox" name="service[]" value="<?php echo $serv ?>">
                                    <label for="service[]"><?php echo $serv ?></label>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                    </div>

                </div>
                <br>

                <div class="row">
                    <div>
                        <p>Voulez-vous vous inscrire à notre newsletter : <label for="Newsletter1">Oui </label>
                            <input type="radio" id="yesNews" name="newslet" value="Oui">
                            <label for="Newsletter2">Non </label>
                            <input type="radio" id="NoNews" name="newslet" value="Non"></p>

                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col md-6">
                        <p>(*) -> informations obligatoires</p>
                        <button type="submit" name="submit_form" id=submit" class="btn btn-primary">Valider</button>
                        <button type="reset" class="btn btn-secondary">Effacer</button>
                    </div>

                </div>

            </form>

        </div>
    </div>

</div>





