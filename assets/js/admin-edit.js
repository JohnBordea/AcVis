const userPageIndex = document.getElementById("user-table-page-index");
var lastPage = false;

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function makeUserAdmin(userId) {
    const xhr = new XMLHttpRequest();
    var url = "./rest/api/users/";
    xhr.open("PUT", url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    var data = JSON.stringify({
        user_id: userId,
        token: getCookie("token"),
        role: 'admin'
    });

    xhr.onload = function() {
        getUsersByPage();
    };
    xhr.send(data);
}

function deleteUserAdmin(userId) {
    const xhr = new XMLHttpRequest();
    var url = "./rest/api/users/";
    xhr.open("DELETE", url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    var data = JSON.stringify({
        user_id: userId,
        token: getCookie("token")
    });

    xhr.onload = function() {
        getUsersByPage();
    };
    xhr.send(data);
}

function getUsersByPage() {
    const xhr = new XMLHttpRequest();
    var url = "./rest/api/users/?page=" + userPageIndex.value + "&token=" + getCookie("token");
    xhr.open("GET", url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        var response = JSON.parse(xhr.responseText);
        console.log(response);

        var table = document.getElementById("general-user-table");
        var rows = table.getElementsByTagName("tr");
        for (var i = 1; i < rows.length;) {
            rows[i].parentNode.removeChild(rows[i]);
        }

        if (response.hasOwnProperty("last_page") && response.hasOwnProperty("users")) {
            for (var i = 0; i < response["users"].length; i++) {
                var newRow = document.createElement("tr");

                var cellId = document.createElement("td");
                cellId.textContent = response["users"][i]["id"];

                var cellFN = document.createElement("td");
                cellFN.textContent = response["users"][i]["firstname"];

                var cellLN = document.createElement("td");
                cellLN.textContent = response["users"][i]["lastname"];

                var cellEM = document.createElement("td");
                cellEM.textContent = response["users"][i]["email"];

                var cellIsAdmin = document.createElement("td");
                if(response["users"][i]["role"] == "user"){
                    cellIsAdmin.textContent = "Make Admin";
                    cellIsAdmin.className = "edit small";
                    cellIsAdmin.onclick = function() {
                        makeUserAdmin(this.parentNode.firstElementChild.textContent);
                    };
                } else {
                    cellIsAdmin.textContent = "Is Admin";
                    cellIsAdmin.className = "small";
                }

                var cellToDelete = document.createElement("td");
                cellToDelete.textContent = "Delete";
                cellToDelete.className = "delete small";
                cellToDelete.onclick = function() {
                    deleteUserAdmin(this.parentNode.firstElementChild.textContent);
                };

                newRow.appendChild(cellId);
                newRow.appendChild(cellFN);
                newRow.appendChild(cellLN);
                newRow.appendChild(cellEM);
                newRow.appendChild(cellIsAdmin);
                newRow.appendChild(cellToDelete);

                table.appendChild(newRow);
            }
            lastPage = response["last_page"];
        } else {
            lastPage = true;
        }
    };

    xhr.send(null);
}

document.getElementById("button-user-table-previous").addEventListener("click", (e) => {
    e.preventDefault();
    if(parseInt(userPageIndex.value) > 1){
        userPageIndex.value = parseInt(userPageIndex.value) - 1;
        getUsersByPage();
    }
})

document.getElementById("button-user-table-next").addEventListener("click", (e) => {
    e.preventDefault();
    if(!lastPage){
        userPageIndex.value = parseInt(userPageIndex.value) + 1;
        getUsersByPage();
    }
})

function openProp(evt, adminProp) {
    var i, tab_content, tab_link;

    tab_content = document.getElementsByClassName("tab-bar-content");
    for (i = 0; i < tab_content.length; i++) {
        tab_content[i].style.display = "none";
    }

    tab_link = document.getElementsByClassName("tab-bar-link");
    for (i = 0; i < tab_link.length; i++) {
        tab_link[i].className = tab_link[i].className.replace(" active", "");
    }

    document.getElementById(adminProp).style.display = "block";
    evt.currentTarget.className += " active";

    if (adminProp == "menu-user")
        getUsersByPage();
}

document.getElementById("defaultOpen").click();

document.addEventListener("DOMContentLoaded", function () {
    userPageIndex.value = 1;
})