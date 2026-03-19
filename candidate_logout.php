<?php
session_start();
unset($_SESSION['candidate']);
header("Location: index.php");
exit;
