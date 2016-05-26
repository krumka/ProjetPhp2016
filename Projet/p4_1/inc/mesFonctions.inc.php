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
    'efface session' => 'resetSession.html',
    'Effacer RqLogs' => 'resetRqLogs.html'
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
                    'manageSsAdmin', 'submit_manageSsAdmin', 'msg', 'resetRqLogs', 'repMessage', 'submit_repContact'];
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
            if(isset($_SESSION['user'])){
                $profil = ["pseudo"=> $_SESSION['user']["username"], "email"=> $_SESSION['user']["email"]];
                if(!empty($_SESSION['user']['avatar'])) $profil["avatar"] = "<img src=\"img/".$_SESSION["user"]["avatar"]."\" alt=\"avatar\">";
                send("profil", $profil);
            }
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
        case 'submit_contact' :
            gereFormContact();
            break;
        case 'resetRqLogs' :
            deleteRqLogs();
            break;
        case 'repMessage' :
            repMessage();
            break;
        case 'submit_repContact' :
            saveReponseMsg();
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
function gereFormContact(){
    $msg = [];
    $mail = $_POST['email'];
    if(empty($mail)) $msg[] = "<li>Mail vide</li>";
    else if(empty($_POST['verif_email'])) $msg[] = "<li>La vérification de l'email est vide</li>";
    else if(!filter_var($mail, FILTER_VALIDATE_EMAIL))$msg[] = "<li>Adresse Mail non valide</li>";
    else if($mail != $_POST['verif_email']) $msg[] = "<li>Les adresses mails doivent être identiques</li>";
    $item = str_replace(' ', '', $_POST['subject']);
    if(empty($item))$msg[] = "<li>Le sujet est vide</li>";
    $item = str_replace([' ', "\n", "\r"], ['', '', ''], $_POST['msg']);
    if(empty($item))$msg[] = "<li>Le message est vide</li>";
    if($msg)sendError("Erreur dans le formulaire", "<ul>\n".implode("\n",$msg)."</ul>\n");
    else sauveMsg();
}
function sauveMsg(){
    require "dbConnect.php";
    $req = $db->prepare('INSERT INTO message(msgAuthor, msgMail, msgSubject, msgContenu, msgCreateTime) VALUES(:auteur, :email, :sujet, :msg, now())');
    $req->execute(array(
    "auteur"=> htmlspecialchars($_SESSION['user']['user_id']),
    "email"=> htmlspecialchars($_POST['email']),
    "sujet"=> htmlspecialchars($_POST['subject']),
    "msg"=> htmlspecialchars($_POST['msg'])
    ));
    $html = [];
    $html[] = "<table id='contactMail' style='border: 1px solid black;border-collapse: collapse;'>";
    $html[] = "    <thead>";
    $html[] = "        <tr>";
    $html[] = "            <th style='color: white;background-color: black;border-left:white dotted 1px;font-size:1.15em;padding: .4em;text-align: center;'>Courriel</th>";
    $html[] = "            <th style='color: white;background-color: black;border-left:white dotted 1px;font-size:1.15em;padding: .4em;text-align: center;'>". $_POST['email'] ."</th>";
    $html[] = "        </tr>";
    $html[] = "    </thead>";
    $html[] = "     <tbody>";
    $html[] = "         <tr>";
    $html[] = "             <td>Sujet : </td>";
    $html[] = "             <td>". $_POST['subject'] ."</td>";
    $html[] = "         </tr>";
    $html[] = "         <tr>";
    $html[] = "             <td style='border : 1px dotted grey;text-align: center;padding:.3em;'>Message : </td>";
    $html[] = "             <td style='border : 1px dotted grey;text-align: center;padding:.3em;'><pre style='background-color: rgba(0,0,0,0)'>". $_POST['msg'] ."</pre></td>";
    $html[] = "         </tr>";
    $html[] = "     </tbody>";
    $html[] = "</table>";
    $html = implode("\n", $html);
    sendMail("<p>Ce Message a été enregistré sur le site : </p>\n</br></br>".$html."\n</br></br></br><p>Bien à vous,</p>\n</br></br><p>Administrateur du serveur EPHEC.</br></br></p>", "Confirmation de réception du message", $_POST['email'], $_SESSION['mail'], "Admin Site Rémy Lambinet");
    sendSuccess("Message Envoyé", "Votre message a été envoyé avec succès et une copie de votre message a été envoyé à l'adresse mail communiquée.");
    send("contenu", $html);
}
function sendSuccess($titre, $msg){
    sendMessage("success", $titre, $msg);
}
function sendError($titre, $msg){
    sendMessage("error", $titre, $msg);
}
function getFormInfo(){
    $tmp = "<pre>";
    $tmp.= print_r(array('_GET'=>$_GET,'_POST'=>$_POST,'_FILES'=>$_FILES), true);
    $tmp .= "</pre>";
    send("contenu", $tmp);
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
    $_SESSION['mail'] = $conf->getData('site', 'mail');
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
    session_destroy();
    $tmp = "Session effacée : ";
    $tmp .= "<pre>";
    $tmp .= print_r($_SESSION, true);
    $tmp .= "</pre>";
    return $tmp;
}
function deleteRqLogs(){
    unset($_SESSION['rqLog']);
    send("contenu", "Les logs des requètes ont été effacés".monPrint_r($_SESSION));
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
            $answer = $db->query('  select userPseudo from user where userPseudo="'.$_POST['username'].'"');
            if($d = $answer->fetch()){
                $answer = $db->query('  select u.userId as "user_id", u.userPseudo as "username", u.userEmail as "email", u.userMdp as "password",
                                        u.userCreationDate as "create_time", u.userQuestion as "question_secrete", u.userAnswer as "reponse_secrete",
                                        userAvatar as avatar, group_concat(distinct up.profilId separator \',\') as profil_id
                                        from user as u inner join user_profil as up on u.userId = up.userId
                                        where (userMdp=md5("'.$_POST['password'].'") AND userPseudo="'.$_POST['username'].'")
                                        group by u.userId, u.userPseudo');
                if($d = $answer->fetch()){
                    foreach($d as $key => $value){
                        if(!is_numeric($key)){
                            if($key!="profil_id"){
                                $_SESSION['user'][$key] = $value;
                            }else if($key=="password") {
                                $_SESSION['user'][$key] = $_POST['password'];
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
                    unset($_SESSION['user']);
                    genereStatuts(true);
                    return;
                }
            }else{
                sendMessage("warn", "Connexion Impossible", "Cet utilisateur n'existe pas.");
                unset($_SESSION['user']);
                genereStatuts(true);
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
            if(!empty($user['avatar'])){
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
    $answer = $db->query('  SELECT m.msgId as Id, (Select if((select count(m1.msgId) from message as m1 where m1.msgParentId = m.msgId)=0, "non",
							concat("oui - ", (select group_concat(distinct m2.msgId separator \', \') from message as m2 where m2.msgParentId = m.msgId)))) as Répondu,
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
    if(empty($cont))echo "hello";
    $tab = new Tableau($cont, "Liste des messages", true, "tableMessage");
    send("contenu", "<h1>Liste des messages</h1>".$tab->html());
}
function antiBalises(){
    if(isset($_POST)){
        foreach($_POST as $key => $value){
            $_POST[$key] = htmlspecialchars($value);
        }
    }
    if(isset($_GET)){
        foreach($_GET as $key => $value){
            $_GET[$key] = htmlspecialchars($value);
        }
    }
}
function sendMail($msg, $subject, $to, $fromMail, $fromName=null, $replyMail = "noRepply", $replyName=null, $type = "html"){
    if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $to)){
        $passage_ligne = "\r\n";
    } else{
        $passage_ligne = "\n";
    }
    //Header of the mail
    if($fromName!=null)$fromAdress = "\"$fromName\"<$fromMail>";
    else $fromAdress = $fromMail;
    if($replyName!=null)$replyAdress = "\"$replyName\" <$replyMail>";
    else $replyAdress = $replyMail;

    $headers = 'MIME-Version: 1.0' . $passage_ligne;
    $headers .= "Content-type: text/$type; charset=iso-8859-1" . $passage_ligne;
    $headers .= "From: $fromAdress" . $passage_ligne .
        "Reply-To: $replyAdress" . $passage_ligne .
        "X-Mailer: PHP/" . phpversion();

    $msg .= $passage_ligne.$passage_ligne.strtolower(dirname($_SERVER['SERVER_PROTOCOL'])) . "://" . $_SERVER['HTTP_HOST'] . explode("?", $_SERVER['REQUEST_URI'])[0];
    $msg = wordwrap($msg, 70, $passage_ligne);
    if(mail($to,$subject,$msg, $headers)){
        return true;
    }
    return false;
}
function repMessage(){
    require "dbConnect.php";
    $answer = $db->query('  select u1.userPseudo as auteur, m.msgMail as mail, u2.userPseudo as destinataire, m.msgSubject as sujet , m.msgContenu as msg, m.msgAuthor as destId, m.msgId as msgId, m.msgCreateTime as date
                            from message as m
                            inner join user as u1 on m.msgAuthor = u1.userId
                            inner join user as u2 on m.msgRecipient = u2.userId
                            where msgId = '.$_GET['msg']);
    $d = $answer->fetch();
    $_SESSION['msg']['contenu'] = $contenu = str_replace("\n", "\n</br>", $d["msg"]);
    $_SESSION['msg']['sujet'] = $subject = "RE : ".$d['sujet'];
    $_SESSION['msg']['destinataire'] = $auteur = $d['destinataire'];
    $_SESSION['msg']['destinataireId'] = $d['destId'];
    $_SESSION['msg']['mail'] = $dest = $d['mail'];
    $_SESSION['msg']['auteur'] = $d['auteur'];
    $_SESSION['msg']['msgId'] = $d['msgId'];
    $_SESSION['msg']['date'] = $d['date'];
    $msg =
"<table id='showMessage'>
    <tr>
        <td>De : </td>
        <td>$d[auteur] ($d[mail])</td>
    </tr>
    <tr>
        <td>A : </td>
        <td>$d[destinataire]</td>
    </tr>
    <tr>
        <td>Sujet : </td>
        <td>$d[sujet]</td>
    </tr>
    <tr>
        <td>Message : </td>
        <td style='text-align: left'>$contenu</td>
    </tr>
</table>";
    ob_start();
    require("inc/reponseMsg.template.inc.php");
    $msg .= ob_get_clean();
    send("viewMsg", ["title"=>"Réponse au message n°".$_GET['msg'],"msg"=>$msg, "class" => "msgShow"]);
    $answer->closeCursor();
}
function saveReponseMsg(){
$_SESSION['msg']['contenu'];
$_SESSION['msg']['destinataire'];
$_SESSION['msg']['mail'];
$_SESSION['msg']['auteur'];
    $values = "null, {$_SESSION['user']['user_id']}, '{$_SESSION['user']['email']}', '".addslashes($_SESSION['msg']['sujet'])."',"
     ."'".addslashes($_POST['msg'])."', {$_SESSION['msg']['destinataireId']}, now(), {$_SESSION['msg']['msgId']}";
    $sql = "INSERT INTO message VALUES ($values);";
    $db = connecteDb();
    if($db){
        $db->query($sql);
        $lastId=$db->lastInsertId();
        sendSuccess('Réponse au contact', 'Réponse sauvegardée sous le n°'.$lastId."\n<hr>Un mail a été envoyé<hr>Rechargement de la liste des message en cours...");
        send('repContactOk', $lastId);
        $html = [];
        $html[] = "<table id='contactMail' style='border: 1px solid black;border-collapse: collapse;'>";
        $html[] = "    <thead>";
        $html[] = "        <tr>";
        $html[] = "            <th style='color: white;background-color: black;border-left:white dotted 1px;font-size:1.15em;padding: .4em;text-align: center;'>Courriel</th>";
        $html[] = "            <th style='color: white;background-color: black;border-left:white dotted 1px;font-size:1.15em;padding: .4em;text-align: center;'>". $_SESSION['msg']['auteur']."(".$_SESSION['msg']['mail'] .")</th>";
        $html[] = "        </tr>";
        $html[] = "    </thead>";
        $html[] = "     <tbody>";
        $html[] = "         <tr>";
        $html[] = "             <td>Sujet : </td>";
        $html[] = "             <td>". $_SESSION['msg']['sujet'] ."</td>";
        $html[] = "         </tr>";
        $html[] = "         <tr>";
        $html[] = "             <td style='border : 1px dotted grey;text-align: center;padding:.3em;'>Message : </td>";
        $html[] = "             <td style='border : 1px dotted grey;text-align: center;padding:.3em;'><pre style='background-color: rgba(0,0,0,0)'>". $_SESSION['msg']['contenu'] ."</pre></td>";
        $html[] = "         </tr>";
        $html[] = "         <tr>";
        $html[] = "             <td style='border : 1px dotted grey;text-align: center;padding:.3em;'>Réponse : </td>";
        $html[] = "             <td style='border : 1px dotted grey;text-align: center;padding:.3em;'><pre style='background-color: rgba(0,0,0,0)'>". $_POST['msg'] ."</pre></td>";
        $html[] = "         </tr>";
        $html[] = "     </tbody>";
        $html[] = "</table>";
        $html = implode("\n", $html);
        sendMail("<p>Réponse à votre message du {$_SESSION['msg']['date']} : </p>\n</br></br>".$html."\n</br></br></br><p>Bien à vous,</p>\n</br></br><p>Administrateur du serveur EPHEC.</br></br></p>", $_SESSION['msg']['sujet'], $_SESSION['msg']['mail'], $_SESSION['mail'], "Admin Site Rémy Lambinet");
        sendMail("<p>Réponse à votre message du {$_SESSION['msg']['date']} : </p>\n</br></br>".$html."\n</br></br></br><p>Bien à vous,</p>\n</br></br><p>Administrateur du serveur EPHEC.</br></br></p>", "Le Message a été enregistré sur le site", $_SESSION['mail'], $_SESSION['msg']['mail'], "Admin Site Rémy Lambinet");
        $db = null;
    }else{
        sendError("Erreur SQL","<h1>Une erreur est survenue<h1>");
    }
}
function connecteDb(){
    $conf = new Config();
    try{
        return new PDO("mysql:host=".$conf->getData("db", "host").";dbname=".$conf->getData("db", "dbname"), $conf->getData("db", "user"), $conf->getData("db", "pswd"),array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }catch (PDOException $e) {
        sendMessage('error', 'Erreur Sql', 'Erreur PDO : ' . utf8_encode($e->getMessage()));
        return false;
    }
}