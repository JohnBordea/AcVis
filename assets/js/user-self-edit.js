const ButtonEdit = document.getElementById("button-edit");
const ButtonSave = document.getElementById("button-save");

const FavoriteContainer = document.getElementById("favorite-container");

const FavoritePageButtonIndexLeft = document.getElementById("button-favorite-previous");
const FavoritePageButtonIndexRight = document.getElementById("button-favorite-next");
const FavoritePageIndex = document.getElementById("favorite-page-index");

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
    if(FavoritePageIndex.value > 1) {
        setFavoriteActors(FavoritePageIndex.value - 1);
    }
})

FavoritePageButtonIndexRight.addEventListener("click", (e) => {
    setFavoriteActors(FavoritePageIndex.value + 1);
})

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
    setFavoriteActors(1);
})