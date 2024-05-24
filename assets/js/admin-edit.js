const userPageIndex = document.getElementById("user-table-page-index");
const actorPageIndex = document.getElementById("actor-table-page-index");
const sagPageIndex = document.getElementById("oscar-table-page-index");
var lastPageUser = false;
var lastPageActor = false;
var lastPageSAG = false;
var uploadPackageMaxSize = 0;
var uploadedPackage = 0;


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

//User Table Actions
function makeUserAdmin(userId) {
    sendRestAPIRequest(
        "PUT",
        "./rest/api/users/",
        function() {
            getUsersByPage();
        },
        JSON.stringify({
            user_id: userId,
            token: getCookie("token"),
            role: 'admin'
        })
    );
}

function deleteUserAdmin(userId) {
    sendRestAPIRequest(
        "DELETE",
        "./rest/api/users/",
        function() {
            getUsersByPage();
        },
        JSON.stringify({
            user_id: userId,
            token: getCookie("token")
        })
    )
}

function getUsersByPage() {
    sendRestAPIRequest(
        "GET",
        "./rest/api/users/?page=" + userPageIndex.value + "&token=" + getCookie("token"),
        function() {
            var response = JSON.parse(this.responseText);

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
                        cellIsAdmin.onclick =  function() {
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
                lastPageUser = response["last_page"];
            } else {
                lastPageUser = true;
            }
        },
        null
    );
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
    if(!lastPageUser){
        userPageIndex.value = parseInt(userPageIndex.value) + 1;
        getUsersByPage();
    }
})

//Actor Table Actions
function getActorsByPage() {
    sendRestAPIRequest(
        "GET",
        "./rest/api/actor/?page=" + actorPageIndex.value + "&token=" + getCookie("token"),
        function() {
            var response = JSON.parse(this.responseText);

            var table = document.getElementById("general-actor-table");
            var rows = table.getElementsByTagName("tr");
            for (var i = 1; i < rows.length;) {
                rows[i].parentNode.removeChild(rows[i]);
            }

            if (response.hasOwnProperty("last_page") && response.hasOwnProperty("actor")) {
                for (var i = 0; i < response["actor"].length; i++) {
                    var newRow = document.createElement("tr");

                    var cellId = document.createElement("td");
                    cellId.textContent = response["actor"][i]["id"];

                    var cellName = document.createElement("td");
                    cellName.textContent = response["actor"][i]["actor_name"];

                    var cellToEdit = document.createElement("td");
                    cellToEdit.textContent = "Edit";
                    cellToEdit.className = "edit small";
                    cellToEdit.onclick = function() {
                        editActorAdmin(this.parentNode.firstElementChild.textContent);
                    };

                    var cellToDelete = document.createElement("td");
                    cellToDelete.textContent = "Delete";
                    cellToDelete.className = "delete small";
                    cellToDelete.onclick = function() {
                        deleteActorAdmin(this.parentNode.firstElementChild.textContent);
                    };
                    newRow.appendChild(cellId);
                    newRow.appendChild(cellName);
                    newRow.appendChild(cellToEdit);
                    newRow.appendChild(cellToDelete);

                    table.appendChild(newRow);
                }
                lastPageActor = response["last_page"];
            } else {
                lastPageActor = true;
            }
        },
        null
    );
}

function editActorAdmin(actorId) {
    window.location.replace("actor.html?id=" + String(actorId));
}

function deleteActorAdmin(actorId) {
    sendRestAPIRequest(
        "DELETE",
        "./rest/api/actor/",
        function() {
            getActorsByPage();
        },
        JSON.stringify({
            actor_id: actorId,
            token: getCookie("token")
        })
    )
}

document.getElementById("button-actor-table-previous").addEventListener("click", (e) => {
    e.preventDefault();
    if(parseInt(actorPageIndex.value) > 1){
        actorPageIndex.value = parseInt(actorPageIndex.value) - 1;
        getActorsByPage();
    }
})

document.getElementById("button-actor-table-next").addEventListener("click", (e) => {
    e.preventDefault();
    if(!lastPageActor){
        actorPageIndex.value = parseInt(actorPageIndex.value) + 1;
        getActorsByPage();
    }
})

function deleteSAGAdmin(SAGId, all) {
    sendRestAPIRequest(
        "DELETE",
        "./rest/api/table/",
        function() {
            getSAGByPage();
        },
        JSON.stringify({
            sag_id: SAGId,
            all: all,
            token: getCookie("token")
        })
    )
}

//SAG Table Actions
function getSAGByPage() {
    sendRestAPIRequest(
        "GET",
        "./rest/api/table/?page=" + sagPageIndex.value + "&token=" + getCookie("token"),
        function() {
            var response = JSON.parse(this.responseText);

            var table = document.getElementById("general-sag-table");
            var rows = table.getElementsByTagName("tr");
            for (var i = 1; i < rows.length;) {
                rows[i].parentNode.removeChild(rows[i]);
            }

            if (response.hasOwnProperty("last_page") && response.hasOwnProperty("sag")) {
                for (var i = 0; i < response["sag"].length; i++) {
                    var newRow = document.createElement("tr");

                    var cellId = document.createElement("td");
                    cellId.textContent = response["sag"][i]["id"];
                    cellId.style.display = "none";

                    var cellYear = document.createElement("td");
                    cellYear.textContent = response["sag"][i]["year"];

                    var cellCategory = document.createElement("td");
                    cellCategory.textContent = response["sag"][i]["category"];

                    var cellActor = document.createElement("td");
                    cellActor.textContent = response["sag"][i]["actor"];

                    var cellShow = document.createElement("td");
                    cellShow.textContent = response["sag"][i]["show"];

                    var cellResult = document.createElement("td");
                    cellResult.textContent = response["sag"][i]["result"];

                    var cellToDelete = document.createElement("td");
                    cellToDelete.textContent = "Delete";
                    cellToDelete.className = "delete small";
                    cellToDelete.onclick = function() {
                        //console.log(this.parentNode.firstElementChild.textContent);
                        deleteSAGAdmin(this.parentNode.firstElementChild.textContent, false);
                    };
                    newRow.appendChild(cellId);
                    newRow.appendChild(cellYear);
                    newRow.appendChild(cellCategory);
                    newRow.appendChild(cellActor);
                    newRow.appendChild(cellShow);
                    newRow.appendChild(cellResult);
                    newRow.appendChild(cellToDelete);

                    table.appendChild(newRow);
                }
                lastPageSAG = response["last_page"];
            } else {
                lastPageSAG = true;
            }
        },
        null
    );
}

