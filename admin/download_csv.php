<?php
require '../db_connect.php';

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=userVoices_detailed.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border='1' style='border-collapse:collapse;'>";

/* =========================
   TABLE HEADER
========================= */
echo "
<tr bgcolor='#003d80' style='color:#ffffff;font-weight:bold;text-align:center;'>
    <th>Sr. No.</th>
    <th>Name</th>
    <th>Phone</th>
    <th>Email</th>
    <th>Gender</th>
    <th>Age</th>
    <th>Diseases</th>
    <th>Description</th>
    <th>Diag. Status</th>
    <th>Diag. Year</th>
    <th>Diag. Place</th>
    <th>Diag. Type</th>
    <th>Prediction</th>
    <th>Confidence</th>

    <th>A_meanF0</th><th>A_stdevF0</th><th>A_HNR</th><th>A_jitter</th><th>A_shimmer</th>
    <th>E_meanF0</th><th>E_stdevF0</th><th>E_HNR</th><th>E_jitter</th><th>E_shimmer</th>
    <th>I_meanF0</th><th>I_stdevF0</th><th>I_HNR</th><th>I_jitter</th><th>I_shimmer</th>
    <th>O_meanF0</th><th>O_stdevF0</th><th>O_HNR</th><th>O_jitter</th><th>O_shimmer</th>
    <th>U_meanF0</th><th>U_stdevF0</th><th>U_HNR</th><th>U_jitter</th><th>U_shimmer</th>

    <th>PA_meanF0</th><th>PA_stdevF0</th><th>PA_HNR</th><th>PA_jitter</th><th>PA_shimmer</th>
    <th>TA_meanF0</th><th>TA_stdevF0</th><th>TA_HNR</th><th>TA_jitter</th><th>TA_shimmer</th>
    <th>KA_meanF0</th><th>KA_stdevF0</th><th>KA_HNR</th><th>KA_jitter</th><th>KA_shimmer</th>

    <th>Created At</th>
</tr>
";

/* =========================
   FETCH DATA
========================= */
$stmt = $pdo->prepare("
    SELECT 
        u.name,
        u.phone_no,
        u.email,
        u.age,
        u.diseases_desc,
        v.api_response,
        CASE 
            WHEN u.diseases = 'no' OR u.diseases = '' OR u.diseases IS NULL 
                THEN 'No'
            ELSE 'Yes'
        END AS diseases,
        CASE 
            WHEN u.gender = 1 THEN 'Male' 
            ELSE 'Female' 
        END AS gender,
        u.created_at,
        u.fldDiagnosisStatus,
        u.fldDiagnosisYear,
        u.fldDiagnosisPlace,
        u.fldDiagnosisType
    FROM tbluser u
    LEFT JOIN tbl_user_voice v ON v.user_id = u.id
    WHERE u.type = ?
");
$stmt->execute([0]);

/* =========================
   SAFE ACCESS HELPER
========================= */
function safeVal($arr, $keys) {
    foreach ($keys as $key) {
        if (!isset($arr[$key])) return null;
        $arr = $arr[$key];
    }
    return $arr;
}

$srNo = 1;

/* =========================
   DATA ROWS
========================= */
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $apiData = !empty($row['api_response']) 
        ? json_decode($row['api_response'], true) 
        : [];

    $prediction = $apiData['prediction'] ?? 'N/A';
    $confidence  = $apiData['confidence'] ?? null;
    $confidencePercent = is_numeric($confidence)
        ? round($confidence * 100, 2) . '%'
        : 'N/A';

    // A,E,I,O,U,PA,TA,KA phonation
    $sounds = ['a','e','i','o','u','pa','ta','ka'];
    $phonation = [];

    foreach ($sounds as $s) {
        $vData = safeVal($apiData, ['voice_features', $s]) ?? [];
        $phonation[] = $vData['meanF0']  ?? 'N/A';
        $phonation[] = $vData['stdevF0'] ?? 'N/A';
        $phonation[] = $vData['HNR']     ?? 'N/A';
        $phonation[] = $vData['jitter']  ?? 'N/A';
        $phonation[] = $vData['shimmer'] ?? 'N/A';
    }

    echo "<tr>";
    echo "<td>{$srNo}</td>";
    echo "<td>{$row['name']}</td>";
    echo "<td>{$row['phone_no']}</td>";
    echo "<td>{$row['email']}</td>";
    echo "<td>{$row['gender']}</td>";
    echo "<td>{$row['age']}</td>";
    echo "<td>{$row['diseases']}</td>";
    echo "<td>" . (!empty($row['diseases_desc']) ? $row['diseases_desc'] : 'N/A') . "</td>";
    echo "<td>" . ($row['fldDiagnosisStatus'] ?? 'N/A') . "</td>";
    echo "<td>" . ($row['fldDiagnosisYear'] ?? 'N/A') . "</td>";
    echo "<td>" . ($row['fldDiagnosisPlace'] ?? 'N/A') . "</td>";
    echo "<td>" . ($row['fldDiagnosisType'] ?? 'N/A') . "</td>";
    echo "<td>{$prediction}</td>";
    echo "<td>{$confidencePercent}</td>";

    foreach ($phonation as $val) {
        echo "<td>{$val}</td>";
    }

    echo "<td>{$row['created_at']}</td>";
    echo "</tr>";

    $srNo++;
}

echo "</table>";
exit;
