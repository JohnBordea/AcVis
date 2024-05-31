const actorContainer = document.getElementById("actor-container");
const actorPageIndex = document.getElementById("actor-page-index");
var lastPageActor = false;
var pageCountActor = 0;

async function sendRestAPIRequest(operation, url, onloadFunction, jsonData) {
    const xhr = new XMLHttpRequest();
    xhr.open(operation, url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = onloadFunction;

    xhr.send(jsonData);
}

function addActorIcon(name, img, id, container) {
    var h3Element = document.createElement('h3');
    h3Element.textContent = name;

    var divTextElement = document.createElement('div');
    divTextElement.appendChild(h3Element);
    divTextElement.classList.add("f-name");

    var imgElement = document.createElement('img');
    imgElement.src = img;
    imgElement.alt = "Actor";

    var aElement = document.createElement('a');
    aElement.classList.add("invisible-link");
    if (id != null) {
        aElement.href = "./actor.html?id=" + id;
    }
    aElement.appendChild(imgElement);
    aElement.appendChild(divTextElement);

    var divContainerElement = document.createElement('div');
    divContainerElement.appendChild(aElement);
    divContainerElement.classList.add("f-item");

    container.appendChild(divContainerElement);
}

function setActors() {
    sendRestAPIRequest(
        "GET",
        "./rest/api/actor/view/?page=" + actorPageIndex.value,
        function() {
            var response = JSON.parse(this.responseText);

            actorContainer.innerHTML = "";

            if (response.hasOwnProperty("page_count")){
                pageCountActor = response["page_count"];
            } else {
                pageCountActor = 0;
            }

            if (response.hasOwnProperty("actor")) {
                for (var i = 0; i < response["actor"].length; i++) {
                    var h3Element = document.createElement('h3');
                    h3Element.textContent = response["actor"][i]["actor_name"];

                    var divTextElement = document.createElement('div');
                    divTextElement.appendChild(h3Element);
                    divTextElement.classList.add("f-name");

                    var imgElement = document.createElement('img');
                    imgElement.id = "actor" + String(response["actor"][i]["id"]);
                    //imgElement.src = response["actor"][i]["img"];
                    imgElement.alt = "actor" + String(response["actor"][i]["id"]);

                    var aElement = document.createElement('a');
                    aElement.classList.add("invisible-link");
                    aElement.href = "./actor.html?id=" + response["actor"][i]["id"];
                    aElement.appendChild(imgElement);
                    aElement.appendChild(divTextElement);

                    var divContainerElement = document.createElement('div');
                    divContainerElement.appendChild(aElement);
                    divContainerElement.classList.add("f-item");

                    actorContainer.appendChild(divContainerElement);
                }

                for (var i = 0; i < response["actor"].length; i++) {
                    sendRestAPIRequest(
                        "GET",
                        "./rest/api/actor/view/?actor=" + response["actor"][i]["id"],
                        function() {
                            var response = JSON.parse(this.responseText);

                            if (response.hasOwnProperty("actor")) {
                                var actorIMG = document.getElementById("actor" + String(response["actor"]["id"]));
                                actorIMG.src = response["actor"]["img"];
                            }
                        },
                        null
                    )

                }
            }
        },
        null
    );
}

document.addEventListener("DOMContentLoaded", function () {
    actorPageIndex.value = 1;
    actorContainer.innerHTML = "";
    for(let i = 0; i < 30; i++) {
        addActorIcon("Actor " + String(i + 1), "./assets/imgs/actor-icon.png", null, actorContainer);
    }
    setActors();
})