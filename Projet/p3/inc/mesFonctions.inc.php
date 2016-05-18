<?php
$lesMenus = [
    'menu' => [
        'accueil' => 'accueil.html',
        'contact' => 'contact.html',
        'profil' => 'profil.html',
        'Administration' => 'admin.html',
        'inscription' => 'newAccount.html',
        'connexion' => 'login.html',
    ]
];
$menuAccueil = [
    getProfil() => ''
];
$menuContact = [
    'Contact' => ''
];
$menuProfil = [
    'Profil' => ''
];
$menuAdmin = [
    'administration' => '',
    'utilisateurs' => 'adminUser.html',
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
$texte = [
    'vous n\'avez pas accès',
    'vous n\'avez pas accès, vous devez valider votre mail',
    'vous avez un accès normal',
    'vous avez un accès limité car vous devez revalider votre mail',
    'vous vous êtes connecté normalement donc je devrais vous enlever ce statut',
    'vous avez un accès "Admin" limité',
    'vous avez un accès "Admin" complet'
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
        case 'adminUser' :
            getUserList();
            break;
        case 'loginForm' :
            login();
            break;
        case 'alerte' :
            getAlertes();
            break;
        default :
            send('contenu', 'Requète inconnue : '.$_GET['rq']);
    }
}

function getAccueil(){
    global $texte;
    if(isset($_SESSION['user'])){
        $profil = array_keys($_SESSION['user']['profil_id']);
        $profil = end($profil);
        return "<h1>Bienvenue cher membre</h1>
                    <p>Vous avez le statut \"".$_SESSION['profilList'][$profil]."\" et ".$texte[$profil]."</p>";
    }else{
        return "<h1>Bienvenue</h1>";
    }
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
    if(!isset($envoi["alerte"])) $envoi['alerte'] = [];
    if($type)$envoi['alerte'][$type] = [];
    if($texte)$envoi['alerte'][$type]['texte'] = $texte;
    if($titre)$envoi['alerte'][$type]['titre'] = $titre;
   }

function getUserList(){
    require "dbConnect.php";
    $answer =$db->query('SELECT userId as User, userPseudo as Pseudo, userEmail as Email FROM user');//requète
    $d = [];
    while($donnees=$answer->fetch()){
        array_push($d, array("Id"=>$donnees['User'], "Pseudo"=>$donnees['Pseudo'], "Email"=>$donnees['Email']));
    };
    send('contenu', "<pre>".print_r($d, true)."</pre>");
    $answer->closeCursor();//ferme le curseur de la bdd
}
function login(){
    if($_GET['submit']=="send"){
        require "dbConnect.php";
        if($_POST['username']!=null&&$_POST['password']!=null){
            $_SESSION['user'] = [];
            $answer = $db->query('  select u.userId as "user_id", u.userPseudo as "username", u.userEmail as "email", u.userMdp as "password",
                                    u.userCreationDate as "create_time", u.userQuestion as "question_secrete", u.userAnswer as "reponse_secrete",
                                    userAvatar as avatar, group_concat(distinct up.profilId separator \',\') as profil_id
                                    from user as u inner join user_profil as up on u.userId = up.userId
                                    where userPseudo="'.$_POST['username'].'"
                                    group by u.userId, u.userPseudo');
            while($d = $answer->fetch()){
                if($_POST['password']==$d['password']){
                    foreach($d as $key => $value){
                        if(!is_numeric($key)){
                            if($key!="profil_id"){
                                $_SESSION['user'][$key] = $value;
                            }else{
                                $e = explode(",", $value);
                                $_SESSION['user'][$key] = [];
                                foreach($e as $v){
                                    $_SESSION['user'][$key][$v] = $_SESSION['profilList'][$v];
                                    $_SESSION['is'][$_SESSION['profilList'][$v]] = true;
                                    if($_SESSION['profilList'][$v]!="anonyme"&&$_SESSION['profilList'][$v]!="activation"){
                                        $_SESSION['is']['authentified'] = true;
                                    }
                                }
                            }
                        }
                    }
                }else{
                    sendMessage("warn", "Connexion Impossible", "Non concordance entre le pseudo et le mot de passe.");
                    return;
                }
            }
            if($_SESSION['user']==null){
                sendMessage("warn", "Connexion Impossible", "Cet utilisateur n'existe pas.");
                return;
            }
            $answer->closeCursor();
            if(isset($_SESSION['user']['profil_id'][3])){
                sendAlert('react', 'vous devez valider votre nouveau mail');
            }else{
                sendAlert('react');
            }
            send('click', "#o_accueil");
            if(!(isAnonym()||isActiv()||isReact())){
                $_SESSION['is']['edit'] = true;
            }
            foreach($_SESSION['user']['profil_id'] as $k => $i)send("addClass", array("location"=>"body", "className"=>$i));
        }else if($_POST['username']==null){
            sendMessage("warn", "Champ manquant", "Le champ utilisateur est vide");
        }else if($_POST['password']==null){
            sendMessage("warn", "Champ manquant", "Le champ mot de passe est vide");
        }
    }
}
function chargeProfil(){
    require "dbConnect.php";
    $answer = $db->query('select * from profil');
    while($d = $answer->fetch()){
        $_SESSION['profilList'][$d['profilId']] = $d['profilName'];
    }
}
function getProfil(){
    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
        $html = "<div id='profil'>
                <p>[".$user['user_id']."] ".$user['username']."</p>
                <p id='pp'>";
        if($user['avatar']){
            $html .= "<img src='img/".$user['avatar']."'>";
        }else{
            $html .= "<img src='img/unknown.png'>";
        }
        $html .= "</p><p>".$user['email']."</p>";
        $html .= "<fieldset>
                <legend> Profils </legend>
                <div id='ctn'>";
        foreach($user['profil_id'] as $v){
            $html .= "<p>$v</p>\n";
        }
        $html .= "</div></fieldset>";
        $html .= "</div>";
        return $html;
    }else{
        return "Bienvenue";
    }
}
function genereStatuts(){
    $_SESSION['is']['authentified'] = false;
    $_SESSION['is']['edit'] = false;
    foreach($_SESSION['profilList'] as $i){
        $_SESSION['is'][$i] = false;
    }
}
function getAlertes(){
    if(isReact()){
        sendAlert('react', 'vous devez valider votre nouveau mail', 'avec le lien envoyé dans l\'email qui vous a été envoyé à la nouvelle adresse');
    }
    foreach($_SESSION['user']['profil_id'] as $k => $i)send("addClass", array("location"=>"body", "className"=>$i));
}
function changeCss($location, $property, $value){
    global $envoi;
    if(!isset($envoi['css']))$envoi['css'] = [];
    array_push($envoi, array("location"=>$location,
        "property"=>$property,
        "value"=>$value));
}
function isAdmin(){return $_SESSION['is']['admin'];}
function isAuthentified(){return $_SESSION['is']['authentified'];}
function isAnonym(){return $_SESSION['is']['anonyme'];}
function isActiv(){return $_SESSION['is']['activation'];}
function isMembre(){return $_SESSION['is']['membre'];}
function isReact(){return $_SESSION['is']['reactivation'];}
function isMdpp(){return $_SESSION['is']['mdp-perdu'];}
function isSousAdmin(){return $_SESSION['is']['sous-admin'];}