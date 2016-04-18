$(document).ready(function(){
    $('input:file').change(function(){
        var ext = this.value.split(".");
        ext = ext[ext.length-1];
        if(ext != "jpg" && ext != "png" && ext != "gif"){
            $(':submit').attr('disabled', true);
        }else{
            if($('#id').value!=null){
                $(':submit').attr('disabled', false);
            }
            $("#size").text(this.files[0].size+" Bytes");
        }
    });
    $('#id').change(function(){
        if(this.value==null){
            $(':submit').attr('disabled', true);
        }else{
            //var ext = $('input:file').value.split(".");
            //ext = ext[ext.length-1];
            //if(ext != "jpg" && ext != "png" && ext != "gif"){
                $(':submit').attr('disabled', false);
            //}
        }
        var fileName = "avatars2/" + this.value + ".png";
        if (exists(fileName)) {
            $('#avatar').attr("src", fileName);
        } else {
            $('#avatar').attr("src", "avatars2/unknown.png");
        }
    })
});
function exists(url){
    var http = new XMLHttpRequest();
    http.open('HEAD', url, false);
    http.send();
    return http.status!=404;
}