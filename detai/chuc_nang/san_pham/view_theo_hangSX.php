<?php
        $conn = mysqli_connect('localhost', 'root', '', 'linhkienmaytinh');        
        $idhang = $_GET['idhang'];
		$result = mysqli_query($conn, 'select count(ID) as total from tbl_dmsp where TrangThai=1 and IDHang ='.$idhang.'');
		$row = mysqli_fetch_assoc($result);
		$total_records = $row['total'];
		$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
		$limit = 8;
		$total_page = ceil($total_records / $limit);
		if ($current_page > $total_page){
			$current_page = $total_page;
		}
		else if ($current_page < 1){
			$current_page = 1;
		}
		$start = ($current_page - 1) * $limit;
		$result = mysqli_query($conn, "SELECT * FROM tbl_dmsp where IDHang = $idhang LIMIT $start, $limit");
?>
<div class="alert alert-danger text-center m-1" style="background-color:#040b3c">
    <h3 style="margin-top: 5px;color: white"><b>Danh mục sản phẩm <?php 
        if($idhang == 1){
            echo "Asus";
        }if($idhang == 2){
            echo "MSI";
        }
        if($idhang == 3){
            echo "Intel";
        }
        if($idhang == 4){
            echo "AMD";
        }
        if($idhang == 5){
            echo "Gigabyte";
        }
        if($idhang == 6){
            echo "Samsung";
        }
        if($idhang == 7){
            echo "Asrock";
        }
        if($idhang == 8){
            echo "LG";
        }
    ?>
    </b></h3>
</div>
<div  class="container padding">
    <div class="row padding" >
        <?php	
            //session_start();
            require('./connect/connect.php');
            $sql = "select * from tbl_dmsp where TrangThai=1 and IDHang = $idhang";
            $query = mysqli_query($con,$sql);
            if(mysqli_num_rows($query) > 0){
                while($row = mysqli_fetch_assoc($result)){?>
                        <div class="col-md-3 col-12 my-2">
                            <div class="card sp h-100">
                                <div class="card-body">
                                <form method="post" action="add.php?id=<?php echo $row["ID"];?>">
                                        <img class="card-img-top thumb" src="<?php echo $row['HinhAnh']?>" style="height: 213px;">
                                        <h6 class="card-title" style="height: 75px;"><?php echo $row['TenSP']?></h6>
                                        <p class="card-text" style="font-size: 18px; font-weight: bold; color: red;">Giá: <?php echo number_format($row['DonGia'])?> đ</p>
                                        <!-- <input type='submit' name='btn_dathang' class="btn btn-outline-secondary p-1 btn-muangay" value='Mua ngay'/> -->
                                        <?php
                                            $dem = $row['SoLuong'] - $row['SoLuongBan'];
                                            if($dem > 0){
                                                echo "<input type='submit' name='btn_dathang' class='btn btn-outline-secondary p-1 btn-muangay' value='Mua ngay'/>";
                                            }else{
                                                echo "<input type='button' class='btn btn-outline-secondary p-1 btn-hethang' value='Hết hàng'/>";
                                            }
                                        ?>
                                        <?php 
                                            echo "<a href='./index.php?action=chitiet&id=".$row['ID']."' class='btn btn-outline-secondary p-1 btn-chitiet float-right'>Chi tiết</a>";
                                        ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                <?php							
                }
            }else
            {
                 echo "<p align='center'><font color='blue' size='18px'>HIỆN CHƯA CÓ SẢN PHẨM NÀY TẠI CỬA HÀNG</font></p>";
            }
        ?>
    </div>
</div>
<!-- page -->
<div class="container-fluid ">
    <nav aria-label="page navigation example" class="my-3">
    <ul class="pagination justify-content-center">
        <a href="danhsachsp.php"></a>
        <?php
            if ($current_page > 1 && $total_page > 1){
            echo '<li class="page-item"><a class="page-link" href="index.php?page='.($current_page-1).'">Previous</a></li> ';
            } 
            for ($i = 1; $i <= $total_page; $i++){
            if ($i == $current_page){
                echo '<li class="page-item active"><span class="page-link">'.$i.'</span></li> ';
            }
            else{
                echo '<li class="page-item"><a class="page-link" href="index.php?page='.$i.'">'.$i.'</a> </li>';
            }
            }
            if ($current_page < $total_page && $total_page > 1){
                echo '<li class="page-item"><a class="page-link" href="index.php?page='.($current_page+1).'">Next</a></li> ';
            }
        ?>
    </ul>
    </nav>
</div>
<!-- end page -->