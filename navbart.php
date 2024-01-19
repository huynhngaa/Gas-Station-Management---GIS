<?php include "admin/ketnoi.php"?>

<!DOCTYPE html>
<html>
<head>
<title></title> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
 
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js" integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg==" crossorigin=""></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<link rel="stylesheet" href="css/leaflet-search.css" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Font Awesome -->
<link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
  rel="stylesheet"
/>
<!-- Google Fonts -->
<link
  href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
  rel="stylesheet"
/>
<!-- MDB -->
<link
  href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.css"
  rel="stylesheet"
/>
  <!-- CSS only -->

	<style>
.menu-ui {
background:#fff;
position:absolute;
top:10px;right:10px;
z-index:1000;
border-radius:3px;
width:120px;
border:1px solid rgba(0,0,0,0.4);
}
.menu-ui a {
font-size:13px;
color:#404040;
display:block;
margin:0;padding:0;
padding:10px;
text-decoration:none;
border-bottom:1px solid rgba(0,0,0,0.25);
text-align:center;
}
.menu-ui a:first-child {
border-radius:3px 3px 0 0;
}
.menu-ui a:last-child {
border:none;
border-radius:0 0 3px 3px;
}
.menu-ui a:hover {
background:#f8f8f8;
color:#404040;
}
.menu-ui a.active,
.menu-ui a.active:hover {
background:#3887BE;
color:#FFF;
}
body { margin:0; padding:0; }
#map { position:absolute; top:0; bottom:0; width:100%; }
	</style>
</head>
<body class="fixed-sn mdb-skin">

<!--Double navigation-->
<header>
  <!-- Sidebar navigation -->
  <div id="slide-out" class="side-nav fixed wide sn-bg-1">
    <ul class="custom-scrollbar">
      <!-- Logo -->
      <li>
        <div class="logo-wrapper sn-ad-avatar-wrapper">
          <a href="#"><img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(10).webp" class="rounded-circle"><span>Anna Deynah</span></a>
        </div>
      </li>
      <!--/. Logo -->
      <!-- Side navigation links -->
      <li>
        <ul class="collapsible collapsible-accordion">
          <li><a class="collapsible-header waves-effect arrow-r active"><i class="sv-slim-icon fas fa-chevron-right"></i> Submit blog<i class="fas fa-angle-down rotate-icon"></i></a>
            <div class="collapsible-body">
              <ul>
                <li><a href="#" class="waves-effect active">
                  <span class="sv-slim"> SL </span>
                  <span class="sv-normal">Submit listing</span></a>
                </li>
                <li><a href="#" class="waves-effect">
                  <span class="sv-slim"> RF </span>
                  <span class="sv-normal">Registration form</span></a>
                </li>
              </ul>
            </div>
          </li>
          <li><a class="collapsible-header waves-effect arrow-r"><i class="sv-slim-icon far fa-hand-point-right"></i> Instruction<i class="fas fa-angle-down rotate-icon"></i></a>
            <div class="collapsible-body">
              <ul>
                <li><a href="#" class="waves-effect">
                  <span class="sv-slim"> FB </span>
                  <span class="sv-normal">For bloggers</span></a>
                </li>
                <li><a href="#" class="waves-effect">
                  <span class="sv-slim"> FA </span>
                  <span class="sv-normal">For authors</span></a>
                </li>
              </ul>
            </div>
          </li>
          <li><a class="collapsible-header waves-effect arrow-r"><i class="sv-slim-icon fas fa-eye"></i> About<i class="fas fa-angle-down rotate-icon"></i></a>
            <div class="collapsible-body">
              <ul>
                <li><a href="#" class="waves-effect">
                  <span class="sv-slim"> I </span>
                  <span class="sv-normal">Introduction</span></a>
                </li>
                <li><a href="#" class="waves-effect">
                  <span class="sv-slim"> MM </span>
                  <span class="sv-normal">Monthly meetings</span></a>
                </li>
              </ul>
            </div>
          </li>
          <li><a class="collapsible-header waves-effect arrow-r"><i class="sv-slim-icon far fa-envelope"></i> Contact me<i class="fas fa-angle-down rotate-icon"></i></a>
            <div class="collapsible-body">
              <ul>
                <li><a href="#" class="waves-effect">
                  <span class="sv-slim"> F </span>
                  <span class="sv-normal">FAQ</span></a>
                </li>
                <li><a href="#" class="waves-effect">
                  <span class="sv-slim"> W </span>
                  <span class="sv-normal">Write a message</span></a>
                </li>
              </ul>
            </div>
          </li>
          <li><a id="toggle" class="waves-effect"><i class="sv-slim-icon fas fa-angle-double-left"></i>Minimize menu</a>
          </li>
        </ul>
      </li>
      <!--/. Side navigation links -->
    </ul>
    <div class="sidenav-bg rgba-blue-strong"></div>
  </div>
  <!--/. Sidebar navigation -->
  <!-- Navbar -->
 <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar w/ text</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Features</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Pricing</a>
      </li>
    </ul>
    <span class="navbar-text">
      Navbar text with an inline element
    </span>
  </div>
</nav>
  <!-- /.Navbar -->
</header>
<!--/.Double navigation-->

<!--Main Layout-->
<main>
  <div class="container-fluid mt-5">
    <h2>Advanced Double Navigation with slim Side-nav nad fixed Navbar:</h2>
    <br>
    <h5>1. Fixed slim Side-nav, hidden on small devices.</h5>
    <h5>2. Fixed Navbar. It will always stay visible on the top, even when you scroll down.</h5>
    <div style="height: 2000px"></div>
  </div>
</main>
<!--Main Layout-->


</body>
</html>
