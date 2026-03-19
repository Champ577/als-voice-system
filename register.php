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
$phone    = clean($_POST['phone'] ?? '');
$age      = clean($_POST['age'] ?? '');
$password = $_POST['password'] ?? '';
$confirm  = $_POST['confirm_password'] ?? '';
$disease  = $_POST['disease'] ?? 'no';
$gender   = clean($_POST['gender'] ?? '');
$diagnosis_status   = clean($_POST['diagnosis_status'] ?? '');
$year_of_diagnosed   = clean($_POST['year_of_diagnosed'] ?? '');
$hospita_doctor_name   = clean($_POST['hospita_doctor_name'] ?? '');
$type_of_mnd   = clean($_POST['type_of_mnd'] ?? '');

$desc     = clean($_POST['disease_desc'] ?? '');

// VALIDATIONS
if ($name === '') exit(json_encode(['status'=>false,'field'=>'reg_name','message'=>'Name is required']));
// if ($hospita_doctor_name === '') exit(json_encode(['status'=>false,'field'=>'reg_hospita_doctor_name','message'=>'hospita/doctor name is required']));
// if ($type_of_mnd === '') exit(json_encode(['status'=>false,'field'=>'reg_type_of_mnd','message'=>'Type of MND is required']));

if ($age === '') exit(json_encode(['status'=>false,'field'=>'reg_age','message'=>'Age is required']));
// if ($year_of_diagnosed === '') exit(json_encode(['status'=>false,'field'=>'reg_year_of_diagnosed','message'=>'Year of diagnosed is required']));
if ($gender === '') exit(json_encode(['status'=>false,'field'=>'reg_gender','message'=>'Gender is required']));
if (!preg_match('/^\d{10}$/', $phone)) exit(json_encode(['status'=>false,'field'=>'reg_phone','message'=>'Phone must be 10 digits']));
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) exit(json_encode(['status'=>false,'field'=>'reg_email','message'=>'Invalid email']));
if (strlen($password) < 6) exit(json_encode(['status'=>false,'field'=>'reg_pass','message'=>'Password too short']));
if ($password !== $confirm) exit(json_encode(['status'=>false,'field'=>'reg_confirm','message'=>'Passwords do not match']));

if ($disease === 'yes') {
    if ($desc === '') exit(json_encode(['status'=>false,'field'=>'disease_desc','message'=>'Description required']));
    if (str_word_count($desc) > 100) exit(json_encode(['status'=>false,'field'=>'disease_desc','message'=>'Max 100 words']));
    if ($diagnosis_status === '') exit(json_encode(['status'=>false,'field'=>'reg_diagnosis_status','message'=>'Diagnosis status is required']));
}

try {
    // DUPLICATE CHECK
    $check = $pdo->prepare("SELECT id FROM tbluser WHERE email=?");
    $check->execute([$email]);
    if ($check->rowCount() > 0) {
        echo json_encode(['status'=>false,'message'=>'Email already registered']);
        exit;
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("
        INSERT INTO tbluser (name, phone_no, email, age, gender, password, diseases, diseases_desc,fldDiagnosisStatus,fldDiagnosisYear,fldDiagnosisPlace,fldDiagnosisType)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?)
    ");
    $stmt->execute([$name,$phone,$email,$age,$gender,$passwordHash,$disease,$desc,$diagnosis_status,$year_of_diagnosed,$hospita_doctor_name,$type_of_mnd]);

    $userId = $pdo->lastInsertId();

    $stmt = $pdo->prepare("SELECT * FROM tbluser WHERE id=?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    session_regenerate_id(true);     
    $redirect = (int)$user['type'];
     $_SESSION['candidate'] = [
        'id'     => $user['id'],
        'name'   => $user['name'],
        'email'  => $user['email'],
        'age'    => $user['age'],
        'gender' => $user['gender'],
        'type'   => 0
    ];
    echo json_encode([
        'status'   => true,
        'message'  => 'Registration successful',
        'redirect' => $redirect
    ]);
    exit;
} catch (PDOException $e) {
    echo json_encode(['status'=>false,'message'=>'Registration failed']);
}
