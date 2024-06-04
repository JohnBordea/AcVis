const actorIMG = document.getElementById("actor-img");
const actorName = document.getElementById("actor-name");
const actorMovieInfo =  document.getElementById("actor-movie-info");
const generalResultTable =  document.getElementById("general-result-table");
const addFav = document.getElementById("button-actor-add");
const removeFav = document.getElementById("button-actor-remove");
var isFav = false;
var actorId = parseURLParams(location.search)["id"][0];

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

function parseURLParams(url) {
    var queryStart = url.indexOf("?") + 1,
        queryEnd   = url.indexOf("#") + 1 || url.length + 1,
        query = url.slice(queryStart, queryEnd - 1),
        pairs = query.replace(/\+/g, " ").split("&"),
        parms = {}, i, n, v, nv;

    if (query === url || query === "") return;

    for (i = 0; i < pairs.length; i++) {
        nv = pairs[i].split("=", 2);
        n = decodeURIComponent(nv[0]);
        v = decodeURIComponent(nv[1]);

        if (!parms.hasOwnProperty(n)) parms[n] = [];
        parms[n].push(nv.length === 2 ? v : null);
    }
    return parms;
}

function getActorViewData() {
    sendRestAPIRequest(
        "GET",
        "./rest/api/actor/view/?id=" + actorId + "&token=" + getCookie("token"),
        function() {
            var response = JSON.parse(this.responseText);

            if (response.hasOwnProperty("data")) {
                if (response["data"].hasOwnProperty("img")) {
                    actorIMG.src = response["data"]["img"];
                }
                if (response["data"].hasOwnProperty("text")) {
                    actorMovieInfo.innerHTML = "";
                    for(var i = 0; i < response["data"]["text"].length; i++) {
                        var cellTitle = document.createElement("h3");
                        cellTitle.textContent = response["data"]["text"][i]["original_title"];

                        var cellText = document.createElement("p");
                        cellText.textContent = response["data"]["text"][i]["overview"];

                        actorMovieInfo.appendChild(cellTitle);
                        actorMovieInfo.appendChild(cellText);
                    }
                }
            }

            if (response.hasOwnProperty("name")) {
                actorName.textContent = response["name"];
            }

            if (response.hasOwnProperty("fav")) {
                if (addFav && removeFav) {
                    if (response["fav"]) {
                        removeFav.style.display = 'inline';
                    } else {
                        addFav.style.display = 'inline';
                    }
                }
            }

            if (response.hasOwnProperty("result")) {
                var rows = generalResultTable.getElementsByTagName("tr");
                for (var i = 1; i < rows.length;) {
                    rows[i].parentNode.removeChild(rows[i]);
                }
                for (var i = 0; i < response["result"].length; i++) {
                    var newRow = document.createElement("tr");

                    var cellYear = document.createElement("td");
                    cellYear.textContent = response["result"][i]["year_of_competition"];

                    var cellCategory = document.createElement("td");
                    cellCategory.textContent = response["result"][i]["category_name"];

                    var cellShow = document.createElement("td");
                    cellShow.textContent = response["result"][i]["show_name"];

                    var cellResult = document.createElement("td");
                    cellResult.textContent = response["result"][i]["result"];

                    newRow.appendChild(cellYear);
                    newRow.appendChild(cellCategory);
                    newRow.appendChild(cellShow);
                    newRow.appendChild(cellResult);

                    generalResultTable.appendChild(newRow);
                }
            }
        },
        null
    )
}

if (addFav && removeFav) {
    addFav.addEventListener("click", (e) => {
        e.preventDefault();
        sendRestAPIRequest(
            "POST",
            "./rest/api/actor/fav/",
            function() {
                var response = JSON.parse(this.responseText);
                if (response.hasOwnProperty("added")) {
                    addFav.style.display = 'none';
                    removeFav.style.display = 'inline';
                }
            },
            JSON.stringify({
                id:    actorId,
                token: getCookie("token")
            })
        )
    })
    removeFav.addEventListener("click", (e) => {
        e.preventDefault();
        sendRestAPIRequest(
            "DELETE",
            "./rest/api/actor/fav/",
            function() {
                var response = JSON.parse(this.responseText);
                if (response.hasOwnProperty("removed")) {
                    removeFav.style.display = 'none';
                    addFav.style.display = 'inline';
                }
            },
            JSON.stringify({
                id:    actorId,
                token: getCookie("token")
            })
        )
    })
}

getActorViewData();

document.addEventListener("DOMContentLoaded", function () {
})