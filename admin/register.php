<?php
  require "../config/config.php";
  if(!empty($_POST)){

     if ( $_POST['name'] == '' || $_POST['password'] == '' || $_POST['retype_password'] == '' || $_POST['email'] == ''){

        echo "<script> alert('You need to fill all field')</script>";

     }else{

      if( $_POST['password'] == $_POST['retype_password'] ){

        $name = $_POST['name'];
        $email = $_POST['email'];
        $passwordHush = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("SELECT COUNT(email) AS num FROM `users` WHERE email=:email");
        $stmt->execute(
          array(
            ":email"=>$email,
          )
          );
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if( $result['num'] > 0){

          echo "<script> alert('This email address already has an account') <script>";

        }else{

            $stmt = $pdo->prepare("INSERT INTO `users` (name,email,password) VALUES(:name,:email,:password) ");
            $result = $stmt->execute(
              array(
                ":email"=>$email,
                ":name"=>$name,
                ":password"=>$passwordHush,
              )
              );
            if($result){
              echo "<script> alert('successfully registered'); window.location.href='login.php' </script>";
            }

        }
        

        

      }else{
         
          echo "<script>alert('password does not match')</script>";

      }

     }

      


  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Twitter | Registration Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="../../index2.html"><b>Twitter</b></a>
  </div>
  
  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form action="" method="POST">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="name" placeholder="Full name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="retype_password" placeholder="Retype password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
          <div class="col-4">
           
          </div>
          <!-- /.col -->
        </div>
      </form>

      

      
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>
