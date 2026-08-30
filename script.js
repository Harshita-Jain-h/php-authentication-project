// Registration form validation
const registerForm = document.getElementById("registerForm");

if (registerForm) {

    registerForm.addEventListener("submit", function (event) {

        const name = document.getElementById("name").value.trim();
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value;
        const confirmPassword =
            document.getElementById("confirm_password").value;

        if (name.length < 2) {
            alert("Name must contain at least 2 characters.");
            event.preventDefault();
            return;
        }

        if (password.length < 6) {
            alert("Password must be at least 6 characters.");
            event.preventDefault();
            return;
        }

        if (password !== confirmPassword) {
            alert("Passwords do not match.");
            event.preventDefault();
            return;
        }
    });
}


// Login form validation
const loginForm = document.getElementById("loginForm");

if (loginForm) {

    loginForm.addEventListener("submit", function (event) {

        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value;

        if (email === "") {
            alert("Please enter your email.");
            event.preventDefault();
            return;
        }

        if (password === "") {
            alert("Please enter your password.");
            event.preventDefault();
        }
    });
}


// Show / hide password
const toggleButtons = document.querySelectorAll(".toggle-password");

toggleButtons.forEach(function (button) {

    button.addEventListener("click", function () {

        const inputId = button.getAttribute("data-target");
        const passwordInput = document.getElementById(inputId);

        if (passwordInput.type === "password") {

            passwordInput.type = "text";
            button.textContent = "Hide";

        } else {

            passwordInput.type = "password";
            button.textContent = "Show";
        }
    });
});
