<?php
include_once("../includes/Spyc.php");
include_once("../includes/file_upload.php");

if(!empty($_POST['type_output']) && isset($_POST['type_output'])){
    if(end(explode(".", $_FILES["file"]["name"])) == $_POST['type_output']){
        $fileContent = file_get_contents($_FILES['file']['tmp_name']);
        $file = "/result/".uniqid().".".end(explode(".", $_FILES['file']['name']));
        file_put_contents($_SERVER["DOCUMENT_ROOT"].$file, $fileContent);
        print json_encode(array('file' => $_SERVER["HTTP_ORIGIN"].$file));
        return;
    }
    $myFile = new FileUpload;
    $json = $myFile->convertToJson($_FILES["file"]["name"], $_FILES['file']['tmp_name']);
    $json = $myFile->getJsonInMyFormat($json, $_POST['type_output']);
    print $myFile->toFile($json, $_POST['type_output']);
}

