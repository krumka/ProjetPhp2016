$(document).ready(function(){
    $("body").html($("link").html()+$("script").html()+$("#themeroller-content").html());
    $("h1, hr, .themeroller__demo-area, #downloadTheme, #rollerTabsNav, #demo-options, #themeGallery, #help").remove();
    $("#downloadTheme").html("Réduire");
    $(".theme-group-header").click();
    $(".themeroller__app-area, .application").css("width", "100%");
    $(".theme-group").css("display", "inline-block");
    $(".application").prepend("<input type=button value=Réduire id='reduct' style='padding: 5px;margin: 10px;font-size: 1.2em'>");
    $("#reduct").click(function(){
        if($(this).val()!="Réduire"){
            $(this).val("Réduire");
            $(".theme-group-header").click();
        }else{
            $(this).val("Ouvrir");
            $(".theme-group-header").click();
        }
    });
});