$(document).ready(function(){
    $.get('index.php', 'rq=accueil',function(an) {
        $("#txtAccueil").html(an);
    });
    $('#o_accueil').addClass("selected");
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
                        $('#txtAccueil').html(an);
                    }
                });
            });
        });
        $(".selected").removeClass('selected');
        $(this).addClass("selected");
        return false;
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