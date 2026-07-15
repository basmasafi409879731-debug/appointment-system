<?php
session_start();      // 1. بدء الجلسة
include 'db.php';     // 2. استدعاء ملف الاتصال بقاعدة البيانات

// 3. هذا هو المكان الصحيح لوضع الكود الذي أرسلتُه لكِ
if (isset($_POST['book_appointment'])) {
    
    // التحقق من أن المستخدم مسجل دخول
    if (!isset($_SESSION['user_id'])) {
        die("<script>alert('يجب تسجيل الدخول أولاً!'); window.location='login.php';</script>");
    }

    $user_id = $_SESSION['user_id'];
    $service_id = mysqli_real_escape_string($conn, $_POST['service_id']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    
    $query = "INSERT INTO appointments (user_id, service_id, employee_id, appointment_date, appointment_time, status) 
              VALUES ('$user_id', '$service_id', 1, '$date', '$time', 'Pending')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('تم الحفظ بنجاح!'); window.location='my_appointments.php';</script>";
    } else {
        // إذا حدث خطأ، سيظهر لنا هنا
        die("خطأ في قاعدة البيانات: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>صالون التجميل - الرئيسية</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="salon-style.css">
</head>

<nav class="navbar navbar-expand-lg p-3">
    <div class="container">
        <a class="navbar-brand" href="index.php">مركز التجميل الناعم 🌸</a>
        <div>
            <?php if (isset($_SESSION['username'])) { ?>
                <a href="my_appointments.php" class="btn btn-sm btn-outline-light me-2">مواعيدي</a>
                <a href="logout.php" class="btn btn-sm btn-danger">خروج</a>
            <?php } else { ?>
                <a href="login.php" class="btn btn-sm btn-light">دخول</a>
            <?php } ?>
        </div>
    </div>
</nav>

<div class="container my-5">
    <h2 class="text-center text-primary mb-5">خدماتنا المتميزة ✨</h2>
    <div class="row g-4">
        
        <!-- الخدمة الأولى: مكياج -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0" style="border-radius: 12px;">
                <img src="img/makeup.jfif" class="card-img-top" style="height: 200px; object-fit: cover;">
                <div class="card-body text-center">
                    <h5>مكياج سينمائي وناعم</h5>
                    <p class="text-success fw-bold">50 $</p>
                    <form action="index.php" method="POST" class="mt-3">
                        <input type="hidden" name="service_id" value="1">
                        <input type="date" name="date" class="form-control form-control-sm mb-2" required>
                        <input type="time" name="time" class="form-control form-control-sm mb-2" required>
                        <button type="submit" name="book_appointment" class="btn btn-sm btn-primary w-100">احجزي الآن</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- الخدمة الثانية: العناية بالبشرة -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0" style="border-radius: 12px;">
                <img src="img/skincare.jpg" class="card-img-top" style="height: 200px; object-fit: cover;">
                <div class="card-body text-center">
                    <h5>تنظيف وعناية بالبشرة</h5>
                    <p class="text-success fw-bold">35 $</p>
                    <form action="index.php" method="POST" class="mt-3">
                        <input type="hidden" name="service_id" value="2">
                        <input type="date" name="date" class="form-control form-control-sm mb-2" required>
                        <input type="time" name="time" class="form-control form-control-sm mb-2" required>
                        <button type="submit" name="book_appointment" class="btn btn-sm btn-primary w-100">احجزي الآن</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- الخدمة الثالثة: تصفيف الشعر -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0" style="border-radius: 12px;">
                <img src="img/hair.jpg" class="card-img-top" style="height: 200px; object-fit: cover;">
                <div class="card-body text-center">
                    <h5>تصفيف العناية بالشعر</h5>
                    <p class="text-success fw-bold">40 $</p>
                    <form action="index.php" method="POST" class="mt-3">
                        <input type="hidden" name="service_id" value="3">
                        <input type="date" name="date" class="form-control form-control-sm mb-2" required>
                        <input type="time" name="time" class="form-control form-control-sm mb-2" required>
                        <button type="submit" name="book_appointment" class="btn btn-sm btn-primary w-100">احجزي الآن</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
</body>
</html>