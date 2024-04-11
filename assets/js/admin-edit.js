function openCity(evt, cityName) {
    var i, tab_content, tab_link;

    tab_content = document.getElementsByClassName("tab-bar-content");
    for (i = 0; i < tab_content.length; i++) {
        tab_content[i].style.display = "none";
    }

    tab_link = document.getElementsByClassName("tab-bar-link");
    for (i = 0; i < tab_link.length; i++) {
        tab_link[i].className = tab_link[i].className.replace(" active", "");
    }

    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

document.getElementById("defaultOpen").click();