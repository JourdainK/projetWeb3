<div class="container-fluid">
    <div class="row mx-auto pt-5">

        <form class="mx-auto form-group" style="width: 40%" action="<?php print $_SERVER['PHP_SELF']; ?>" method="POST"
              enctype="multipart/form-data">
            <h2><br>Recherche de membre</h2>
            <div class="mb-3">
                <label for="log" class="form-label">Login : </label>
                <input name="log" type="text" class="form-control" id="log" aria-describedby="log">
                <div id="log" class="form-text">Entrer le login du membre</div>
            </div>
            <p class="fw-bold">Ou</p>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email : </label>
                <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Entrer l'email du membre</div>
            </div>

            <button name="submit_search" type="submit" class="btn btn-primary">Envoyer</button>
            <button type="reset" class="btn btn-secondary">Effacer</button>
        </form>
    </div>
    <?php

    print '<div class="row">';

    if (isset($_POST['submit_search'])) {
        extract($_POST, EXTR_OVERWRITE);
        $membersxml = simplexml_load_file('./lib/XML/members.xml');
        $nbrmbrs = count($membersxml);
        //print '<p>nombre de membres : '.$nbrmbrs.'</p>';

        if (!empty($log)) {
            foreach ($membersxml as $memb) {
                if (strtoupper($memb->login) == strtoupper($log)) {
                    print'<div class="col">
                           <div class="card mx-auto mt-5 bg-info" style="width: 18rem;">
                              <div class="card-body mx-auto">
                                <h5 class="card-title mx-auto">'.$memb->login.'</h5>
                            </div >
                              <ul class="list-group list-group-flush">
                                <li class="list-group-item">';
                    print 'Mot de passe : '.$memb->password.'</li>
                                <li class="list-group-item">';
                    print 'Email : '.$memb->email.'</li>
                                <li class="list-group-item">';
                    if(!empty($memb->age)){
                        print 'Age : '.$memb->age.'</li>';
                    }
                    if(!empty($memb->telephone)) {
                        print 'Telephone : <li class="list-group-item">'.$memb->telephone.'</li>';
                    }
                    if(!empty($memb->animaux)){
                        $nbranim = count($memb->animaux);
                        print '<br>Animaux : ';
                        foreach ($memb->animaux->animal as $anim){
                            print '<li class="list-group-item"> - '.$anim;
                        }
                        print '</li>';
                    }

                    if(!empty($memb->marques)){
                        $nbrbrds = count($memb->marques);
                        print '<br>Marques préférées : ';
                        foreach ($memb->marques->marque as $brand){
                            print '<li class="list-group-item"> - '.$brand;
                        }
                        print '</li>';
                    }

                    if(!empty($memb->contact)){
                        print 'Moyen de contact désiré : <li class="list-group-item">'.$memb->contact.'</li>';
                    }

                    if(!empty($memb->services->service)){
                        $nbrbrds = count($memb->services);
                        print '<br>Service(s) choisi(s) : ';
                        foreach ($memb->services->service as $srv){
                            print '<li class="list-group-item"> - '.$srv;
                        }
                        print '</li>';

                    }

                    if(!empty($memb->photo) && $memb->photo != 'uploads/'){
                        print 'photo uploadée : '.'<img src="./'.$memb->photo.'">';
                    }

                    print '</ul>
                           </div></div> ';

                }
            }
        }

        if (!empty($email) && empty($log)) {
            foreach ($membersxml as $memb) {
                if ($memb->email == $email) {
                    print'<div class="col">
                           <div class="card mx-auto mt-5 " style="width: 18rem;">
                              <div class="card-body mx-auto">
                                <h5 class="card-title mx-auto">'.$memb->login.'</h5>
                            </div >
                              <ul class="list-group list-group-flush">
                                <li class="list-group-item">';
                    print 'Mot de passe : '.$memb->password.'</li>
                                <li class="list-group-item">';
                    print 'Email : '.$memb->email.'</li>
                                <li class="list-group-item">';
                    if(!empty($memb->age)){
                        print 'Age : '.$memb->age.'</li>';
                    }
                    if(!empty($memb->telephone)) {
                        print 'Telephone : <li class="list-group-item">'.$memb->telephone.'</li>';
                    }
                    if(!empty($memb->animaux)){
                        $nbranim = count($memb->animaux);
                        print '<br>Animaux : ';
                        foreach ($memb->animaux->animal as $anim){
                            print '<li class="list-group-item"> - '.$anim;
                        }
                        print '</li>';
                    }

                    if(!empty($memb->marques)){
                        $nbrbrds = count($memb->marques);
                        print '<br>Marques préférées : ';
                        foreach ($memb->marques->marque as $brand){
                            print '<li class="list-group-item"> - '.$brand;
                        }
                        print '</li>';
                    }

                    if(!empty($memb->contact)){
                        print 'Moyen de contact désiré : <li class="list-group-item">'.$memb->contact.'</li>';
                    }

                    if(!empty($memb->services->service)){
                        $nbrbrds = count($memb->services);
                        print '<br>Service(s) choisi(s) : ';
                        foreach ($memb->services->service as $srv){
                            print '<li class="list-group-item"> - '.$srv;
                        }
                        print '</li>';

                    }

                    if(!empty($memb->photo)){
                        print 'photo uploadée : '.'<img src="./'.$memb->photo.'">';
                    }

                    print '</ul>
                           </div></div> ';

                }
            }
        }
    }
    print '</div > ';
    ?>
</div>
