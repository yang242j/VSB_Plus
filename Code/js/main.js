/* When the user clicks on the nav-right buttons, 
toggle between hiding and showing the addOn content */
function addonFunc() {
    document.getElementById("addon-menu").style.display = "block";
}

// Close the addon if the user clicks outside of it
var usertext = document.getElementById("usertext");
window.onclick = function(event) {
    if (event.target != usertext) { 
        document.getElementById("addon-menu").style.display = "none";
        //console.log(dropbtn);
    }
    //console.log(document.getElementById("addon-menu").style.display);
}