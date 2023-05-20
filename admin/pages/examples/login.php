<?php
session_start();

if(isset($_SESSION["login"])){
   header("Location: index.php");
   exit;
}
require '../../../functions/functions.php';
global $link;

if (isset($_POST["submit"])) {
  $email = $_POST["email"];
  $password = $_POST["password"];


  $result = mysqli_query($link, "SELECT * FROM user WHERE email='$email'");
if(mysqli_num_rows($result) === 1){
  // cek password
  $row = mysqli_fetch_assoc($result);

  if (password_verify($password, $row["password"])) {
    $_SESSION["login"] = true;
    header("Location: ../../index.php");
    exit;
  }
}
 $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in (v2)</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
   <!-- sweet allert -->
   <script src="../../../sweetallert/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../../../sweetallert/dist/sweetalert2.min.css">
</head>
<body class="hold-transition login-page">

<?php if(isset($error)):  ?>
<script>
    Swal.fire({
                    icon: 'error',
                    title: 'Wrong Username Or Password!',
                    showConfirmButton: false,
                    timer: 1500
                  })
</script>
    <?php endif; ?>

<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="https://instagram.com/bytedata_id" class="h1">MY <b>Album</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Made by Bytedata_ID</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="container text-center">
        <div class="row justify-content-md-center">
       
          <div class="col">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </div>
      </form>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>
