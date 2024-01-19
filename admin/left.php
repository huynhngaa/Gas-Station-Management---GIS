<div  id="left">  
        <ul class="nav flex-column">
        <li class="nav-item">
    <a style="color:#555555;font-size:110%;font-family: 'Roboto Condensed', sans-serif;" class="nav-link" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false">
    <i class="fas fa-tachometer-alt"></i> Quản lý công ty đầu mối </a>
  
  <div style="padding-left:15px" class="collapse" id="navbarToggleExternalContent">
    <div>
    <a href="" style="color:#555555;font-size:95%;font-family: 'Roboto Condensed', sans-serif;" class="nav-link" data-toggle="collapse" data-target="#navbarToggleExternal" aria-controls="navbarToggleExternal" aria-expanded="false"><i class="fas fa-chevron-right"></i> Danh sách công ty đầu mối </a>
    <div style="padding-left:15px" class="collapse" id="navbarToggleExternal">
  <?php  $sql = "SELECT * FROM congtydaumoi";
                     $result = mysqLi_query($conn, $sql);
                     
                    while($row = mysqli_fetch_array($result)) { ?>

    <a style="color:#555555;font-size:95%;font-family: 'Roboto Condensed', sans-serif;" class="nav-link" href="#" id="<?php echo $row['ct_ma'] ?>" onclick="searchMarkerById(this.id)">
    <i class="fas fa-chevron-right"></i> <?php echo $row['ct_ten'] ?> </a>
<?php } ?>
    </div>
      </div>
      <a style="color:#555555;font-size:95%;font-family: 'Roboto Condensed', sans-serif;" class="nav-link" href="add.php"><i class="fas fa-chevron-right"></i> Thêm công ty đầu mối </a>
    <a style="color:#555555;font-size:95%;font-family: 'Roboto Condensed', sans-serif;" class="nav-link" href="sua.php"><i class="fas fa-chevron-right"></i> Sửa công ty đầu mối </a>
  </div>
  
  </li>
  <li class="nav-item">
    <a  href = "#"  style="color:#555555;font-size:110%;font-family: 'Roboto Condensed', sans-serif;" class="nav-link" data-toggle="collapse" data-target="#navbarToggleExternal" aria-controls="navbarToggleExternal" aria-expanded="false">
    <i class="fas fa-tachometer-alt"></i> Quản lý trạm bán lẻ </a>
  
  <div style="padding-left:15px" class="collapse" id="navbarToggleExternal">
    <div>
    <a style="color:#555555;font-size:95%;font-family: 'Roboto Condensed', sans-serif;" class="nav-link" href="index2.php"><i class="fas fa-chevron-right"></i> Danh sách trạm bán lẻ </a>
    <!-- <a style="color:#555555;font-size:95%;font-family: 'Roboto Condensed', sans-serif;" class="nav-link" href="add.php"><i class="fas fa-chevron-right"></i> Thêm trạm bán lẻ </a> -->
    
    </div>
  </div>
  </li>

  <li class="nav-item">
    <a style="color:#555555; font-size:110%;font-family: 'Roboto Condensed', sans-serif;" class="nav-link" href="timkiem.php"><i class="fa fa-search"></i> Tìm kiếm trạm bán lẻ</a>
  </li>
  <li class="nav-item">
    <a style="color:#555555; font-size:110%;font-family: 'Roboto Condensed', sans-serif;" class="nav-link" href="hienthi.php"><i class="fas fa-filter"></i> Lọc trạm xăng</a>
  </li>

  <li class="nav-item">
    <a style="color:#555555;font-size:110%;font-family: 'Roboto Condensed', sans-serif;" class="nav-link" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false">
    <i class="fas fa-chart-bar"></i> Thống kê trạm xăng (Bar char) </a>
  
  <div style="padding-left:15px" class="collapse" id="navbar">
    <form class="row" method="POST" action="thongkechar.php">
    <select class="custom-select col-7 ml-4 mr-2" name="congty">
                    <option>--Chọn công ty--</option>
                    <?php
                    $sql = "SELECT * FROM congtydaumoi";
                    $result = mysqli_query($conn, $sql);

                    // Hiển thị danh sách các huyện trong thẻ select
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row['ct_ma'] . '">' . $row['ct_ten'] . '</option>';
                    }
                   ?>
                  </select>
                 
                  <button type="submit" name="thongke" class="btn btn-success col-3">Submit</button>
   
      </form>
  </div>
  </li>



  <li class="nav-item">
    <a style="color:#555555;font-size:110%;font-family: 'Roboto Condensed', sans-serif;" class="nav-link" data-toggle="collapse" data-target="#navbarToggle" aria-controls="navbarToggle" aria-expanded="false">
    <i class="fas fa-globe-americas"></i> Thống kê trạm xăng (Legend) </a>
  
  <div style="padding-left:15px" class="collapse" id="navbarToggle">
    <form class="row" method="POST" action="legend.php">
    <select class="custom-select col-7 ml-4 mr-2" name="congty">
                    <option>--Chọn công ty--</option>
                    <?php
                    $sql = "SELECT * FROM congtydaumoi";
                    $result = mysqli_query($conn, $sql);

                    // Hiển thị danh sách các huyện trong thẻ select
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row['ct_ma'] . '">' . $row['ct_ten'] . '</option>';
                    }
                   ?>
                  </select>
                 
                  <button type="submit" name="thongke" class="btn btn-success col-3">Submit</button>
   
      </form>
  </div>
  </li>
  
  
</ul>
             <!-- Button trigger modal -->

            <button type="button" onclick="thongbao()" class="btn btn-danger dangxuat">Đăng Xuất</button>
        </div>
      
