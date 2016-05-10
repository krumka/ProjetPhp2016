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
    //$( "#message" ).dialog("close");
    $.get('index.php', 'rq=accueil',function(an) {
        traiteRetour(JSON.parse(an));
    });
    $.ajaxSetup({
        beforeSend : function(xhr){
            //xhr.setRequestHeader('Set-Cookie',
            //'PHPSESSID=' + document.cookie.split('yolo32=')[1].split(';')[0]);
        },
        contentType : false
    })
    $('#o_accueil').addClass("selected");
    addClickEventListener('sous-menu');
    addClickEventListener('menu');
});

function traiteRetour(obJs){
    $.map(obJs, function(val, i){
        switch (i){
            case 'menu' :
            case 'sous-menu' :
            case 'contenu' : $('#'+i).html(val);
                break;
            case 'alerte' :
                alert(val);
                break;
            case 'message' :
                $( "#"+i ).text(val.text);
                $( "#"+i ).dialog("option", "title", val.title);
                $( "#"+i ).dialog("option", "dialogClass", val.dialogClass);
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
            case 'imageFolder' :
            default : alert('Erreur retour : \nCas non traité = '+i+'\n'+val);
        }
        switch (i){
            case 'menu' :
                addClickEventListener(i);
                break;
            case 'sous-menu' :
                addClickEventListener(i);
                break;
        }
    })
}
function addClickEventListener(id){
    $('#'+id+' a').click(function(event){
        event.preventDefault();
        var e = this;
        var rq = e.getAttribute('href');
        rq = rq.substring(0, rq.lastIndexOf("."));
        $.get('index.php', 'rq='+rq,function(an){
            console.log(an);
            traiteRetour(JSON.parse(an));
            $('title').html(e.innerHTML.capitalize());
            $(':submit').click(function(e){
                e.preventDefault();
                var f = $(this).closest("form");
                var rq = f.attr('action');
                rq = rq.substring(0, rq.lastIndexOf("."));
                var data = new FormData(f[0]);
                $.ajax({
                    url: 'index.php?rq='+rq+'&submit='+$(this).attr('name'),
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
        });
        $(".selected").removeClass('selected');
        $(this).addClass("selected");
        return false;
    });
}
String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
};
function testeJson(an){
    var json = {};
    try{ json = $.parseJSON(an);}
    catch(err){
        json["message"] = {
            'text' : "Json non valide : "+err,
            'title' : "Retour Json Erroné",
            'dialogClass' : "error"
        }
    }
    return json;
}