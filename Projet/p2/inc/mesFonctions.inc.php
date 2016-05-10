<?php
$lesMenus = [
    'menu' => [
        'accueil' => 'accueil.html',
        'contact' => 'contact.html',
        'profil' => 'profil.html',
        'config' => 'config.html',
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
        case 'config' : configForm();
            break;
        case 'profil' :
        case 'newAccount' :
        case 'contact' :
        case 'login' : $contenu = chargeTemplate($_GET['rq']);
            break;
        case 'testForm' : $contenu = getFormInfo();
            break;
        case 'inc/writeConfig' : $contenu = saveConfig();
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
    echo "<pre>";
    print_r(array('_GET'=>$_GET,'_POST'=>$_POST,'_FILES'=>$_FILES));
    echo "</pre>";
}
function configForm(){
    $conf = new Config();
    echo $conf->getForm();
}
function saveConfig(){
    //print_r($_POST['site']['name']);
    $conf = new Config();
    echo $conf->writeConfig();
}