<?php
$identifier = $_REQUEST['UPLOAD_IDENTIFIER'];
if (function_exists("uploadprogress_get_info")) {
    $info = uploadprogress_get_info($identifier);
} else {
    $info = 'uploadprogress_get_info() does not exist.';
}
// $contents = uploadprogress_get_contents($identifier, $fieldName);
echo json_encode($info);
exit;
?>