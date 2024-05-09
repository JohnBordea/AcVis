const loginForm = document.getElementById("login-form");
const loginButton = document.getElementById("login-form-submit");
const loginErrorMsg = document.getElementById("login-error-msg-holder");
const loginConnectMsg = document.getElementById("login-connect-msg-holder");

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

loginButton.addEventListener("click", (e) => {
    e.preventDefault();
    const user = document.getElementById("username-field").value;
    const pwd = document.getElementById("password-field").value;
    const xhr = new XMLHttpRequest();

    xhr.open("POST", "./rest/api/login/", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    var data = JSON.stringify({
        username: user,
        password: pwd
    });

    xhr.onload = function() {
        var response = JSON.parse(xhr.responseText);
        if (xhr.status >= 200 && xhr.status < 300) {
            setCookie("token", response['token'], 10);
            setCookie("firstname", response['firstname'], 10);
            setCookie("lastname", response['lastname'], 10);
            setCookie("username", response['username'], 10);
            setCookie("email", response['email'], 10);
            setCookie("role", response['role'], 10);
            window.location.replace("admin.php");
            loginErrorMsg.style.display = "none";
        } else {
            loginErrorMsg.style.display = "initial";
            loginConnectMsg.style.display = "none";
        }
    };

    xhr.send(data);
})