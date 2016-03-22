<?php
if(isset($_FILES['upload'])){
    $errors= array();
    $file_name = $_FILES['upload']['name'];
    $file_size =$_FILES['upload']['size'];
    $file_tmp =$_FILES['upload']['tmp_name'];
    $file_type=$_FILES['upload']['type'];
    $file_ext=strtolower(end(explode('.',$_FILES['upload']['name'])));

    $expensions= array("txt");

    if(in_array($file_ext,$expensions)=== false){
        $errors[]="extension not allowed, please choose a TXT file.";
    }

    if($file_size > 2097152){
        $errors[]='File size must not exceed 2 MB';
    }

    if(empty($errors)==true){
        move_uploaded_file($file_tmp,"uploads/".$file_name);
        echo "Success";
    }else{
        print_r($errors);
    }
}
?>
<html>
<body>

<form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="upload" />
    <input type="submit"/>
</form>

</body>
</html>