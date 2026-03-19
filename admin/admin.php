<?php
require '../db_connect.php'; 

//tables
$stmt = $pdo->query("SHOW TABLES");
$tables = $stmt->fetchAll(); 

//Users
$stmt = $pdo->prepare("SELECT id,name,phone_no,email,age,diseases,diseases_desc,created_at,CASE WHEN gender = 1 THEN 'Male' ELSE 'Female'   END AS gender,fldDiagnosisStatus,fldDiagnosisYear,fldDiagnosisPlace,fldDiagnosisType FROM tbluser WHERE type = ?");
$stmt->execute([0]);
$users = $stmt->fetchAll();

//user count
$stmt = $pdo->prepare("SELECT COUNT(*) FROM tbluser WHERE type = ?");
$stmt->execute([0]);
$userCount = $stmt->fetchColumn();

//user voice file count
$stmt = $pdo->prepare("SELECT COUNT(*) FROM tbl_user_voice");
$stmt->execute();
$voiceCount = $stmt->fetchColumn();

//user voice files
$stmt = $pdo->prepare("SELECT * FROM tbl_user_voice  where user_id = ?");
$stmt->execute([$id]);
$voiceFiles = $stmt->fetchAll();

//contact-us users
$stmt = $pdo->prepare("SELECT * FROM tblContactUs");
$stmt->execute();
$contactUsers = $stmt->fetchAll();

?>

 