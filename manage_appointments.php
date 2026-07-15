<?php
// 1. بدء الجلسة لضمان التحقق من صلاحيات الأدمن[cite: 7]
session_start();
// 2. تضمين ملف الاتصال بقاعدة البيانات[cite: 7]
include 'db.php';

// [1. الإضافة] معالجة إضافة خدمة جديدة ورفع صورتها للمجلد المحلي[cite: 7]
if (isset($_POST['add_service'])) {
    $name = mysqli_real_escape_string($conn, $_POST['service_name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    // التحقق من وجود صورة، إذا لم توجد نستخدم صورة افتراضية[cite: 7]
    $img = $_FILES['service_image']['name'] ? $_FILES['service_image']['name'] : "default.jpg";
    
    // نقل الصورة المرفوعة للمجلد المحدد[cite: 7]
    move_uploaded_file($_FILES['service_image']['tmp_name'], "img/" . $img);
    // إدراج الخدمة الجديدة في جدول الخدمات[cite: 7]
    mysqli_query($conn, "INSERT INTO services (service_name, price, image_path) VALUES ('$name', '$price', '$img')");
    header("Location: manage_appointments.php");
}

// [2. التحديث] معالجة قبول أو رفض الحجز برمجياً[cite: 7]
if (isset($_GET['action'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $status = ($_GET['action'] == 'confirm') ? 'Confirmed' : 'Cancelled';
    // تحديث حالة الحجز في قاعدة البيانات[cite: 7]
    mysqli_query($conn, "UPDATE appointments SET status='$status' WHERE id='$id'");
    header("Location: manage_appointments.php");
}

// [3. الحذف] حذف حجز معين من قاعدة البيانات نهائياً[cite: 7]
if (isset($_GET['delete_id'])) {
    $del_id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    mysqli_query($conn, "DELETE FROM appointments WHERE id='$del_id'");
    header("Location: manage_appointments.php");
}

// [4. العرض] جلب الحجوزات مع الربط (JOIN) لجلب اسم الزبونة واسم الخدمة[cite: 7]
$appointments_result = mysqli_query($conn, "SELECT appointments.*, users.username, services.service_name FROM appointments JOIN users ON appointments.user_id = users.id JOIN services ON appointments.service_id = services.id ORDER BY appointments.id DESC");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة التحكم للأدمن</title>
    <!-- استدعاء Bootstrap لتنسيق الصفحة[cite: 7] -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container my-5">
    <div class="d-flex justify-content-between mb-4">
        <h2>لوحة تحكم النظام الإدارية 🛠️</h2>
        <a href="logout.php" class="btn btn-danger">تسجيل الخروج</a>
    </div>

    <!-- نموذج إضافة خدمة جديدة مع دعم رفع الملفات (enctype)[cite: 7] -->
    <div class="card p-4 mb-4 border-0 shadow-sm">
        <h5 class="text-primary mb-3">إضافة خدمة جديدة وتنزيل صورتها</h5>
        <form action="manage_appointments.php" method="POST" enctype="multipart/form-data">
            <div class="row g-2">
                <div class="col-md-4"><input type="text" name="service_name" class="form-control" placeholder="اسم الخدمة" required></div>
                <div class="col-md-3"><input type="number" step="0.01" name="price" class="form-control" placeholder="السعر" required></div>
                <div class="col-md-3"><input type="file" name="service_image" class="form-control" accept="image/*"></div>
                <div class="col-md-2"><button type="submit" name="add_service" class="btn btn-success w-100">إضافة</button></div>
            </div>
        </form>
    </div>

    <!-- جدول عرض الحجوزات مع خيارات القبول، الرفض، والحذف[cite: 7] -->
    <div class="card p-4 border-0 shadow-sm">
        <h5 class="text-secondary mb-3">قائمة إدارة الحجوزات الحالية</h5>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>الزبونة</th><th>الخدمة</th><th>التاريخ</th><th>الوقت</th><th>الحالة</th><th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($appointments_result)) { ?>
                    <tr>
                        <td><?= $row['username']; ?></td>
                        <td><?= $row['service_name']; ?></td>
                        <td><?= $row['appointment_date']; ?></td>
                        <td><?= $row['appointment_time']; ?></td>
                        <td><span class="badge bg-secondary"><?= $row['status']; ?></span></td>
                        <td>
                            <a href="manage_appointments.php?action=confirm&id=<?= $row['id']; ?>" class="btn btn-sm btn-success">قبول</a>
                            <a href="manage_appointments.php?action=reject&id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">رفض</a>
                            <a href="manage_appointments.php?delete_id=<?= $row['id']; ?>" class="btn btn-sm btn-danger text-white" onclick="return confirm('هل تريد الحذف؟')">حذف</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>