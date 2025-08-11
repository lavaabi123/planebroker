<?php
$baseUrl = 'http://localhost/planebroker/';

// Target path
$uploadPath = !empty($_GET['uploadpath'])
  ? 'uploads/' . $_GET['uploadpath'] . '/'
  : 'uploads/email_templates/';

if (!is_dir($uploadPath)) { @mkdir($uploadPath, 0755, true); }

// Chunk params (if present)
$uploadId   = $_POST['uploadId']   ?? null;
$chunkIndex = isset($_POST['chunkIndex']) ? (int)$_POST['chunkIndex'] : null;
$chunkTotal = isset($_POST['chunkTotal']) ? (int)$_POST['chunkTotal'] : null;
$origName   = $_POST['filename']   ?? ($_FILES['upload']['name'] ?? 'file.bin');

// Basic validation
if (!isset($_FILES['upload']) || $_FILES['upload']['error'] !== UPLOAD_ERR_OK) {
  http_response_code(400);
  echo json_encode(['uploaded' => 0, 'error' => 'Error uploading file']);
  exit;
}

// If this is a chunked upload
if ($uploadId !== null && $chunkIndex !== null && $chunkTotal !== null && $chunkTotal > 1) {
  $chunkDir = $uploadPath . '.chunks/' . preg_replace('/[^a-zA-Z0-9_\-]/', '', $uploadId) . '/';
  if (!is_dir($chunkDir)) { @mkdir($chunkDir, 0755, true); }

  // Write this chunk
  $chunkName = str_pad((string)$chunkIndex, 6, '0', STR_PAD_LEFT) . '.part';
  $chunkPath = $chunkDir . $chunkName;
  if (!move_uploaded_file($_FILES['upload']['tmp_name'], $chunkPath)) {
    echo json_encode(['uploaded' => 0, 'error' => 'Failed to write chunk']);
    exit;
  }

  // Not last chunk? Acknowledge partial success so client continues
  if ($chunkIndex + 1 < $chunkTotal) {
    echo json_encode(['uploaded' => 1, 'partial' => 1, 'received' => $chunkIndex + 1]);
    exit;
  }

  // Last chunk: assemble
  $finalName = rand() . '_' . time() . '_' . uniqid() . '_' . $origName;
  $finalPath = $uploadPath . $finalName;

  $out = fopen($finalPath, 'wb');
  if (!$out) {
    echo json_encode(['uploaded' => 0, 'error' => 'Failed to create final file']);
    exit;
  }
  for ($i = 0; $i < $chunkTotal; $i++) {
    $part = $chunkDir . str_pad((string)$i, 6, '0', STR_PAD_LEFT) . '.part';
    $in = fopen($part, 'rb');
    if ($in) {
      stream_copy_to_stream($in, $out);
      fclose($in);
      @unlink($part);
    } else {
      fclose($out);
      echo json_encode(['uploaded' => 0, 'error' => 'Missing chunk '.$i]);
      exit;
    }
  }
  fclose($out);
  @rmdir($chunkDir);

  // Detect type from final file
  $finfo = finfo_open(FILEINFO_MIME_TYPE);
  $mimeType = finfo_file($finfo, $finalPath);
  finfo_close($finfo);
  $isImage = strpos($mimeType, 'image/') === 0;
  $fileType = $isImage ? 'image' : 'video';

  $url = $baseUrl . $finalPath;
  echo json_encode([
    'uploaded'  => 1,
    'fileName'  => $finalName,
    'fileType'  => $fileType,
    'url'       => $url,
    'tag'       => $_POST['tag'] ?? ''
  ]);
  exit;
}

// -------- Non-chunked (small files) fallback --------
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $_FILES['upload']['tmp_name']);
finfo_close($finfo);
$isImage = strpos($mimeType, 'image/') === 0;

$filename = rand() . '_' . time() . '_' . uniqid() . '_' . $_FILES['upload']['name'];
if (move_uploaded_file($_FILES['upload']['tmp_name'], $uploadPath . $filename)) {
  $url = $baseUrl . $uploadPath . $filename;
  $response = [
    'uploaded' => 1,
    'fileName' => $filename,
    'fileType' => $isImage ? 'image' : 'video',
    'url' => $url,
    'tag' => $_POST['tag'] ?? ''
  ];
} else {
  $response = ['uploaded' => 0, 'error' => 'Failed to upload file'];
}

header('Content-Type: application/json');
echo json_encode($response);
