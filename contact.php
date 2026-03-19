<?php
session_start();
header('Content-Type: application/json');
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status'=>false,'message'=>'Invalid request method']);
    exit;
}
function clean($value) {
    return trim(htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
}

$name     = clean($_POST['name'] ?? '');
$email    = clean($_POST['email'] ?? '');
$mobile    = clean($_POST['mobile'] ?? ''); 
$message     = clean($_POST['message'] ?? '');
// VALIDATIONS
if ($name === '') exit(json_encode(['status'=>false,'field'=>'name','message'=>'Name is required']));
if (!preg_match('/^\d{10}$/', $mobile)) exit(json_encode(['status'=>false,'field'=>'mobile','message'=>'Phone must be 10 digits']));
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) exit(json_encode(['status'=>false,'field'=>'email','message'=>'Invalid email']));
if ($message === '') exit(json_encode(['status'=>false,'field'=>'message','message'=>'message required']));
if (str_word_count($message) > 100) exit(json_encode(['status'=>false,'field'=>'message','message'=>'Max 100 words']));
try { 
    $stmt = $pdo->prepare("
        INSERT INTO tblcontactus (fldname, fldcontactno, fldemail, fldMessage)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([$name,$mobile,$email,$message]);
    $userId = $pdo->lastInsertId();
    echo json_encode([
        'status'   => true,
        'message'  => 'Thank you for contacting us. We will get back to you shortly.',
    ]);
    exit;
} catch (PDOException $e) {
    echo json_encode(['status'=>false,'message'=>'Contact us failed']);
}
