<?php   
require 'admin.php'; 
require 'admin_auth.php';    
?>
<header class="top-header">

  <!-- LEFT -->
  <div class="header-left">
    <button class="menu-btn" onclick="toggleSidebar()">
      <i class="fas fa-bars"></i>
    </button>

    <div class="header-title">
      <!-- <i class="fas fa-microphone-lines"></i> -->
      <span>Admin</span>
    </div>
  </div>

  <!-- RIGHT -->
  <div class="user-menu">
    <div class="user-icon" onclick="toggleUserMenu()">
      <i class="fas fa-user"></i>
    </div>

    <div class="user-dropdown" id="userDropdown">
      <a href="#" onclick="event.preventDefault(); window.location.href='admin_logout.php';" >
        <i class="fas fa-sign-out-alt"></i> Logout
      </a>
    </div>
  </div>

</header>
