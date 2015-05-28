<?php
$ts = date('Ymd-H') . '00';

$uploaddir = './upload/' . $ts . '/';
$uploadfile = $uploaddir . basename($_FILES['file']['name']);

if (!file_exists($uploaddir)) {
    mkdir($uploaddir, 0777, true);
}

function checkDuplicate($name, $i = 0) {
	$i == 0 ? $pattern = $name : $pattern = $name .'-' . $i;
	
	echo 'Check ' . $pattern . "\n";
	
	if(file_exists($pattern)) {
		$pattern = checkDuplicate($name, $i+1);
	}
	
	return $pattern;
}

$uploadfile = checkDuplicate($uploadfile);

echo $uploadfile;

if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
    // File is valid, and was successfully uploaded.
	echo 'OK';
} else {
    // Possible file upload attack!
	header("HTTP/1.1 500 Internal Server Error");
}

