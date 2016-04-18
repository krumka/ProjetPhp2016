<?php
$lesMenus = [
    'menu' => [
        'accueil' => 'accueil.html',
        'contact' => 'contact.html',
        'profil' => 'profil.html',
        'inscription' => 'newAccount.html',
        'connexion' => 'login.html',
    ],
    'sous-menu' => [
        'bienvenue' => ''
    ]
];

function creerMenu($menu){
    $html = "<ul>\n\t";
    foreach($menu as $key => $item){
        if($item!="") {
            $html .= "<li><a id=\"o_".strtolower($key)."\" href=\"" . $item . "\" onclick='return false' >" . $key . "</a></li>\n";
        }else{
            $html .= "<li><h1>" . $key . "</h1></li>\n";
        }
    }
    $html .= "</ul>";
    echo $html;
}

function getContenu($rq){
    $contenu = '';
    switch($rq){
        case 'accueil' : $contenu = getAccueil();
            break;
        case 'profil' :
        case 'newAccount' :
        case 'contact' :
        case 'login' : $contenu = chargeTemplate($_GET['rq']);
            break;
        case 'testForm' : $contenu = getFormInfo();
            break;
        default : $contenu = 'Requète inconnue : '.$_GET['rq'];
    }
    return $contenu;
}

function getAccueil(){
    return "<p>Bienvenue</p>";
}

function chargeTemplate($t){
    $file = file('inc/'.$t.'.template.inc.php');
    return implode('', $file);
}

function getFormInfo(){
    return print_r($_GET);
}