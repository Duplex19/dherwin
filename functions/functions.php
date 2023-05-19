<?php 

$link = mysqli_connect("localhost", "duplex", "duplex1909", "erwin");


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

$foto = upload();
if(!$foto){
    return false;
}

$input = "INSERT INTO album
            VALUES(
                NULL, '$judul', '$foto', '$story'
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
                story = '$story'
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
?>