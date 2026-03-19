<?php
session_start();
if (!isset($_SESSION['candidate'])) {
    header("Location: index.php");
    exit;
}
