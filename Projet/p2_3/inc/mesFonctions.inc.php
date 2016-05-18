<?php
$lesMenus = [
    'menu' => [
        'accueil' => 'accueil.html',
        'contact' => 'contact.html',
        'profil' => 'profil.html',
        'Administration' => 'admin.html',
        'inscription' => 'newAccount.html',
        'connexion' => 'login.html',
    ],
    'sous-menu' => [
        'bienvenue' => ''
    ]
];
$menuAccueil = [
    'Bienvenue' => ''
];
$menuContact = [
    'Contact' => ''
];
$menuProfil = [
    'Profil' => ''
];
$menuAdmin = [
    'administration' => '',
    'config' => 'config.html',
    'affiche session' => 'getSession.html',
    'efface session' => 'resetSession.html'
];
$menuNewAccount = [
    'Inscription' => ''
];
$menuLogin = [
    'Connexion' => ''
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
    return $html;
}

function traiteRequest($rq){
    global $envoi;
    global $lesMenus;
    switch($rq){
        case 'accueil' :
            send('contenu', getAccueil());
            send('sous-menu',sousMenu($rq));
            break;
        case 'config' :
            send('contenu',configForm());
            break;
        case 'admin' :
            send('sous-menu',sousMenu($rq));
            send('contenu', accueilAdmin());
            break;
        case 'profil' :
        case 'newAccount' :
        case 'contact' :
        case 'login' :
            send('contenu',chargeTemplate($_GET['rq']));
            send('sous-menu', sousMenu($rq));
            break;
        case 'testForm' :
            send('contenu', getFormInfo());
            break;
        case 'inc/writeConfig' :
            sendMessage('success', 'Sauvegarde de la config', saveConfig());
            send('siteName', $_SESSION['siteName']);
            send('logo', $_SESSION['logo']);
            send('altLogo', $_SESSION['altLogo']);
            break;
        case 'getSession' :
            send('contenu', getSession());
            break;
        case 'resetSession' :
            send('contenu', resetSession());
            break;
        default :
            send('contenu', 'Requète inconnue : '.$_GET['rq']);
    }
}

function getAccueil(){
    return "<p>Bienvenue</p>";
}

function chargeTemplate($t){
    $file = file('inc/'.$t.'.template.inc.php');
    return implode('', $file);
}

function getFormInfo(){
    $tmp = "<pre>";
    $tmp.= print_r(array('_GET'=>$_GET,'_POST'=>$_POST,'_FILES'=>$_FILES), true);
    $tmp .= "</pre>";
    return $tmp;
}
function configForm(){
    $conf = new Config();
    return $conf->getForm();
}
function saveConfig(){
    $conf = new Config();
    $return = $conf->writeConfig();
    $_SESSION['siteName'] = $conf->getData('site', 'name');
    $_SESSION['logo'] = $conf->getData('image', 'folder')."/".$conf->getData('logo', 'name');
    $_SESSION['altLogo'] = $conf->getData('logo', 'alt');
    return $return;
}

function getSession(){
    $tmp = "Contenu de la variable de session : ";
    $tmp .= "<pre>";
    $tmp .= print_r($_SESSION, true);
    $tmp .= "</pre>";
    return $tmp;
}
function resetSession(){
    $sessId = $_SESSION['sessionId'];
    session_destroy();
    $_SESSION['sessionId'] = $sessId;
    $tmp = "Session effacée : ";
    $tmp .= "<pre>";
    $tmp .= print_r($_SESSION, true);
    $tmp .= "</pre>";
    return $tmp;
}
function accueilAdmin(){
    $html = "<h1>Bienvenue</h1>
            <p>dans la zone d'<b>administration</b></p>";
    return $html;
}
function sousMenu($rq){
    $name = "menu".ucwords($rq);
    global $$name;
    return creerMenu($$name);
    /*switch ($rq){
        case 'accueil':
            creerMenu([$rq => '']);
            break;
        case 'admin' :
    }*/
}
function sendMessage($type, $titre, $texte){
    global $envoi;
    $envoi["message"]=['text'=>$texte,
        'title'=>$titre,
        'dialogClass'=>$type];
}
function send($loc, $ctn){
    global $envoi;
    $envoi[$loc] = $ctn;
}
function sendAlert($type=null, $texte='', $titre=''){
    global $envoi;
    if(!isset($envoi["alerte"]));
}