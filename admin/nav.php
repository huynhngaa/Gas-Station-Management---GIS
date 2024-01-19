<nav class="navbar navbar-expand-lg navbar-light ">

 <a style="color:#4CAF50 ;font-family: 'Roboto Condensed', sans-serif;" class="navbar-brand" href="index.php">

  <b >Quản lý xăng dầu</b> 
 </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
    </ul>
    
    <?php  
		
    if (isset($_SESSION['use'])){ 
      $user= $_SESSION['use'];
      ?>
<div class="btn-group">
       <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" > 
       <?php echo $user['ql_ten'] ?> <i class="fas fa-angle-down"></i>
       
    </span>
 
 <?php } ?>
 
 
  <div class="dropdown-menu dropdown-menu-right">
    <button class="dropdown-item" type="button">Hồ sơ</button>
   
 
  </div>
</div>
  </div>
</nav>