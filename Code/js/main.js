/* When the user clicks on the nav-right buttons, 
toggle between hiding and showing the addOn content */
function addonSwitchFunc() {
    var addon_display = document.getElementById("addon-menu").style.display;
    if (addon_display == "none") {
        document.getElementById("addon-menu").style.display = "block";
    } else {
        document.getElementById("addon-menu").style.display = "none";
    }
}

// Menu toggle function
function menuFunc1(x) {
    x.classList.toggle("change");
}

function menuFunc2() {
    var element = document.getElementsByClassName("menu-list");
    
    for (var i = 0; i < element.length; i++) {
        element[i].classList.toggle("hidden");
    }

}
function allParse(response){
    var result = [];
    var all = JSON.parse(response);
    for (index = 0; index < all.length; index++){
        var course = JSON.parse(response[index]);
        result.push(course);
    }
    return result;
}