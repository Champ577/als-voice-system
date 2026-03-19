<?php
// login.php
session_start();
require 'db_connect.php';
header('Content-Type: application/json');
/* =====================
   1. METHOD CHECK
===================== */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'status' => false,
        'message' => 'Invalid request method'
    ]);
    exit;
}
/* =====================
   2. INPUT CLEANING
===================== */
function clean($value) {
    return trim(htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
}
$userid   = isset($_POST['userid']) ? clean($_POST['userid']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
if ($userid === '') {
    echo json_encode([
        'status' => false,
        'field'  => 'log_userid',
        'message'=> 'User ID is required'
    ]);
    exit;
}
if ($password === '') {
    echo json_encode([
        'status' => false,
        'field'  => 'log_pass',
        'message'=> 'Password is required'
    ]);
    exit;
}
/* =====================
   3. FETCH USER
===================== */
$sql = "SELECT id, name, email, password, type, age, gender 
        FROM tbluser 
        WHERE email = ? 
        LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([$userid]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    echo json_encode([
        'status' => false,
        'message'=> 'Invalid User ID or Password'
    ]);
    exit;
}
/* =====================
   4. PASSWORD VERIFY
===================== */
if (!password_verify($password, $user['password'])) {
    echo json_encode([
        'status' => false,
        'message'=> 'Invalid User ID or Password'
    ]);
    exit;
}
/* =====================
   5. CREATE SESSION
===================== */

if ((int)$user['type'] === 1) {
    // ADMIN SESSION
    $_SESSION['admin'] = [
        'id'     => $user['id'],
        'name'   => $user['name'],
        'email'  => $user['email'],
        'age'    => $user['age'],
        'gender' => $user['gender'],
        'type'   => 1
    ];
} else {
    // CANDIDATE SESSION
    $_SESSION['candidate'] = [
        'id'     => $user['id'],
        'name'   => $user['name'],
        'email'  => $user['email'],
        'age'    => $user['age'],
        'gender' => $user['gender'],
        'type'   => 0
    ];
}

/* =====================
   6. SUCCESS RESPONSE
===================== */
$redirect = (int)$user['type'];
echo json_encode([
    'status'   => true,
    'message'  => 'Login successful',
    'redirect' => $redirect,
    'data'     => [
        'id'    => $user['id'],
        'name'  => $user['name'],
        'email' => $user['email'],
        'type'  => $user['type']
    ]
]);

