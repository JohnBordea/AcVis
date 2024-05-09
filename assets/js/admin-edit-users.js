const userPageIndex = document.getElementById("user-table-page-index");
var lastPage = false;

function getUsersByPage() {
    const xhr = new XMLHttpRequest();

    var url = "./rest/api/users/?page=" + userPageIndex.value + "&token=";

    xhr.open("GET", url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        var response = JSON.parse(xhr.responseText);
        
        
        console.log(response);
    };

    xhr.send(null);
}

document.getElementById("button-user-table-previous").addEventListener("click", (e) => {
    e.preventDefault();
    if(parseInt(userPageIndex.value) > 1)
        userPageIndex.value = parseInt(userPageIndex.value) - 1;
})

document.getElementById("button-user-table-next").addEventListener("click", (e) => {
    e.preventDefault();
    if(!lastPage)
        userPageIndex.value = parseInt(userPageIndex.value) + 1;
})

document.addEventListener("DOMContentLoaded", function () {
    userPageIndex.value = 1;
})