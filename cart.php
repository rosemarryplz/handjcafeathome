<?php
session_start();
include('./Admin/connect/conndb.php');
$query = "SELECT t.*,COUNT(p.p_id) as ptotal
FROM tbl_prd_type as t
LEFT JOIN tbl_prd as p ON t.t_id=p.ref_t_id
GROUP BY t.t_id" or die("Error:" . mysqli_error($conn));
$result = mysqli_query($conn, $query);

@$p_id = mysqli_real_escape_string($conn, $_GET['p_id']);
$act = mysqli_real_escape_string($conn, $_GET['act']);

//add to cart
if ($act == 'add' && !empty($p_id)) {
  if (isset($_SESSION['cart'][$p_id])) {
    $_SESSION['cart'][$p_id]++;
    echo "<script type='text/javascript'>";
    echo "window.location = 'index.php?do=addcart'; ";
    echo "</script>";
  } else {
    $_SESSION['cart'][$p_id] = 1;
    echo "<script type='text/javascript'>";
    echo "window.location = 'index.php?do=addcart'; ";
    echo "</script>";
  }
  
}


if ($act == 'remove' && !empty($p_id))  //ลบสินค้าในตะกร้าตามไอดี
{
  unset($_SESSION['cart'][$p_id]);
}

//update cart
if ($act == 'update') {
  $amount_array = $_POST['amount'];
  foreach ($amount_array as $p_id => $amount) {
    $_SESSION['cart'][$p_id] = $amount;
  }
}


//cancel cart
if ($act == 'cancel') {
  unset($_SESSION['cart']);
}

?>
<!doctype html>
<html lang="en">

<?php include('./Admin/include/head.php'); ?>

<body style="background: #ffffff; font-family: 'Prompt', sans-serif;">
<?php include('./Admin/include/navbar1.php')?>
    
  <section class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12">
        <h3 class=" py-2 text-center"><i class="fas fa-cart-arrow-down text-dark"><b style="font-family: 'Prompt', sans-serif;"> ตะกร้าสินค้า</b> </i></a></h3>

        <form id="frmcart" name="frmcart" method="post" action="?act=update">
          <div style='overflow-x:auto;'>
            <table class="table table-hover  ">

              <tr class="bg-alpha text-white">
                <th width="5%" align="center">#</th>
                <th width="10%" align="center">รูปสินค้า</th>
                <th width="40%" align="center">สินค้า</th>
                <th width="15%" align="center">ราคา</th>
                <th width="10%" align="center">จำนวน</th>
                <th width="10%" align="center">รวม(บาท)</th>
                <th width="10%" align="center"></th>
              </tr>
              <?php
              
              $i = 0;
              if (!empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $p_id => $qty) {
                  $sql = "SELECT * FROM tbl_prd WHERE p_id=$p_id";
                  $query = mysqli_query($conn, $sql);
                  $row = mysqli_fetch_array($query);
                  $sum = $row['p_price'] * $qty;  //เอาราคาสินค้า คูณ จำนวนที่สั่งซื้อ
                  $total += $sum; //ราคารวม
                  $p_qty = $row['p_qty']; //จำนวนสินค้าในสต็อก   

                  echo "<tr >";
                  echo "<td >" . $i += 1 . "</td>";
                  echo "<td align='center'>" . "<img src='./Admin/img_product/" . $row['p_img'] . "' width='100'>" . "</td>";
                  echo "<td >"
                    . $row["p_name"]
                    . "<br>"
                    . 'จำนวนสินค้าในสต็อก :'
                    . $row["p_qty"]
                    . ' ชิ้น'
                    . "</td>";
                  echo "<td  >" . "฿" . number_format($row["p_price"], 2) . "</td>";
                  echo "<td  >";
                  echo "<input type='number' name='amount[$p_id]' value='$qty' class='form-control' min='1' max='$p_qty'/></td>";
                  echo "<td  >" . "฿" . number_format($sum, 2) . "</td>";
                  //remove product
                  echo "<td width='46' align='center'><a href='cart.php?p_id=$p_id&act=remove' class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'> ลบ</i></a></td>";
                  echo "</tr>";
                }
                echo "<tr>";
                echo "<td colspan='5'  align='center'><b>ราคารวม:</b></td>";
                echo "<td align='right' >" . "฿" . "<b>" . number_format($total, 2) .  "</b>" . "</td>";
                echo "<td align='left' ></td>";
                echo "</tr>";
              }
              if ($total > 0) {
              ?>
                <tr class="bg-alpha">
                  <td colspan="7" align="right">
                    <input type="button" class="btn btn-danger btn-sm" name="btncancel" value="ยกเลิกการสั่งซื้อสินค้า" onclick="window.location='cart.php?act=cancel';" />
                    <input type="submit" class="btn btn-secondary btn-sm" name="updateprice" value="คำนวนราคาใหม่" />
                  
                      <input type="button" class="btn btn-warning btn-sm" name="submit2" value="สั่งซื้อสินค้า" onclick="window.location='confirm.php';" />
                  
                  </td>
                </tr>
              <?php } else {
                echo '<h4 align="center" class="text-danger"> -ไม่มีสินค้าในตะกร้า กรุณาเลือกซื้อสินค้าใหม่อีกครั้ง- </h4>';
              } ?>
            </table>
          </div>
        </form>
      </div>
    </div>

    </div>
    <?php include('cart_show.php');?>
  
    <?php include('./Admin/include/footer2.php');?>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>