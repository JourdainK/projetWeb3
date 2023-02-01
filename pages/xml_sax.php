<?php

function startElement($parser, $element, $element_attrs){
    switch($element){
        case 'MEMBERS' :
            print '<div class="container-fuild">';
            print '<div class="row mx-auto pt-4">';
            break;

        case 'MEMBER' :
            print'<div class="col">
                           <div class="card mx-auto mt-5 bg-info" style="width: 18rem;">
                              <div class="card-body mx-auto">
                                <h5 class="card-title mx-auto">Membre</h5>
                            </div >
                              <ul class=" list-group list-group-flush">';
            break;

        case 'LOGIN' :
            print '<li class="list-group-item fw-bold text-center ">';
            break;

        case 'PASSWORD' :
            print '<li class="list-group-item text-start"><span class="fw-bold">Password : </span>';
            break;

        case 'EMAIL' :
            print '<li class="list-group-item text-start"><span class="fw-bold">Email : </span>';
            break;

        case 'AGE' :
            print '<li class="list-group-item text-start"><span class="fw-bold">Age : </span>';
            break;

        case 'ADRESSE' :
            print '<li class="list-group-item text-start"><span class="fw-bold">Adresse : </span>';
            break;

        case 'PAYS' :
            print '<li class="list-group-item text-start"><span class="fw-bold">Pays : </span>';
            break;

        case 'TELEPHONE' :
            print '<li class="list-group-item text-start"><span class="fw-bold">Telephone : </span>';
            break;

        case 'ANIMAUX' :
            print '<span class="fw-bold text-start bg-dark text-light">&nbspAnimaux : </span>';
            break;

        case 'ANIMAL' :
            print '<li class="list-group-item text-start "><span class="fw-bold">  -  </span>';
            break;

        case 'MARQUES' :
            print '<span class="fw-bold text-start bg-dark text-light">&nbspMarque(s) préférée(s) : </span>';
            break;

        case 'MARQUE' :
            print '<li class="list-group-item text-start "><span class="fw-bold">  -  </span>';
            break;

        case 'SERVICES' :
            print '<span class="fw-bold text-start bg-dark text-light">&nbspService(s) choisi(s) : </span>';
            break;

        case 'SERVICE' :
            print '<li class="list-group-item text-start "><span class="fw-bold">  -  </span>';
            break;

        case 'COMMENTAIRE' :
            print '<li class="list-group-item text-start "><span class="fw-bold">Commentaire :  </span>';
            break;

        case 'CONTACT' :
            print '<li class="list-group-item text-start "><span class="fw-bold">Moyen de contact choisi :  </span>';
            break;

        case 'PHOTO' :
            print '<li class="list-group-item text-center mx-auto"><span class="fw-bold">Photo uploadée :<img src="';
            break;

        case 'NEWSLETTER' :
            print '<li class="list-group-item text-start "><span class="fw-bold">Choix pour la newsletter :  </span>';
            break;

    }

}

function endElement($parser, $element){
    switch ($element){
        case 'MEMBERS' :
            print '</div>';
            print '</div>';
            break;

        case 'MEMBER' :
            print '</div>';
            print '</div>';
            print '</ul>';
            break;

        case 'LOGIN' :
            print '</li>';
            break;

        case 'PASSWORD' :
            print '</li>';
            break;

        case 'EMAIL' :
            print '</li>';
            break;

        case 'AGE' :
            print '</li>';
            break;

        case 'ADRESSE' :
            print '</li>';
            break;

        case 'PAYS' :
            print '</li>';
            break;

        case 'TELEPHONE' :
            print '</li>';
            break;

        case 'ANIMAUX' :
            print '';
            break;

        case 'ANIMAL' :
            print '</li>';
            break;

        case 'MARQUES' :
            print '<span class="fw-bold text-start bg-dark text-light"><hr></span>';
            break;

        case 'MARQUE' :
            print '</li>';
            break;

        case 'SERVICES' :
            print '<span class="fw-bold text-start bg-dark text-light"><hr></span>';
            break;

        case 'SERVICE' :
            print '</li>';
            break;

        case 'COMMENTAIRE' :
            print '</li>';
            break;

        case 'CONTACT' :
            print '</li>';
            break;

        CASE 'PHOTO' :
            print '" width="65%"></li>';
            break;

        case 'NEWSLETTER' :
            print '</li>';
            break;
    }
}



function characterData($parser, $data)
{
    print htmlentities($data);
}

$parser = xml_parser_create();

xml_set_element_handler($parser,'startElement','endElement');
xml_set_character_data_handler($parser,'characterData');

$fichier = fopen('./lib/XML/members.xml','r') OR die("Impossible d'ouvrir le ficher xml");

while ($data = fread($fichier, 4096)) {
    xml_parse($parser, $data, feof($fichier))
    or die (sprintf('Erreur XML %s à la ligne %d', xml_error_string(xml_get_error_code($parser)), xml_get_current_line_number($parser)));
}

fclose($fichier);

xml_parser_free($parser);

?>