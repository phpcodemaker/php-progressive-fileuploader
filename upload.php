<?php
ini_set('set_time_limit', 0);
// change the value here, if html file input field changed to something else.
define('POST_FILE', 'uploaded_file');
$response = [
    'success' => false,
];
if (isset($_POST['UPLOAD_IDENTIFIER'])) {
    $locationToUpload = sprintf('%s/uploads/%s', getcwd(), $_FILES[POST_FILE]['name']);
    //Upload when file does not have any errors,
    switch ($_FILES[POST_FILE]['error']) {
        case UPLOAD_ERR_INI_SIZE:
            //Value: 1;
            $response['message'] = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
            break;
        case UPLOAD_ERR_FORM_SIZE:
            //Value: 2;
            $response['message'] = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
            break;
        case UPLOAD_ERR_PARTIAL:
            //Value: 3;
            $response['message'] = 'The uploaded file was only partially uploaded.';
            break;
        case UPLOAD_ERR_NO_FILE:
            //Value: 4;
            $response['message'] = 'No file was uploaded.';
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            //Value: 6;
            $response['message'] = 'Missing a temporary folder. Introduced in PHP 5.0.3.';
            break;
        case UPLOAD_ERR_CANT_WRITE:
            //Value: 7;
            $response['message'] ='Failed to write file to disk. Introduced in PHP 5.1.0.';
            break;
        case UPLOAD_ERR_OK:
        default :
            if (copy($_FILES[POST_FILE]['tmp_name'], $locationToUpload))
            {
                $response['success']    =   true;
                $response['message']    =   'File uploaded Successfully!!!';
            }
            else {
                $response['message']    =   'File upload failure';
            }
            break;
    }
}

echo json_encode($response);