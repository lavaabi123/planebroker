<?php
$baseUrl = 'http://localhost/planebroker/';
// Specify the path to save the uploaded files
if(!empty($_GET['uploadpath'])){
	$uploadPath = 'uploads/'.$_GET['uploadpath'].'/';
}else{
	$uploadPath = 'uploads/email_templates/';
}

//If the directory doesn't already exists.
if (!is_dir($uploadPath)) {
    //Create directory.
    @mkdir($uploadPath, 0755, true);
}

// Check if a file was uploaded successfully
if ($_FILES['upload']['error'] === UPLOAD_ERR_OK) {
    // Get the uploaded file information
    $file = $_FILES['upload'];

	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mimeType = finfo_file($finfo, $file['tmp_name']);
	finfo_close($finfo);
	$isImage = str_starts_with($mimeType, 'image/');
	$isVideo = str_starts_with($mimeType, 'video/');
	
    // Generate a unique filename to prevent conflicts
    $filename = rand(). '_' .time(). '_' .uniqid() . '_' . $file['name'];

    // Move the uploaded file to the desired directory
    if (move_uploaded_file($file['tmp_name'], $uploadPath . $filename)) {
        // File upload success
        $url = $baseUrl . $uploadPath . $filename;
        $response = [
            'uploaded' => 1,
            'fileName' => $filename,
			'fileType' => $isImage ? 'image' : 'video',
            'url' => $url,
			'tag' => !empty($_POST['tag']) ? $_POST['tag'] : ''
        ];
    } else {
        // File upload failed
        $response = [
            'uploaded' => 0,
            'error' => 'Failed to upload file'
        ];
    }
} else {
    // File upload failed
    $response = [
        'uploaded' => 0,
        'error' => 'Error uploading file'
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
