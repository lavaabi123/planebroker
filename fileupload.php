<?php
$baseUrl = 'http://localhost/plane_broker/';
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

    // Generate a unique filename to prevent conflicts
    $filename = rand(). '_' .time(). '_' .uniqid() . '_' . $file['name'];

    // Move the uploaded file to the desired directory
    if (move_uploaded_file($file['tmp_name'], $uploadPath . $filename)) {
        // File upload success
        $url = $baseUrl . $uploadPath . $filename;
        $response = [
            'uploaded' => 1,
            'fileName' => $filename,
            'url' => $url
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
