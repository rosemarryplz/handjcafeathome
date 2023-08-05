<?php
include('./Admin/include/head.php'); 
include('./Admin/include/navbar.php'); 
include('./Admin/include/carousel.php'); 
$act = (isset($_GET['act']) ? $_GET['act'] : '');
if($act=='showbytype'){
    include('./Admin/include/cards_type.php'); 
}elseif ($act=='q'){
    include('./Admin/include/search.php'); 
}else{
    include('./Admin/include/cardsnew.php'); 
}
include('./Admin/include/footer2.php'); 
?>

<div class="container text-center ">
    <br>
    <?php
// สำหรับจำนวนผู้เข้าชมเว็บรายวัน
$daily_counter_file = "daily_counter.txt";

// ตรวจสอบว่าเป็นวันใหม่หรือไม่
if (date("Y-m-d") != date("Y-m-d", filemtime($daily_counter_file))) {
    $counter = 1;
    file_put_contents($daily_counter_file, $counter);
} else {
    $counter = file_get_contents($daily_counter_file);
}

// เพิ่มจำนวนผู้เข้าชมเว็บรายวัน
$counter++;
file_put_contents($daily_counter_file, $counter);

// แสดงจำนวนผู้เข้าชมเว็บรายวันวันนี้
echo "เปิดใช้งานระบบวันที่ 21 มิถุนายม 2566 <br>";
echo "สถิติการเข้าชมเว็บ วันนี้ : " . $counter . " คน | ";

// สำหรับจำนวนผู้เข้าชมเว็บเมื่อวาน
$yesterday_counter_file = "yesterday_counter.txt";

// ตรวจสอบว่าเป็นวันใหม่หรือไม่
if (date("Y-m-d", strtotime("-1 day")) != date("Y-m-d", filemtime($yesterday_counter_file))) {
    $counter = 1;
    file_put_contents($yesterday_counter_file, $counter);
} else {
    $counter = file_get_contents($yesterday_counter_file);
}

// ตรวจสอบว่ามีตัวแปร session ที่เก็บจำนวนผู้เข้าชมเมื่อวานนี้หรือไม่
if (!isset($_SESSION['yesterday_counter'])) {
    // ถ้าไม่มีให้กำหนดค่าเริ่มต้นเป็น 0
    $_SESSION['yesterday_counter'] = 0;
}

// ตรวจสอบว่าเป็นวันแรกของวันหรือไม่
if (date('Ymd') != $_SESSION['last_visit_date']) {
    // ถ้าเป็นวันแรกของวันใหม่ให้เก็บจำนวนผู้เข้าชมเมื่อวานนี้เป็นค่าปัจจุบัน
    $_SESSION['yesterday_counter'] = $_SESSION['today_counter'];

    // รีเซ็ทจำนวนผู้เข้าชมวันนี้เป็น 0
    $_SESSION['today_counter'] = 0;
}

// แสดงสถิติการเข้าชมเว็บไซต์
// echo "เมื่อวานนี้: " . $_SESSION['yesterday_counter'] . " คน | ";

// สำหรับจำนวนผู้เข้าชมเว็บรายเดือน
$monthly_counter_file = "monthly_counter.txt";
$current_month = date("Y-m");

// ตรวจสอบว่าเป็นเดือนใหม่หรือไม่
if (date("Y-m") != date("Y-m", filemtime($monthly_counter_file))) {
    $counter = 1;
    file_put_contents($monthly_counter_file, $counter);
} else {
    $counter = file_get_contents($monthly_counter_file);
}

// เพิ่มจำนวนผู้เข้าชมเว็บรายเดือน
$counter++;
file_put_contents($monthly_counter_file, $counter);

// แสดงจำนวนผู้เข้าชมเว็บรายเดือนเดือนนี้
echo "เดือนนี้ : " . $counter . " คน | ";

// ตรวจสอบว่ามีตัวแปร session ที่เก็บจำนวนผู้เข้าชมเดือนที่แล้วหรือไม่
if (!isset($_SESSION['last_month_counter'])) {
    // ถ้าไม่มีให้กำหนดค่าเริ่มต้นเป็น 0
    $_SESSION['last_month_counter'] = 59;
}

// ตรวจสอบว่าเป็นเดือนแรกของเดือนหรือไม่
if (date('Y-m', strtotime('-1 month')) != $_SESSION['last_visit_month']) {
    // ถ้าเป็นเดือนแรกของเดือนใหม่ให้เก็บจำนวนผู้เข้าชมเดือนที่แล้วเป็นค่าปัจจุบัน
    $_SESSION['last_month_counter'] = $_SESSION['this_month_counter'];

    // รีเซ็ทจำนวนผู้เข้าชมเดือนนี้เป็น 0
    $_SESSION['this_month_counter'] = 0;
}

// แสดงสถิติการเข้าชมเว็บไซต์
// echo "เดือนที่แล้ว : " . $_SESSION['last_month_counter'] . " คน | ";


// สำหรับจำนวนผู้เข้าชมเว็บรายปี
$yearly_counter_file = "yearly_counter.txt";
$current_year = date("Y");

// ตรวจสอบว่าเป็นปีใหม่หรือไม่
if (date("Y") != date("Y", filemtime($yearly_counter_file))) {
    $counter = 1;
    file_put_contents($yearly_counter_file, $counter);
} else {
    $counter = file_get_contents($yearly_counter_file);
}

// เพิ่มจำนวนผู้เข้าชมเว็บรายปี
$counter++;
file_put_contents($yearly_counter_file, $counter);

// แสดงจำนวนผู้เข้าชมเว็บรายปีปีนี้
echo "ปีนี้ : " . $counter . " คน | ";
echo "ไมมีข้อมูลผู้เข้าชมปีที่แล้ว";
?>



<br>
<br>
 </div>