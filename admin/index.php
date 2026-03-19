
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
<div class="admin-wrapper">
    <div class="auth-card">
            
            <!-- Login Form -->
            <form id="login-form" class="login-form">
                <h2>Admin Login</h2>
                
                <div class="form-group">
                    <label for="log_userid">Email ID<span class="mandatory">*</span></label>
                    <input type="text" id="log_userid" name="userid" placeholder="Enter your Email ID">
                    <small class="error-msg" id="error_log_userid"></small>
                </div>

                <div class="form-group">
                    <label for="log_pass">Password<span class="mandatory">*</span></label>
                    <input type="password" id="log_pass" name="password" placeholder="Enter Password">
                    <small class="error-msg" id="error_log_pass"></small>
                </div>

                <button type="submit" class="btn-submit">LOGIN</button>
                
            </form>
        </div>
</div>
<div class="loader-overlay" id="ajaxLoader">
        <div class="loader"></div>
        <div class="loader-text">Loading...</div>
    </div>
<!-- Toaster Container -->
<div id="toast-container"></div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="assets/js/admin.js"></script>
<script>
    window.onload = function () {
        document.getElementById("ajaxLoader").style.display = "none";
    };
</script>
</body>
</html>
