const restorePassword = document.getElementById("restore-user-password");
const restoredPassword = document.getElementById("user-password-restored");
const errorLabel = document.getElementById("restore-error");

async function sendRestAPIRequest(operation, url, onloadFunction, jsonData) {
    const xhr = new XMLHttpRequest();
    xhr.open(operation, url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = onloadFunction;
    xhr.send(jsonData);
}

document.getElementById("register-new-user").addEventListener("click", (e) => {
    e.preventDefault();
    var username = document.getElementById("username-field").value;
    var password = document.getElementById("password-field").value;
    var passwordRepeat = document.getElementById("password-repeat-field").value;

    errorLabel.style.display = "none";

    if (username === "" || password === "" || passwordRepeat === "") {
        errorLabel.style.display = "inline";
        errorLabel.textContent = "All fields must be filed."
        return;
    }

    if (password !== passwordRepeat) {
        errorLabel.style.display = "inline";
        errorLabel.textContent = "Passwords must be the same.";
        return;
    }

    sendRestAPIRequest(
        "PUT",
        "./rest/api/users/",
        function() {
            var response = JSON.parse(this.responseText);
            if (response.hasOwnProperty("missing")) {
                errorLabel.style.display = "inline";
                errorLabel.textContent = response["missing"];
                return;
            }

            if (response.hasOwnProperty("result")) {
                restorePassword.style.display = "none";
                restoredPassword.style.display = "inline";
            }
        },
        JSON.stringify({
            username: username,
            password: password
        })
    )
})

document.addEventListener('DOMContentLoaded', function() {
    errorLabel.style.display = "none";
    restorePassword.style.display = "inline";
    restoredPassword.style.display = "none";
})