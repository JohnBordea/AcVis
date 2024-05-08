const registerUserButton = document.getElementById("register-new-user");
const registerForm = document.getElementById("register-new-user-form");

function fieldsValidation(form, text = "All fields are required and can't be empty") {
    var element = document.createElement("p");
    element.classList.add('error');
    element.textContent = text;
    form.insertBefore(element, form.firstChild);
}

registerUserButton.addEventListener("click", (e) => {
    e.preventDefault();
    var errorElements = document.querySelectorAll(".error");
    var successElements = document.querySelectorAll(".success");
    var firstname = registerForm.firstname.value;
    var lastname =  registerForm.lastname.value;
    var username =  registerForm.username.value;
    var email =     registerForm.email.value;
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var password =  registerForm.password.value;

    // Remove success and error messages
    errorElements.forEach(function(element) {
        element.remove();
    });
    successElements.forEach(function(element) {
        element.remove();
    });

    //Fields validation
    if (firstname === "" || lastname === "" || username === "" || email === "" || password === "") {
        fieldsValidation(registerForm);
        console.log(firstname);
        console.log(lastname);
        console.log(email);
        console.log(username);
        console.log(password);
        return false;
    }
    if(!emailRegex.test(email)) {
        fieldsValidation(registerForm, 'Invalid Email');
        return false;
    }

    //Form Submit
    const xhr = new XMLHttpRequest();

    xhr.open("POST", "./rest/api/register/", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        var response = JSON.parse(xhr.responseText);
        if (response.hasOwnProperty("exist")) {
            fieldsValidation(registerForm, response['exist'] + " already in use.")
        } else {
            fieldsValidation(registerForm, "The user has been succesfuly added.")
        }
    };

    var data = JSON.stringify({
        firstname: firstname,
        lastname:  lastname,
        username:  username,
        email:     email,
        password:  password
    });

    xhr.send(data);
});