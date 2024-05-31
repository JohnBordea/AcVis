const ButtonEdit = document.getElementById("button-edit");
const ButtonSave = document.getElementById("button-save");
const FavoriteContainer = document.getElementById("favorite-container");
const FavoritePageButtonIndexLeft = document.getElementById("button-favorite-previous");
const FavoritePageButtonIndexRight = document.getElementById("button-favorite-next");
const FavoritePageIndex = document.getElementById("favorite-page-index");
var lastPage = false;
var pageCount = 0;

async function sendRestAPIRequest(operation, url, onloadFunction, jsonData) {
    const xhr = new XMLHttpRequest();
    xhr.open(operation, url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = onloadFunction;
    xhr.send(jsonData);
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

ButtonSave.addEventListener("click", (e) => {
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

function getFavouriteActorByPage() {
    sendRestAPIRequest(
        "GET",
        "./rest/api/actor/fav/?page=" + FavoritePageIndex.value + "&token=" + getCookie("token"),
        function() {
            var response = JSON.parse(this.responseText);
            console.log(response);
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
    getFavouriteActorByPage();
})