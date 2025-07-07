<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reservo</title>
    <link rel="stylesheet" href="login.css" />
    <link
      href="https://fonts.googleapis.com/css?family=Oswald"
      rel="stylesheet"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Agdasima:wght@400;700&family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&family=Oswald:wght@200..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
      rel="stylesheet"
    />
    <script
      src="https://kit.fontawesome.com/e4580308de.js"
      crossorigin="anonymous"
    ></script>
    <link rel="icon" href="./images/favicon.png" type="image/x-icon" />
    <script defer>
      document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("loginForm");
        const errorMessage = document.getElementById("errorMessage");

        form.addEventListener("submit", async (e) => {
    e.preventDefault();
    errorMessage.textContent = ""; // Clear previous messages

    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value.trim();

    try {
        const response = await fetch("../restapi/api.php?table=login", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            credentials: "include",
            body: JSON.stringify({ username, password }),
        });

        // Check for response status
        if (!response.ok) {
            const errorText = `Error: ${response.status} ${response.statusText}`; // Capture error status and message
            errorMessage.textContent = errorText; // Display the error
            console.error(errorText); // Log the error in console
            return; // Exit if there's an error
        }

        const result = await response.json();

        // Successfully logged in
        localStorage.setItem("csrf_token", result.csrf_token);
        window.location.href = "http://localhost/ids%20Internship/Reservo/Home_Page/HomePage.php";
    } catch (error) {
        // Display any unexpected errors
        errorMessage.textContent = `Unexpected error: ${error.message}`;
        console.error("Error:", error);
    }
});
      });
    </script>
  </head>
  <body>
    <div class="Components_Box">
      <div id="Back_Logo">
        <img src="../images/LOGO.png" alt="Logo" />
      </div>
      <div class="container" id="container">
        <div class="form-container sign-in">
          <form id="loginForm">
            <h1>Sign In</h1>
            <span> use your username & password</span>
            <input type="text" id="username" placeholder="Username" required />
            <input type="password" id="password" placeholder="Password" required />
            <p class="error-message" id="errorMessage"></p>
            <button type="submit">Sign In</button>
          </form>
        </div>
        <div class="toggle-container">
          <div class="toggle">
            <div class="toggle-panel toggle-right">
              <h1>Welcome Back!</h1>
              <p>Enter your personal details to use all of site features</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
