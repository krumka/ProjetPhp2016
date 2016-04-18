$(document).ready(function(){
    $.get('index.php', 'rq=accueil',function(an) {
        $("#txtAccueil").html(an);
    });
    $('#o_accueil').attr("Class", "selected");
    $('.menu a').click(function(event){
        event.preventDefault();
        var e = this;
        var rq = e.getAttribute('href');
        rq = rq.substring(0, rq.lastIndexOf("."));
        $.get('index.php', 'rq='+rq,function(an){
            $("#txtAccueil").html(an);
            $('title').html(e.innerHTML);
            $(':submit').click(function(e){
                e.preventDefault();
                var rq = $(this).parents("form:first").attr('action');
                rq = rq.substring(0, rq.lastIndexOf("."));
                console.log(this);
                $.get("index.php", 'rq='+rq+'&'+$(this).parents("form:first").serialize()+'&submit='+this.getAttribute("id"),function(an){
                    $('#txtAccueil').html(an);
                });
            });
        });
        var x = document.getElementsByClassName("selected");
        var i;
        for (i = 0; i < x.length; i++) {
            x[i].className = "";
        }
        this.className = "selected";
    });
});

/*function getContenu(e) {
    var rq = e.getAttribute('href');
    rq = rq.substring(0, rq.lastIndexOf("."));
    $.ajax({
        url : "index.php?rq="+rq,
        type : 'GET',
        success : function(an, statut){
            //$(code_html).appendTo("#commentaires");
            $("#txtAccueil").html(an);
            $('title').html(e.innerHTML);
        }
    });
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("txtAccueil").innerHTML = xmlhttp.responseText;
            var xmlhttp2 = new XMLHttpRequest();
            xmlhttp2.onreadystatechange = function() {
                if (xmlhttp2.readyState == 4 && xmlhttp2.status == 200) {
                    document.getElementById("title").innerHTML = xmlhttp2.responseText;
                }
            };
            xmlhttp2.open("GET", "index.php?ti="+xmlhttp.responseText, true);
            xmlhttp2.send();
        }
    };
    xmlhttp.open("GET", "index.php?rq="+rq, true);
    xmlhttp.send();

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("txtTab").innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.open("GET", "getcourses.php?c="+v, true);
    xmlhttp.send();
}*/