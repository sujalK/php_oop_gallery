<?php 

    if(isset($_POST['submit'])) {

        $upload_errors= [
            UPLOAD_ERR_OK         => 'There is no error',
            UPLOAD_ERR_INI_SIZE   => 'The uploaded file exceeds the upload_max_filesize directive',
            UPLOAD_ERR_FORM_SIZE  => 'The uploaded file exceeds the MAX_FILE_SIZE directive',
            UPLOAD_ERR_PARTIAL    => 'The uploaded file was only partially uploaded',
            UPLOAD_ERR_NO_FILE    => 'No file was uploaded.',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
            UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload.'
        ];
    
        $tmp_name   = $_FILES['file_upload']['tmp_name'];
        $the_file   = $_FILES['file_upload']['name'];

        $directory  = "uploads";
        
        if(move_uploaded_file($tmp_name, $directory . '/'. $the_file)) {

            $the_message= "File uploaded successfully";

        } else {
            $the_error   = $_FILES['file_upload']['error'];
            $the_message = $upload_errors[$the_error];
        }
        


    }

    // $ext= explode('.', $_FILES['file_upload']['name']);
    // echo array_pop($ext);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <h2>
            <?php 
                if(!empty($upload_errors)) {
                    echo $the_message;
                }
            ?>
        </h2>
        
        <input type="file" name="file_upload"> <br /><br />
        <input type="submit" value="Submit" name="submit">
    </form>
</body>
</html>