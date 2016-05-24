<?php
function setMenu(){
    if(isAdmin()||isSousAdmin()){
        return  [
            'accueil' => 'accueil.html',
            'contact' => 'contact.html',
            'profil' => 'profil.html',
            'edition' => 'edit.html',
            'Administration' => 'admin.html',
            'deconnexion' => 'logout.html'
        ];
    }else if(isAnonym()||isActiv()){
        return [
            'accueil' => 'accueil.html',
            'contact' => 'contact.html',
            'connexion' => 'login.html'
        ];
    }else if(isMembre()){
        return [
            'accueil' => 'accueil.html',
            'contact' => 'contact.html',
            'profil' => 'profil.html',
            'edition' => 'edit.html',
            'deconnexion' => 'logout.html'
        ];
    }
    sendMessage("error", "Erreur Menu", monPrint_r($_SESSION['is']));
    return ['erreur' => ''];
}
$menuAccueil = [
    getProfil() => ''
];
$menuContact = [
    'Contact' => '',
    'veuillez remplir ce formulaire pour contacter l\'administrateur' => ''
];
$menuProfil = [
    'Edition du profil' => ''
];
$menuAdmin = [
    'administration' => '',
    'utilisateurs' => 'adminUser.html',
    'Messages' => 'msg.html',
    'config' => 'config.html',
    '---Admin only---' => '',
    'affiche session' => 'getSession.html',
    'efface session' => 'resetSession.html'
];
$menuAdminLimit = [
    'administration' => '',
    'utilisateurs' => 'adminUser.html',
    'Messages' => 'msg.html',
    'config' => 'config.html'
];
$menuNewAccount = [
    'Inscription' => ''
];
$menuEdit = [
    'Outil de dessin' => ""

];
$menuEditReact = [
    'Outil de dessin non disponible pour votre statut' => ""

];
$menuLogin = [
    'Connexion' => 'onlyLogin.html',
    'inscription' => 'newAccount.html',
    'Mot de passe perdu' => 'mdp_perdu.html'
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
    $html = "<ul>";
    foreach($menu as $key => $item){
        if($item!="") {
            $html .= "<li><a id='o_".strtolower($key)."' href='" . $item . "' onclick='return false' >" . $key . "</a></li>";
        }else{
            $html .= "<li><h1>" . $key . "</h1></li>";
        }
    }
    $html .= "</ul>";
    return $html;
}
function okDroit($rq){
    $adminOnly = ['submit_config', 'getSession', 'resetSession', 'adminUser', 'admin', 'config',
                    'manageSsAdmin', 'submit_manageSsAdmin', 'msg'];
    $base = ['accueil', 'contact', 'submit_contact', 'alerte'];
    $auth = ['profil', 'submit_profil', 'logout', 'edit'];
    $nonAuth = ['login', 'submit_login', 'onlyLogin',
                'newAccount', 'submit_newAccount',
                'mdp_perdu', 'submit_mdp_perdu'];
    $react = [];
    $noSsAdmin = ['getSession', 'resetSession'];
    $ok = false;
    switch(true){
        case !isAuthentified():
            $ok =   in_array($rq, $base) || in_array($rq, $nonAuth);
            break;
        case isSousAdmin() :
            if(in_array($rq, $noSsAdmin))break;
            if($ok = in_array($rq, $base))break;
            if($ok = in_array($rq, $adminOnly))break;
        case isAdmin() :
            if($ok = in_array($rq, $base))break;
            if(isAdmin()&&$ok = in_array($rq, $adminOnly))break;
        case isReact():
            if(in_array($rq, $react))break;
        case isMembre() :
            if(!isReact() && $ok = in_array($rq, $react))break;
            $ok = in_array($rq, $base) || in_array($rq, $auth);
    }
    if(!$ok) noAccess(monPrint_r(["Requète" => $rq, "Is" => $_SESSION['is']]));
    return $ok;
}
function traiteRequest($rq){
    if($rq=='testForm'){
        $rq = 'submit_'.(isset($_GET['submit'])?$_GET['submit'] : '???');
    }
    if(! okDroit($rq)) return -1;
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
            if(isSousAdmin())send('sous-menu',sousMenu($rq."Limit"));
            break;
        case 'edit' :
            if(isReact()){
                send('contenu',"Vous devez valider votre nouveau mail pour pouvoir éditer.");
                send('sous-menu', sousMenu($rq."React"));
                break;
            }
            send('contenu',chargeTemplate($rq));
            send('sous-menu', sousMenu($rq));
            send("loadCanvas", "");
            break;
        case 'profil' :
            send('contenu',chargeTemplate($rq));
            send('sous-menu', sousMenu($rq));
            if(isset($_SESSION['user']))send("profil", ["pseudo"=> $_SESSION['user']["username"], "email"=> $_SESSION['user']["email"],"avatar" => "<img src=\"img/".$_SESSION["user"]["avatar"]."\" alt=\"avatar\">"]);
            break;
        case 'contact' :
        case 'login' :
            send('contenu',chargeTemplate($rq));
            send('sous-menu', sousMenu($rq));
            break;
        case 'newAccount' :
        case 'mdp_perdu' :
            send('contenu',chargeTemplate($rq));
            break;
        case 'onlyLogin' :
            send('contenu',chargeTemplate("login"));
            break;
        case 'testForm' :
            send('contenu', getFormInfo());
            break;
        case 'submit_config' :
            if(isSousAdmin()){
                noAccess("VOUS NE POUVEZ PAS MODIFIER/SAUVER");
                break;
            }
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
        case 'submit_login' :
            login();
            break;
        case 'logout' :
            logout();
            break;
        case 'alerte' :
            getAlertes();
            break;
        case 'msg' :
            getMsg();
            break;
        default :
            send('contenu', 'Requète inconnue : '.$rq);
    }
}
function noAccess($msg){
    global $envoi;
    sendMessage("warn", "Contrôle d'accès", $msg);
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
    if($_GET['submit']=="login"){
        genereStatuts(false);
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
                unset($_SESSION['user']);
                return;
            }
            $answer->closeCursor();
            if(isReact()||isActiv()){
                sendAlert('react', 'vous devez valider votre nouveau mail', 'avec le lien envoyé dans l\'email qui vous a été envoyé à la nouvelle adresse');
            }else{
                sendAlert('react');
            }
            send("menu", creerMenu(setMenu()));
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
function logout(){
    genereStatuts(true);
    unset($_SESSION['user']);
    send('removeClass', 'body');
    send("menu", creerMenu(setMenu()));
    send('click', "#o_accueil");
    sendAlert();
    sendMessage("Bye", "Au Revoir", "Merci de votre visite.\n à bientôt.");
}
function chargeProfil(){
    require "dbConnect.php";
    $answer = $db->query('select * from profil');
    while($d = $answer->fetch()){
        $_SESSION['profilList'][$d['profilId']] = $d['profilName'];
    }
    $answer->closeCursor();
}
function monPrint_r($print){
    return "<pre>".print_r($print, true)."</pre>";
}
function getProfil(){
    if(isset($_SESSION['user'])){
        if($_SESSION['user']!= null){
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
            unset($_SESSION['user']);
            return "Bienvenue";
        }
    }else{
        return "Bienvenue";
    }
}
function genereStatuts($anonyme){
    $_SESSION['is']['authentified'] = false;
    $_SESSION['is']['edit'] = false;
    foreach($_SESSION['profilList'] as $i){
        $_SESSION['is'][$i] = false;
    }
    $_SESSION['is']['anonyme'] = $anonyme;
}
function getAlertes(){
    if(isReact()||isActiv()){
        sendAlert('react', 'vous devez valider votre nouveau mail', 'avec le lien envoyé dans l\'email qui vous a été envoyé à la nouvelle adresse');
    }
    if(isset($_SESSION['user']))foreach($_SESSION['user']['profil_id'] as $k => $i)send("addClass", array("location"=>"body", "className"=>$i));
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
function getMsg(){
    require "dbConnect.php";
    $answer = $db->query('  SELECT m.msgId as Id, (Select if((select count(m1.msgId) from message as m1 where m1.msgParentId = m.msgId)=0, "non", "oui")) as Répondu,
                            m.msgCreateTime as "Date", u1.userPseudo as Auteur, u2.userPseudo as Destinataire, m.msgSubject as Sujet
                            FROM message as m
                            inner join user as u1 on m.msgAuthor=u1.userId
                            inner join user as u2 on m.msgRecipient=u2.userId
                            where m.msgRecipient = '.$_SESSION['user']['user_id']);
    $i = 1;
    $cont[0] = ["Id", "Répondu", "Date", "Auteur", "Destinataire", "Sujet"];
    while($d = $answer->fetch()){
        $cont[$i] = [];
        foreach($d as $k => $v){
            if(!is_numeric($k)){
                array_push($cont[$i], $v);
            }
        }
        $i++;
    }
    $answer->closeCursor();
    $tab = new Tableau($cont, "Liste des messages", true, 6);
    send("contenu", "<h1>Liste des messages</h1>".$tab->html());
    send("dataTable","test");
}