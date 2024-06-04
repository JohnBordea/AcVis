const ButtonEdit = document.getElementById("button-edit");
const ButtonSave = document.getElementById("button-save");
const FavoriteContainer = document.getElementById("favorite-container");
const FavoritePageButtonIndexLeft = document.getElementById("button-favorite-previous");
const FavoritePageButtonIndexRight = document.getElementById("button-favorite-next");
const FavoritePageIndex = document.getElementById("favorite-page-index");
const errorLabel = document.getElementById("user-insert-error");
var lastPage = false;
var pageCount = 0;

async function sendRestAPIRequest(operation, url, onloadFunction, jsonData) {
    const xhr = new XMLHttpRequest();
    xhr.open(operation, url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = onloadFunction;
    xhr.send(jsonData);
}

function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/;SameSite=None; Secure";
}

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

ButtonEdit.addEventListener("click", (e) => {
    document.getElementById("user-firstname").readOnly = false;
    document.getElementById("user-lastname").readOnly = false;
    document.getElementById("user-username").readOnly = false;
    document.getElementById("user-email").readOnly = false;

    ButtonEdit.classList.remove("enabled");
    ButtonEdit.classList.add("disabled");
    ButtonEdit.disabled = true;

    ButtonSave.classList.remove("disabled");
    ButtonSave.classList.add("enabled");
    ButtonSave.disabled = false;
})

function setUserData() {
    document.getElementById("user-firstname").value = getCookie("firstname");
    document.getElementById("user-lastname").value = getCookie("lastname");
    document.getElementById("user-username").value = getCookie("username");
    document.getElementById("user-email").value = getCookie("email");
}


ButtonSave.addEventListener("click", (e) => {
    var firstName = document.getElementById("user-firstname").value;
    var lastName = document.getElementById("user-lastname").value;
    var userName = document.getElementById("user-username").value;
    var emailName = document.getElementById("user-email").value;

    errorLabel.style.display = "none";

    if (firstName === "" || lastName === "" || userName === "" || emailName === "") {
        errorLabel.style.display = "inline";
        errorLabel.textContent = "All fields must be filed."
        return;
    }

    sendRestAPIRequest(
        "PUT",
        "./rest/api/users/",
        function() {
            var response = JSON.parse(this.responseText);
            if (response.hasOwnProperty("result")) {
                setCookie("firstname", response["result"]['firstname'], 10);
                setCookie("lastname", response["result"]['lastname'], 10);
                setCookie("username", response["result"]['username'], 10);
                setCookie("email", response["result"]['email'], 10);
            }
            setUserData();

            document.getElementById("user-firstname").readOnly = true;
            document.getElementById("user-lastname").readOnly = true;
            document.getElementById("user-username").readOnly = true;
            document.getElementById("user-email").readOnly = true;

            ButtonEdit.classList.remove("disabled");
            ButtonEdit.classList.add("enabled");
            ButtonEdit.disabled = false;

            ButtonSave.classList.remove("enabled");
            ButtonSave.classList.add("disabled");
            ButtonSave.disabled = true;
        },
        JSON.stringify({
            token: getCookie("token"),
            firstname: firstName,
            lastname:  lastName,
            username:  userName,
            email:     emailName,
        })
    )
})

FavoritePageButtonIndexLeft.addEventListener("click", (e) => {
    e.preventDefault();
    if(parseInt(FavoritePageIndex.value) > 1){
        FavoritePageIndex.value = parseInt(FavoritePageIndex.value) - 1;
        getFavouriteActorByPage();
    }
})

FavoritePageIndex.addEventListener('keyup', function onEvent(e) {
    if (e.keyCode === 13) {
        if(parseInt(FavoritePageIndex.value) > pageCountUser){
            FavoritePageIndex.value = pageCountUser;
        } else if(parseInt(FavoritePageIndex.value) < 1){
            FavoritePageIndex.value = 1;
        }
        getFavouriteActorByPage();
    }
});

FavoritePageButtonIndexRight.addEventListener("click", (e) => {
    e.preventDefault();
    if(!lastPage){
        FavoritePageIndex.value = parseInt(FavoritePageIndex.value) + 1;
        getFavouriteActorByPage();
    }
})

function deleteFavActor(id) {
    sendRestAPIRequest(
        "DELETE",
        "./rest/api/actor/fav/",
        function() {
            getFavouriteActorByPage()
        },
        JSON.stringify({
            id:    id,
            token: getCookie("token")
        })
    )
}

function goToActor(id) {
    window.location.replace("actor.php?id=" + id);
}

function getFavouriteActorByPage() {
    sendRestAPIRequest(
        "GET",
        "./rest/api/actor/fav/?page=" + FavoritePageIndex.value + "&token=" + getCookie("token"),
        function() {
            var response = JSON.parse(this.responseText);
            console.log(response);
            var table = document.getElementById("general-fav-table");
            var rows = table.getElementsByTagName("tr");
            for (var i = 1; i < rows.length;) {
                rows[i].parentNode.removeChild(rows[i]);
            }
            if (response.hasOwnProperty("page_count")) {
                pageCount = response["page_count"];
            } else {
                pageCount = 0;
            }
            if (response.hasOwnProperty("last_page") && response.hasOwnProperty("actor")) {
                for (var i = 0; i < response["actor"].length; i++) {
                    var newRow = document.createElement("tr");

                    var cellId = document.createElement("td");
                    cellId.textContent = response["actor"][i]["actor_id"];
                    cellId.style.display = "none";

                    var cellName = document.createElement("td");
                    cellName.textContent = response["actor"][i]["actor_name"];
                    cellName.onclick = function() {
                        goToActor(this.parentNode.firstElementChild.textContent, false);
                    };

                    var cellToDelete = document.createElement("td");
                    cellToDelete.textContent = "Unfavorite";
                    cellToDelete.className = "delete small";
                    cellToDelete.onclick = function() {
                        deleteFavActor(this.parentNode.firstElementChild.textContent, false);
                    };
                    newRow.appendChild(cellId);
                    newRow.appendChild(cellName);
                    newRow.appendChild(cellToDelete);

                    table.appendChild(newRow);
                }
                lastPage = response["last_page"];
            } else {
                lastPage = true;
            }
        },
        null
    );
}

function setFavoriteActors(pageIndex) {
    FavoriteContainer.innerHTML = "";

    for(let i = 0; i < 30; i++){
        var h3Element = document.createElement('h3');
        h3Element.textContent = "Name" + i;

        var divTextElement = document.createElement('div');
        divTextElement.appendChild(h3Element);
        divTextElement.classList.add("f-name");

        var imgElement = document.createElement('img');
        imgElement.src = "./assets/imgs/actor-icon.png";
        imgElement.alt = "Favorite Actor";

        var aElement = document.createElement('a');
        aElement.classList.add("invisible-link");
        aElement.appendChild(imgElement);
        aElement.appendChild(divTextElement);

        var divContainerElement = document.createElement('div');
        divContainerElement.appendChild(aElement);
        divContainerElement.classList.add("f-item");

        FavoriteContainer.appendChild(divContainerElement);
    }
    FavoritePageIndex.value = pageIndex;
}

document.addEventListener('DOMContentLoaded', function() {
    errorLabel.style.display = "none";
    setUserData();
    getFavouriteActorByPage();
})