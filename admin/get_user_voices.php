<?php
session_start();
require '../db_connect.php';
header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);
$userId = $data['user_id'] ?? null;
if (!$userId) {
    echo json_encode(['status'=>false,'message'=>'Invalid user']);
    exit;
}
$stmt = $pdo->prepare("SELECT * FROM tbl_user_voice WHERE user_id = ?");
$stmt->execute([$userId]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$row) {
    echo json_encode(['status'=>false,'message'=>'No voice record found']);
    exit;
}
$basePath = '../uploads/voice/';
/* filename columns */
$fileColumns = [
    'a_filename'  => 'Phonation A',
    'e_filename'  => 'Phonation E',
    'i_filename'  => 'Phonation I',
    'o_filename'  => 'Phonation O',
    'u_filename'  => 'Phonation U',
    'pa_filename' => 'Rhythm PA',
    'ta_filename' => 'Rhythm TA',
    'ka_filename' => 'Rhythm KA',
];
$voices = [];
foreach ($fileColumns as $col => $label) {
    if (!empty($row[$col])) {
        $voices[] = [
            'label' => $label,
            'file'  => $basePath . $row[$col]
        ];
    }
}
/* API response */
$api = json_decode($row['api_response'], true);
echo json_encode([
    'status' => true,
    'voices' => $voices,
    'prediction' => $api['prediction'] ?? 'Unknown',
    'confidence' => $api['confidence'] ?? 0
]);


