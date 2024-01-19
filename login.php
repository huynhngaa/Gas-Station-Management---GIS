<?php include "admin/ketnoi.php"?>
<?php
session_start();
$err = [];
if (isset($_POST['dangnhap'])){
    $email = $_POST['email'];
    $pass = md5( $_POST['pass']);
	
    $sl = "SELECT * FROM congtydaumoi WHERE ct_ma='$email' AND ct_pass ='$pass'";
    $res = mysqli_query($conn, $sl);
	$dat = mysqli_fetch_assoc($res);
	
	if ($email!= '' && $pass!=''){
        if (mysqli_num_rows($res) == 1)
        {
            //$_SESSION['login']['username'] = $username;
            $_SESSION['user'] =$dat;
            header("location:index.php");
}
else {
    $error[] = 'Tài khoản hoặc mật khẩu không đúng!!!';
}
    }
}


?>


<!DOCTYPE html>
<html lang="en" >
<head>
<meta charset="UTF-8">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css'>
<link rel='stylesheet' href='https://unicons.iconscout.com/release/v2.1.9/css/unicons.css'>
<link rel="stylesheet" href="admin/css/login.css">

</head>
<body>
    <div class="section">
        <div class="container">
            <div class="row full-height justify-content-center">
                <div class="col-12 text-center align-self-center py-5">
                    <div class="section pb-5 pt-5 pt-sm-2 text-center">
                        <label for="reg-log"></label>
                        <div class="card-3d-wrap mx-auto">
                            <div class="card-3d-wrapper">
                                <div class="card-front">
                                    <div class="center-wrap">
                                        <div class="section text-center">
                                            <h4 class="mb-4 pb-3">Log In</h4>
                                            <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span style="color:red">'.$error.'</span>';
         }
      };
     
      ?>
                                            <form action="login.php" method="post">
                                            <div class="form-group">
                                                <input  name="email" class="form-style" placeholder="Your Email" id="logemail" autocomplete="off">
                                                <i class="input-icon uil uil-at"></i>
                                            </div>	
                                            <div class="form-group mt-2">
                                                <input type="password" name="pass" class="form-style" placeholder="Your Password" id="logpass" autocomplete="off">
                                                <i class="input-icon uil uil-lock-alt"></i>
                                            </div>
                                            <br>
                                            <input class="btn mt-4" name="dangnhap" type="submit" values="submit">
                                           </form>
                                            <p class="mb-0 mt-4 text-center"><a href="#0" class="link">Forgot your password?</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- partial -->
<script  src="./script.js"></script>

</body>
</html>