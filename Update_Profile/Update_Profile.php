<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) 
{
    header("Location:../Login Page/login.php"); // Redirect to login page
    exit; // Stop further execution
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Update Profile - Reservo</title>
    <link rel="icon" href="../images/Favicon.png" type="image/x-icon" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />

    <!-- Optional CSS (custom styling) -->
    <link rel="stylesheet" href="./Update_Profile.css" />
  </head>
  <body>
    <div class="container-xl px-4 mt-4">
      <!-- Logo -->
      <div class="Logo text-center mb-4">
        <img src="../images/LOGO.png" alt="Logo" />
      </div>

      <hr class="mt-0 mb-4" />

      <div class="row justify-content-center">
        <div class="col-xl-6">
          <!-- Account details card -->
          <div class="card mb-4">
            <div class="card-header">Update Profile</div>
            <div class="card-body">
              <form id="updateProfileForm">
                <!-- Username -->
                <div class="mb-3">
                  <label class="small mb-1" for="username">Username</label>
                  <input
                    class="form-control"
                    id="username"
                    type="text"
                    placeholder="Enter your username"
                    required
                  />
                </div>

                <!-- Change password -->
                <div class="mb-3">
                  <label class="small mb-1" for="currentPassword">Current Password</label>
                  <input
                    class="form-control"
                    id="currentPassword"
                    type="password"
                    placeholder="Enter current password"
                    required
                  />
                </div>

                <div class="mb-3">
                  <label class="small mb-1" for="newPassword">New Password</label>
                  <input
                    class="form-control"
                    id="newPassword"
                    type="password"
                    placeholder="Enter new password"
                    required
                  />
                </div>

                <div class="mb-3">
                  <label class="small mb-1" for="confirmPassword">Confirm New Password</label>
                  <input
                    class="form-control"
                    id="confirmPassword"
                    type="password"
                    placeholder="Confirm new password"
                    required
                  />
                </div>

                <!-- Error Message Display -->
                <p class="text-danger" id="errorMessage" style="display: none;"></p>
                <p class="text-success" id="successMessage" style="display: none;"></p>

                <!-- Save button -->
                <button class="btn btn-primary" type="submit">Save Changes</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- JS Logic -->
    <script>
      document.getElementById("updateProfileForm").addEventListener("submit", async (e) => {
        e.preventDefault();
        const username = document.getElementById("username").value.trim();
        const currentPassword = document.getElementById("currentPassword").value.trim();
        const newPassword = document.getElementById("newPassword").value.trim();
        const confirmPassword = document.getElementById("confirmPassword").value.trim();
        const errorMessage = document.getElementById("errorMessage");
        const successMessage = document.getElementById("successMessage");

        errorMessage.style.display = "none";
        successMessage.style.display = "none";

        if (newPassword !== confirmPassword) {
          errorMessage.textContent = "New passwords do not match.";
          errorMessage.style.display = "block";
          return;
        }

        try {
          const csrfToken = localStorage.getItem("csrf_token");

          const response = await fetch("../restapi/api.php?table=users", {
            method: "PUT",
            headers: {
              "Content-Type": "application/json",
              "X-CSRF-Token": csrfToken,
            },
            credentials: "include",
            body: JSON.stringify({
              username: username,
              password: newPassword,
              currentPassword: currentPassword, // for backend to verify
        
            }),
          });

          const data = await response.json();

          if (response.ok) {
            successMessage.textContent = "Profile updated successfully.";
            successMessage.style.display = "block";
          } else {
            errorMessage.textContent = data.error || "Update failed.";
            errorMessage.style.display = "block";
          }
        } catch (err) {
          errorMessage.textContent = "Error updating profile.";
          errorMessage.style.display = "block";
        }
      });
    </script>
  </body>
</html>
