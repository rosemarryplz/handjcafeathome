<div class="container-fluid">
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class=" py-2 text-center"><i class="fas fa-cart-arrow-down text-dark"><b style="font-family: 'Prompt', sans-serif;"> ตะกร้าสินค้า</b> </i></a></h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div style='overflow-x:auto;'>
            <table class="table table-hover  ">

              <tr class="bg-alpha text-white">
                <th width="2%" align="center">#</th>
                <th width="3%" align="center">รูป</th>
                <th width="8%" align="center">สินค้า</th>
                <th width="2%" align="center">ราคา</th>
                <th width="3%" align="center">จำนวน</th>
                <th width="3%" align="center">รวม(บาท)</th>
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
                  echo "<td align='center'>" . "<img src='./Admin/img_product/" . $row['p_img'] . "' width='50'>" . "</td>";
                  echo "<td >"
                    . $row["p_name"] . "</td>";
                  echo "<td  >" . "฿" . number_format($row["p_price"], 2) . "</td>";
                  echo "<td  >";
                  echo "<input type='number' name='amount[$p_id]' value='$qty' readonly class='form-control'  min='1' max='$p_qty'/></td>";
                  echo "<td  >" . "฿" . number_format($sum, 2) . "</td>";
                }
                echo "<tr>";
                echo "<td colspan='5'  align='center'><b>ราคารวม:</b></td>";
                echo "<td align='right' >" . "฿" . "<b>" . number_format($total, 2) .  "</b>" . "</td>";
                echo "</tr>";
              }
              ?>
            </table>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
              <a href="cart.php" class="btn btn-warning">สั่งซื้อสินค้า</a>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>