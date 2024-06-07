document.addEventListener("DOMContentLoaded", function() {
    var form = document.getElementById(".login-form");
    var errorMessage = document.getElementById("error-message");

    form.addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent form submission
        errorMessage.innerText = ""; // Clear previous error message

        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;
        var user = document.getElementById("user").value;

        // Validate email and password
        if (!email || !password) {
            errorMessage.innerText = "Email and password are required.";
            return;
        }

        // Disable form to prevent multiple submissions
        var elements = form.elements;
        for (var i = 0, len = elements.length; i < len; ++i) {
            elements[i].disabled = true;
        }

        // Send AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "loginuser.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                // Enable form after response is received
                for (var i = 0, len = elements.length; i < len; ++i) {
                    elements[i].disabled = false;
                }
                
                if (xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Login successful, redirect to dashboard
                        window.location.href = "dashboard.php";
                    } else {
                        // Login failed, display error message
                        errorMessage.innerText = response.message;
                    }
                } else {
                    // Error occurred, display error message
                    errorMessage.innerText = "An error occurred. Please try again later.";
                }
            }
        };
        xhr.send("email=" + encodeURIComponent(email) + "&password=" + encodeURIComponent(password) + "&user=" + encodeURIComponent(user));
    });
});