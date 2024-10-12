$(document).ready(function(){

    $('#click_x').click(function(){
        $('#home_bg').hide();
    });

    $('#sign').click(function(){
        $('#home_bg').show();
    });
})


$(document).ready(function(){

    $('#click_x_lg').click(function(){
        $('#home_lgin').hide();
    });

    $('#log').click(function(){
        $('#home_lgin').show();
    });
})

$(document).ready(function(){

    $('#click_x_home').click(function(){
        $('#home_list').hide();
    });

    $('#home_l').click(function(){
        $('#home_list').show();
    });
})

$(document).ready(function(){

    $('#click_x_home').click(function(){
        $('#home_user_tt').hide();
    });

    $('#hoso').click(function(){
        $('#home_user_tt').show();
    });
})


var maining = document.querySelectorAll(".img_main>img")[0];
maining.onclick = function(){
    var lighbox = document.querySelectorAll(".lightbox")[0];
    lighbox.style.display="block";

    lighbox.getElementsByTagName("img")[0].src = this.src;

    lighbox.getElementsByTagName("div")[0].onclick = function(){
        lighbox.style.display = "none";
    }
}

var imgList = document.querySelectorAll(".img_list > img");
imgList.forEach(function(img) {
    img.onclick = function() {
        var lightbox = document.querySelector(".lightbox");
        lightbox.style.display = "block";
        lightbox.querySelector("img").src = this.src;

        lightbox.querySelector("div").onclick = function() {
            lightbox.style.display = "none";
        }
    }
});