document.getElementById("button-oscar-table-previous").addEventListener("click", (e) => {
    e.preventDefault();
    if(parseInt(sagPageIndex.value) > 1){
        sagPageIndex.value = parseInt(sagPageIndex.value) - 1;
        getSAGByPage();
    }
})

document.getElementById("button-oscar-table-next").addEventListener("click", (e) => {
    e.preventDefault();
    if(!lastPageSAG){
        sagPageIndex.value = parseInt(sagPageIndex.value) + 1;
        getSAGByPage();
    }
})

document.getElementById("button-oscar-table-import").addEventListener("click", (e) => {
    e.preventDefault();

    var fileInput = document.getElementById('sag-file-import-index');
    if (fileInput.files.length === 0) {
        alert('Please select a file to be imported.');
        return;
    }

    var file = fileInput.files[0];
    if (!file.name.endsWith('.csv')) {
        alert('Please select a CSV file to be imported.');
        return;
    }

    var yearId = document.getElementById('sag-year-import-index').value - 1;
    var categoryId = document.getElementById('sag-category-import-index').value - 1;
    var actorId = document.getElementById('sag-actor-import-index').value - 1;
    var showId = document.getElementById('sag-show-import-index').value - 1;
    var nominalizationId = document.getElementById('sag-nominalization-import-index').value - 1;

    if (!(yearId >= 0 && yearId < 5)
    && !(categoryId >= 0 && categoryId < 5)
    && !(actorId >= 0 && actorId < 5)
    && !(showId >= 0 && showId < 5)
    && !(nominalizationId >= 0 && nominalizationId < 5)) {
        alert('Please select a valid number for column numbers imported.');
        return;
    }

    var reader = new FileReader();
    reader.onload = function(event) {
        var contents = event.target.result.split("\n");
        var csvData = [];

        var uploadAnimation = document.getElementById('progress-bar');
        uploadAnimation.style.display = "inline";

        contents.slice(1).forEach(element => {
            var elements = element.split(",");
            if(elements.length >=5) {
                var csvRow = []
                var e;
                //add Year{it should be a 4 digit number, but only the first one}
                e = elements[yearId].match(/\b\d{4}\b/g);
                csvRow.push(e ? e[0] : "1900");
                //add Category, Actor Name, Show Name
                csvRow.push(elements[categoryId]);
                csvRow.push(elements[actorId]);
                csvRow.push(elements[showId]);
                //add nominalization
                csvRow.push((elements[nominalizationId].toLowerCase() === "true" || elements[nominalizationId] === '1') ? true : false);
                csvData.push(csvRow);
            }
        });
        uploadPackageMaxSize = (csvData.length / 200) + 1;
        uploadedPackage = 0;

        //Animation
        var animation = setInterval(frame, 10);
        var width = 0;
        document.getElementById('progressing-bar').style.width = width + "%";
        function frame() {
            if (uploadedPackage >= uploadPackageMaxSize) {
                clearInterval(animation);
                document.getElementById('progressing-bar').style.width = "100%";
                document.getElementById('progress-bar-text').innerHTML = "File Uploaded";
                getSAGByPage();
            } else if (width <= (( uploadedPackage / uploadPackageMaxSize ) * 100)) {
                width++;
                document.getElementById('progressing-bar').style.width = width + "%";
            }
        }

        for (var i = 0; i < uploadPackageMaxSize; i++) {
            var data = JSON.stringify({
                csv_file: csvData.slice(i * 200, (i + 1) * 200),
                token: getCookie("token")
            });
            sendRestAPIRequest(
                'POST',
                './rest/api/table/',
                function() {
                    var response = JSON.parse(this.responseText);
                    uploadedPackage++;
                    if (this.status >= 200 && this.status < 300);
                },
                data
            )
        }
    };
    reader.readAsText(file);

})

document.getElementById("button-oscar-table-export").addEventListener("click", (e) => {
    e.preventDefault();

})

document.getElementById("button-oscar-table-delete").addEventListener("click", (e) => {
    e.preventDefault();
    deleteSAGAdmin(-1, true);
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

    if (adminProp == "menu-user") {
        getUsersByPage();
    } else if (adminProp == "menu-actor") {
        getActorsByPage();
    } else if (adminProp == "menu-oscar") {
        getSAGByPage();
    }
}

document.getElementById("defaultOpen").click();

document.addEventListener("DOMContentLoaded", function () {
    userPageIndex.value = 1;
    actorPageIndex.value = 1;
    sagPageIndex.value = 1;
})