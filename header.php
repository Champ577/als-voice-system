<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = !empty($_SESSION['candidate']);
$currentPage = basename($_SERVER['PHP_SELF']);
$isIndex = ($currentPage === 'index.php');
$base = $isIndex ? '' : './';
?>

<header class="main-header">
    <div class="header-left">
        <!-- Menu Toggle (Mobile) -->
        <button class="menu-toggle" onclick="toggleMenu()">
            <i class="fas fa-bars"></i>
        </button>
        <!-- Logo -->
        <a class="app-logo" href="./">
            <i class="fas fa-microphone-lines"></i>

            <span class="logo-text">
                <span class="logo-title">ALL ALS</span>
                <span class="logo-subtitle">
                    Indian Voice Dataset Initiative for Neurodegenerative Research
                </span>
            </span>
        </a>
    </div>

    <!-- Right Side -->
    <div class="header-right">
        <!-- Main Navigation -->
        <div class="mainNav">
            <div class="header-mobile">
                <!-- Menu Toggle (Mobile) -->
                <button class="menu-toggle" onclick="toggleMenu()">
                    <i class="fas fa-times"></i>
                </button>
                <!-- Logo -->
                <a class="app-logo" href="./">
                    <i class="fas fa-microphone-lines"></i>

                    <span class="logo-text">
                        <span class="logo-title">ALL ALS</span>
                        <span class="logo-subtitle">
                            Indian Voice Dataset Initiative for Neurodegenerative Research
                        </span>
                    </span>
                </a>
            </div>
            <nav class="main-nav">
                <a href="<?= $base ?>#home"
                   class="<?= $currentPage === 'about.php' ? 'active' : '' ?>">
                    Home
                </a>

                
                <a href="<?= $base ?>#about"
                   class="<?= $currentPage === 'about.php' ? 'active' : '' ?>">
                    About
                </a>

                <a href="<?= $base ?>#mnd"
                   class="<?= $currentPage === 'about.php' ? 'active' : '' ?>">
                    What is MND?
                </a>

                <a href="<?= $base ?>#contact"
                   class="<?= $currentPage === 'contact.php' ? 'active' : '' ?>">
                    Contact
                </a>

                <?php if ($isLoggedIn): ?>
                    <a href="record.php"
                       class="<?= $currentPage === 'record.php' ? 'active' : '' ?>">
                        Record
                    </a>
                <?php endif; ?>
            </nav>
            <!-- User -->
            <?php if (!$isLoggedIn): ?>
            <button id="headerLoginBtn" class="header-login-btn" onclick="openAuthModal('login')"> Login </button>
            <?php else: ?>
            <div class="userInfo">
                <div class="user-dropdown-header">
                    <div class="user-avatar-lg">
                        <?= strtoupper(substr($_SESSION['candidate']['name'], 0, 1)); ?>
                    </div>
                    <div class="user-info">
                        <div class="user-fullname">
                            <?= htmlspecialchars($_SESSION['candidate']['name']); ?>
                        </div>
                        <div class="user-email">
                            <?= htmlspecialchars($_SESSION['candidate']['email']); ?>
                        </div>
                    </div>
                </div>
                <div class="user-footer">
                    <button class="logout-btn" onclick="handleLogout()">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </button>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php if ($isLoggedIn): ?>
            <div class="user-menu">
                <button class="user-trigger" onclick="toggleUserMenu(event)">
                    <span class="user-avatar">
                        <?= strtoupper(substr($_SESSION['candidate']['name'], 0, 1)); ?>
                    </span>
                </button>

                <div class="user-dropdown" id="userDropdown">
                    <div class="user-dropdown-header">
                        <div class="user-avatar-lg">
                            <?= strtoupper(substr($_SESSION['candidate']['name'], 0, 1)); ?>
                        </div>
                        <div class="user-info">
                            <div class="user-fullname">
                                <?= htmlspecialchars($_SESSION['candidate']['name']); ?>
                            </div>
                            <div class="user-email">
                                <?= htmlspecialchars($_SESSION['candidate']['email']); ?>
                            </div>
                        </div>
                    </div>

                    <div class="user-dropdown-footer">
                        <button class="logout-btn" onclick="handleLogout()">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</header>
