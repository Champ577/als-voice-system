<?php
require 'db_connect.php';

$stmt = $pdo->query("SHOW TABLES");
$tables = $stmt->fetchAll();

echo "<pre>";
print_r($tables);
/* Select all users */
$stmt = $pdo->query("SELECT * FROM tbluser");
$users = $stmt->fetchAll();

echo "<h3>Users:</h3><pre>";
print_r($users);
echo "</pre>";

/* Select all users */
$stmt = $pdo->query("SELECT * FROM tbl_user_voice");
$users = $stmt->fetchAll();

echo "<h3>Users:</h3><pre>";
print_r($users);
echo "</pre>";
