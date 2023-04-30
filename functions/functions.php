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
$foto = htmlspecialchars($data["foto"]);

$input = "INSERT INTO album
            VALUES(
                NULL, '$judul', '$foto', '$story'
            )";

mysqli_query($link, $input);


return mysqli_affected_rows($link);

}

?>