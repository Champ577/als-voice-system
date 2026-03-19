<?php
$map = [
  'fileA' => 'phonationA',
  'fileE' => 'phonationE',
  'fileI' => 'phonationI',
  'fileO' => 'phonationO',
  'fileU' => 'phonationU',
  'filePA' => 'rhythmPA',
  'fileTA' => 'rhythmTA',
  'fileKA' => 'rhythmKA',
];

$key = $_GET['key'] ?? '';
if (!isset($map[$key])) {
  echo json_encode([]);
  exit;
}

$dir = __DIR__ . '/assets/VOC-ALS-TEST/' . $map[$key];
$files = glob($dir . '/*.wav');

$result = [];
foreach ($files as $f) {
  $result[] = 'assets/VOC-ALS-TEST/' . $map[$key] . '/' . basename($f);
}

echo json_encode($result);
