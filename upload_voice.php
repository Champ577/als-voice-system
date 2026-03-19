<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['candidate']['id'])) {
    echo json_encode(['status'=>false,'message'=>'Session expired']);
    exit;
}

$userId = (int) $_SESSION['candidate']['id'];
$age    = $_POST['age'] ?? null;
$sex   = $_POST['sex_m'] ?? null;

if (!$age || !is_numeric($sex)) {
    echo json_encode(['status'=>false,'message'=>'Age and Sex required']);
    exit;
}

$uploadDir   = __DIR__ . '/uploads/voice/';
$allowedExt  = ['wav','webm'];
$allowedMime = [
  'audio/wav',
  'audio/x-wav',
  'audio/webm',
  'video/webm'
];
$maxSize     = 20 * 1024 * 1024;

$fileMap = [
    'fileA'  => 'a_filename',
    'fileE'  => 'e_filename',
    'fileI'  => 'i_filename',
    'fileO'  => 'o_filename',
    'fileU'  => 'u_filename',
    'filePA' => 'pa_filename',
    'fileTA' => 'ta_filename',
    'fileKA' => 'ka_filename'
];

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 777, true);
}

require 'db_connect.php';

/* ensure user row exists */
$stmt = $pdo->prepare("SELECT id FROM tbl_user_voice WHERE user_id=?");
$stmt->execute([$userId]);
if (!$stmt->fetch()) {
    $pdo->prepare("INSERT INTO tbl_user_voice(user_id) VALUES(?)")
        ->execute([$userId]);
}

$updates   = [];
$params    = [];
$curlFiles = [];

foreach ($fileMap as $input => $dbCol) {

    if (
        !isset($_FILES[$input]) ||
        $_FILES[$input]['error'] !== UPLOAD_ERR_OK
    ) {
        continue;
    }

    $file = $_FILES[$input];
    /* size check */
    if ($file['size'] > $maxSize) {
        echo json_encode(['status'=>false,'message'=>"$input exceeds 20MB"]);
        exit;
    }

    /* extension check */
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExt)) {
        echo json_encode(['status'=>false,'message'=>"$input must be WAV"]);
        exit;
    }

    /* mime check */
    $mime = mime_content_type($file['tmp_name']);
    if (!in_array($mime, $allowedMime)) {
        echo json_encode(['status'=>false,'message'=>"$input invalid audio"]);
        exit;
    }

    /* SAVE FILE LOCALLY */
    $storedName = $dbCol . '_' . $userId . '_' . time() . '.wav';
    $storedPath = $uploadDir . $storedName;

    if (!move_uploaded_file($file['tmp_name'], $storedPath)) {
        echo json_encode(['status'=>false,'message'=>"Upload failed $input"]);
        exit;
    }

    /* DB update prep */
    $updates[] = "$dbCol=?";
    $params[]  = $storedName;

    /* 🔥 API ke liye SAME local file */
    $curlFiles[$input] = new CURLFile(
        $storedPath,
        'audio/wav',
        $storedName
    );
}

/* 🔥 External API CALL */
$curl = curl_init();

$postData = array_merge($curlFiles, [
    'age'    => $age,
    'sex_m' => $sex
]);

curl_setopt_array($curl, [
    CURLOPT_URL            => 'https://ai-python-npd.thinkexam.com/alshome/predict',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $postData
]);


$apiResponse = curl_exec($curl);
// print_r($apiResponse); die;

if ($apiResponse === false) {
    echo json_encode([
        'status'=>false,
        'message'=>'API Error: '.curl_error($curl)
    ]);
    exit;
}

curl_close($curl);

/* 🔥 UPDATE DB (FILES + API RESPONSE) */
if ($updates) {
    $updates[] = "api_response=?";
    $params[]  = $apiResponse;
    $params[]  = $userId;

    $sql = "UPDATE tbl_user_voice SET ".implode(',', $updates)." WHERE user_id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
}

echo json_encode([
    'status'   => true,
    'message'  => 'Voice files saved successfully',
    'redirect' => 'record.php'
]);
exit;
