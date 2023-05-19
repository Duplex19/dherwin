<?php 

require '../../../functions/functions.php';

$id = $_GET["id"];

delete($id);
if(delete($id) > 0){
    echo "<script src=../../../sweetallert/dist/sweetalert2.all.min.js >
            Swal.fire('Deleted!', 'Your file has been deleted.', 'success');
            
        </script>";
}

else {
    echo  "<script>
    document.location.href = '../../index.php'
</script>";
}


?>