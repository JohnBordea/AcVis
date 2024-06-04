const actorSelect = document.getElementById("entry-actor");
const actorChart =  document.getElementById("actor-chart");
const viewActor = document.getElementById("view-actor");
var actorList;
var chart;

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

function getActors() {
    sendRestAPIRequest(
        "GET",
        "./rest/api/actor/?token=" + getCookie("token"),
        function() {
            var response = JSON.parse(this.responseText);
            if (response.hasOwnProperty("actor")) {
                actorList = response["actor"];
                actorSelect.innerHTML = "";
                for(let i = 0; i < actorList.length; i++) {
                    var option = document.createElement("option");
                    option.text = actorList[i]["actor_name"];
                    option.value = actorList[i]['id'];
                    actorSelect.add(option);
                }
                actorSelect.selectedIndex = 0;
                getActorChartData();
            }
        },
        null
    )
}

function getActorChartData() {
    sendRestAPIRequest(
        "GET",
        "./rest/api/actor/stat/?id=" + actorSelect.value,
        function() {
            var response = JSON.parse(this.responseText);

            var xValues = [];
            if (response.hasOwnProperty("years")) {
                xValues = response["years"];
            }
            var totalValues = [];
            if (response.hasOwnProperty("total")) {
                totalValues = response["total"];
            }
            var winValues = [];
            if (response.hasOwnProperty("wins")) {
                winValues = response["wins"];
            }

            if(chart) {
                chart.destroy();
            }

            chart = new Chart("actor-chart", {
                type: "bar",
                data: {
                    labels: xValues,
                    datasets: [{
                        backgroundColor: "rgba(0,0,255,1.0)",
                        borderColor: "rgba(0,0,255,0.1)",
                        data: totalValues,
                        label: "Nominalizari"
                    },{
                        backgroundColor: "green",
                        borderColor: "green",
                        data: winValues,
                        label: "Victorii"
                    }]
                },
                responsive: true,
                options: {
                    legend: {display: false},
                    scales: {
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true
                        },
                        yAxes: [{
                            ticks: {
                                min: 0
                            }
                        }],
                    }
                }
            });

            getActorYearStat(chart.data.labels[0]);
        },
        null
    )
}

actorSelect.addEventListener("change", function() {
    getActorChartData();
})

function getActorYearStat(year) {
    sendRestAPIRequest(
        "GET",
        "./rest/api/actor/stat/?id=" + actorSelect.value + "&year=" + year,
        function() {
            var response = JSON.parse(this.responseText);

            if (response.hasOwnProperty("stat")) {
                var table = document.getElementById("general-result-table");
                var rows = table.getElementsByTagName("tr");
                for (var i = 1; i < rows.length;) {
                    rows[i].parentNode.removeChild(rows[i]);
                }

                for (var i = 0; i < response["stat"].length; i++) {
                    var newRow = document.createElement("tr");

                    var cellCategory = document.createElement("td");
                    cellCategory.textContent = response["stat"][i]["category_name"];

                    var cellShow = document.createElement("td");
                    cellShow.textContent = response["stat"][i]["show_name"];

                    var cellResult = document.createElement("td");
                    cellResult.textContent = response["stat"][i]["result"];

                    newRow.appendChild(cellCategory);
                    newRow.appendChild(cellShow);
                    newRow.appendChild(cellResult);

                    table.appendChild(newRow);
                }
            }
        },
        null
    )
}

actorChart.onclick = function (evt) {
    const points = chart.getElementsAtEventForMode(evt, 'nearest', { intersect: true }, true);

    if (points.length) {
        getActorYearStat(chart.data.labels[points[0]._index]);
    }
};

viewActor.onclick = function (evt) {
    window.location.href = "actor.php?id=" + actorSelect.value;
}

document.getElementById("view-actor-data-img").addEventListener("click", function() {
    console.log(100);
    var a = document.createElement('a');
    a.href = chart.toBase64Image();
    a.download = 'my_file_name.png';

    a.click();
})

document.addEventListener("DOMContentLoaded", function () {
    getActors();
})