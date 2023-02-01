<?php
$xmlcheck = new DOMDocument();
$xmlcheck->load('./lib/XML/members.xml');
$result = $xmlcheck->schemaValidate('./lib/XML/members.xsd');

if (!$result) {
    print '<br><br><br><div class="container text-center"><div class="row"><p class="text-alert">Non valide</p></div></div>';
} else {
    print '<br><br><br><div class="container text-center"><div class="row"><p class="text-success bg-dark">Valide</p></div></div>';
}


?>