$(document).ready(function(){
    $( "#message" ).dialog({
        dialogClass: "no-close",
        autoOpen : false,
        closeOnEscape : true,
        buttons: [
            {
                text: "OK",
                click: function() {
                    $( this ).dialog( "close" );
                }
            }
        ]
    });
    addClickEventListener('sous-menu');
    addClickEventListener('menu');
    $("#o_accueil").click();
    if($("#alerte").html()==""){
        $.get('index.php', 'rq=alerte', function(an){
            traiteRetour(testeJson(an));
        });
    }
    $.ajaxSetup({
        beforeSend : function(xhr){
            //xhr.setRequestHeader('Set-Cookie',
            //'PHPSESSID=' + document.cookie.split('yolo32=')[1].split(';')[0]);
        },
        contentType : false
    });
});

function traiteRetour(obJs){
    $.map(obJs, function(val, i){
        switch (i){
            case 'menu' :
            case 'sous-menu' :
            case 'contenu' : $('#'+i).html(val);
                break;
            case 'alert' :
                alert(val);
                break;
            case 'alerte' :
                $('#'+i).html(traiteAlerte(val));
                break;
            case 'message' :
                $( "#"+i ).html(val.text);
                $( "#"+i ).dialog("option", "title", val.title);
                $( "#"+i ).dialog("option", "dialogClass", val.dialogClass);
                $("#"+i).dialog("option", "width", 300);
                if(val.dialogClass=="error"){
                    $("#"+i).dialog("option", "width", 500);
                }
                $( "#"+i ).dialog("open");
                break;
            case 'siteName' :
                $("#title").text(val);
                break;
            case 'logo' :
                $("#logo").attr("src", val);
                break;
            case 'altLogo' :
                $("#logo").attr("alt", val);
                break;
            case 'click' :
                $(val).click();
                break;
            case 'css' :
                $(val.location).css(val.property, val.value);
                break;
            case 'addClass' :
                $(val.location).addClass(val.className);
                break;
            case 'removeClass' :
                $(val).removeClass();
                break;
            case 'loadCanvas' :
                loadCanvas();
                break;
            case 'profil' :
                for(var i in val){
                    if(i=="avatar")$("#"+i).parent().prepend(val[i]+"</br>");
                    $("#"+i).val(val[i]);
                }
                break;
            case 'viewMsg' :
                $("#message").html(val.msg);
                $("#message").dialog("option", "title", val.title);
                $("#message").dialog("option", "width", 700);
                $( "#"+i ).dialog("option", "dialogClass", val.class);
                $("#message").dialog("open");
                handleForm();
                break;
            case 'repContactOk' :
                $("#o_messages").click();
                break;
            case 'imageFolder' :
            default : alert('Erreur retour : \nCas non traité = '+i+'\n'+val);
        }
        switch (i){
            case 'menu' :
            case 'sous-menu' :
                addClickEventListener(i);
                break;
        }
    })
}
function addClickEventListener(id){
    $('#'+id+' a').click(function(event){
        event.preventDefault();
        $("#message").dialog("close");
        $("#message").html("");
        $( "#message" ).dialog("option", "dialogClass", "");
        var e = this;
        var rq = e.getAttribute('href');
        rq = rq.substring(0, rq.lastIndexOf("."));
        $.get('index.php', 'rq='+rq,function(an){
            traiteRetour(testeJson(an));
            $('title').html(e.innerHTML.capitalize());
            extendInputForm();
            if($("#contenu #tableMessage").length!=0)handleMsg();
            if($("#contenu form").length != 0)handleForm();
        });
        $(".selected").removeClass('selected');
        $(this).addClass("selected");
        return false;
    });
}
function testForm(t, sub){
    var ok = true;
    var item = null;
    t.find(".formError").remove();
    switch(sub){
        case 'contact' :
            var mail = t.find("#email");
            if(!mailOk(mail.val())){
                mail.after('<span class="formError">Mail non conforme</span>');
                ok = false;
            }
            item = t.find("#verif_email");
            if(item.val()!= mail.val()){
                item.after('<span class="formError">Les deux adresses doivent être identiques</span>');
                ok = false;
            }
            item = t.find("#subject");
            if(! item.val().split(' ').join('')){
                item.after('<span class=formError>Vide ou seulement des espaces</span>');
                ok=false;
            }
            item  = t.find('#msg');
            if(! item.val().split(' ').join('').split("\n").join('')){
                item.after('<span class=formError>Vide ou seulement des espaces et/ou return</span>');
                ok = false;
            }
            break;

    }
    return ok;
}
function mailOk(mail){
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(mail);
}
String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
};
function testeJson(an){
    var json = {};
    try{ json = $.parseJSON(an);}
    catch(err){
        if(an!=null){
            json["message"] = {
                'text' : "Json non valide : </br>"+err+"</br>"+an,
                'title' : "Retour Json Erroné",
                'dialogClass' : "error"
            }
        }else{
            json["message"] = {
                'text' : "Réponse Vide",
                'title' : "Retour Json Erroné",
                'dialogClass' : "error"
            }
        }
    }
    return json;
}
function traiteAlerte(val){
    if(val==""){
        return "";
    }
    for(var i in val){
        if(val[i].length==0){
            $("#"+i).remove();
            return;
        }
        if(val[i]['titre']==""){
            if(val[i]['texte']!=""){
                $("#"+i).remove();
                return $("#alerte").html()+"<span id='"+i+"'> "+val[i]['texte']+" </span>";
            }else{
                $("#"+i).remove();
            }
        }else{
            $("#"+i).remove();
            return $("#alerte").html()+"<span id='"+i+"' title=\""+val[i]['titre']+"\"> "+val[i]['texte']+" </span>";
        }
    }
}
function extendInputForm(){
    $(":input").keypress(function(e){
        if($(this).attr("type")=="text"||$(this).attr("type")=="email"){
            if($(this).attr("size")<=$(this).val().length){
                var i = parseInt($(this).val().length, 10) + 1;
                $(this).attr("size", i);
            }
        }
    });
    $("textarea").keypress(function(e){
        if(e.keyCode==13){
            if($(this).val().split("\n").length==$(this).attr("rows")-1){
                var i = parseInt($(this).attr("rows"), 10)+1;
                $(this).attr("rows", i);
            }
        }else{
            var lines = $(this).val().split("\n");
            if($(this).attr("cols")-7<=lines[lines.length-1].length){
                var i = parseInt($(this).attr("cols"), 10)+1;
                if(i<190) $(this).attr("cols", i);
            }
        }
    });
}
function handleForm(){
    $('form').submit(function(e){
        e.preventDefault();
        var submitName = $(this).find(':submit').attr('name');
        var f = $("form");
        var rq = f.attr('action');
        rq = rq.substring(0, rq.lastIndexOf("."));
        var data = new FormData(f[0]);
        if(!testForm($(this),submitName))return ;
        $("#message").dialog("close");
        $("#message").html("");
        $( "#message" ).dialog("option", "dialogClass", "");
        $.ajax({
            url: 'index.php?rq='+rq+'&submit='+submitName,
            type: 'POST',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (an) {
                traiteRetour(testeJson(an));
            }
        });
    });
}
function handleMsg(){
    var msgTab = $("#contenu #tableMessage tbody");
    var tr = msgTab.find("tr");
    for(var i in tr){
        if($.isNumeric(i)){
            var td = $($(tr[i]).find("td")[1]);
            if(td[0]!=null) {
                if (td.text() == "non") {
                    td.addClass("nonAnswered");
                    td.attr("title", "Répondre");
                    td.attr("onclick", "replyMessage(" + $($(tr[i]).find("td")[0]).text() + ");")
                }
            }else{
                $($($(tr[i]).find("td")[0])[0]).text("Pas de messages");
            }
        }
    }
    $('#tableMessage').dataTable();
}
function replyMessage(id){
    $.get('index.php', "rq=repMessage&msg="+id,function(an){
        traiteRetour(testeJson(an));
    });
}