<?php 

$link = mysqli_connect("localhost", "root", "", "erwin");


function query($query){
    global $link;

    $result = mysqli_query($link, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data) {

    global $link;


$judul = htmlspecialchars($data["judul"]);
$story = htmlspecialchars($data["story"]);

$category = htmlspecialchars($data["category"]);
// $tanggal = htmlspecialchars($data["tanggal"]);
$foto = upload();
if(!$foto){
    return false;
}

$input = "INSERT INTO album
            VALUES(
                NULL, '$judul', '$foto', '$story', '$category'
            )";

mysqli_query($link, $input);


return mysqli_affected_rows($link);

}

function upload(){
    $filename = $_FILES["foto"]["name"];
    $fileSize = $_FILES["foto"]["size"];
    $fileError = $_FILES["foto"]["error"];
    $fileTmp = $_FILES["foto"]["tmp_name"];

    if($fileError === 4){
        echo <<<GFG
         <div class="alert alert-danger" role="alert">
         Please Chose a Photo <a href="" class="alert-link">OK</a>.
        </div>
GFG;
return false;
    }

    $extensionok = ["jpg", "jpeg", "png"];
    $extensi = explode(".", $filename);
    $extensi = strtolower(end($extensi));

    if(!in_array($extensi, $extensionok)) {
        echo <<<GFG
        <div class="alert alert-danger" role="alert">
        Please Chose a Photo <a href="" class="alert-link">OK</a>.
       </div>
GFG;
return false;
    }

    if ($fileSize > 1000000) {
        echo <<<GFG
        <div class="alert alert-danger" role="alert">
        File Size Too Large <a href="" class="alert-link">OK</a>.
       </div>
GFG;
return false;
    }
    $newfilename = uniqid();
    $newfilename .= ".";
    $newfilename .= $extensi;

        move_uploaded_file($fileTmp, '../../../img/'.$newfilename);
    return $newfilename;
}

function edit($data){

    global $link;

    $id = $data["id"];
    $name = htmlspecialchars($data["judul"]);
    $story = htmlspecialchars($data["story"]);
    $category = htmlspecialchars($data["category"]);

    $old_image = $data["old_image"];


    if ($_FILES["foto"]["error"] === 4) {
        $image = $old_image;
    }
   else {
    $image = upload();
   }


   $input1 = "UPDATE album SET 
                name = '$name',
                image = '$image',
                story = '$story',
                category = '$category'
                WHERE id = '$id'";
       

mysqli_query($link, $input1);

 return mysqli_affected_rows($link);
}


function delete($id){
    global $link;

    // var_dump($id);
    // die;
    mysqli_query($link, "DELETE FROM album WHERE id = $id");

    return mysqli_affected_rows($link);
}

function register($data){
    global $link;

    $name = $data["name"];
    $email = $data["email"];
    $password = mysqli_real_escape_string($link, $data["password"]);
    $confirm_password = mysqli_real_escape_string($link, $data["confirm_password"]);

    // cek email

    $result = mysqli_query($link, "SELECT email FROM user WHERE email='$email'");
    if(mysqli_fetch_assoc($result)) {
        echo "
                <script>
                Swal.fire({
                    icon: 'error',
                    title: 'User Allredy Registered!',
                    showConfirmButton: false,
                    timer: 1500
                  })
                </script>
        
            ";
            return false;
    }

    if ($password !== $confirm_password) {      
        echo "
                <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Password Not Confirmed!',
                    showConfirmButton: false,
                    timer: 1500
                })
                </script>
            ";
            return false;
    }

    // enkrip Pass

    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($link, "INSERT INTO user VALUES (
                                                    NULL,
                                                    '$name',
                                                    '$email',
                                                    '$password'                                                              
                                                    )");

    return mysqli_affected_rows($link);

}
?>