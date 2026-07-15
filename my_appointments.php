<?php
// سطر 2: بدء الجلسة (Session) لاستخدام بيانات المستخدم المسجل حالياً في هذه الصفحة[cite: 8]
session_start();

// سطر 3-6: التحقق من وجود معرف المستخدم في الجلسة، إذا لم يكن موجوداً، فهذا يعني أنه لم يسجل دخولاً، فيتم تحويله لصفحة تسجيل الدخول[cite: 8]
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// سطر 7: استدعاء ملف الاتصال بقاعدة البيانات[cite: 8]
include 'db.php';

// سطر 9: تخزين معرف المستخدم الحالي في متغير[cite: 8]
$user_id = $_SESSION['user_id'];

// سطر 11: تنفيذ استعلام SQL لجلب المواعيد[cite: 8]
// يتم دمج جدول المواعيد (appointments) مع جدول الخدمات (services) للحصول على اسم الخدمة والسعر[cite: 8]
// يتم الفلترة باستخدام WHERE لجلب مواعيد المستخدم الحالي فقط (user_id = '$user_id')[cite: 8]
// يتم ترتيب المواعيد من الأحدث للأقدم باستخدام ORDER BY id DESC[cite: 8]
$my_res = mysqli_query($conn, "SELECT appointments.*, services.service_name, services.price FROM appointments JOIN services ON appointments.service_id = services.id WHERE appointments.user_id = '$user_id' ORDER BY appointments.id DESC");
?>

<!-- سطر 13-18: هيكل صفحة الـ HTML الأساسي[cite: 8] -->
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مواعيدي المحجوزة</title>
    <!-- استدعاء ملفات التنسيق الخارجية (Bootstrap و CSS الخاص)[cite: 8] -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="salon-style.css">
</head>
<body class="bg-light">
<div class="container my-5" style="max-width: 800px;">
    <div class="d-flex justify-content-between mb-4">
        <h4>جدول مواعيدي الخاصة بكِ 🗓️</h4>
        <a href="index.php" class="btn btn-sm btn-secondary">العودة للرئيسية</a>
    </div>
    
    <!-- سطر 25-34: بداية جدول عرض البيانات[cite: 8] -->
    <div class="card p-4 border-0 shadow-sm">
        <table class="table">
            <thead>
                <tr>
                    <th>الخدمة</th><th>السعر</th><th>التاريخ</th><th>الوقت</th><th>حالة الحجز</th><th>إجراء</th>
                </tr>
            </thead>
            <tbody>
                <!-- سطر 36: فتح حلقة تكرارية (while) تمر على كل سجل (موعد) تم جلبه من قاعدة البيانات[cite: 8] -->
                <?php while ($row = mysqli_fetch_assoc($my_res)) { ?>
                    <tr>
                        <!-- سطر 38-41: عرض البيانات من المصفوفة $row الخاصة بالموعد الحالي[cite: 8] -->
                        <td><?= $row['service_name']; ?></td>
                        <td><?= $row['price']; ?> $</td>
                        <td><?= $row['appointment_date']; ?></td>
                        <td><?= $row['appointment_time']; ?></td>
                        
                        <!-- سطر 43-45: عرض حالة الحجز (Pending/Confirmed) داخل شارة ملونة (Badge)[cite: 8] -->
                        <td>
                            <span class="badge bg-info text-dark"><?= $row['status']; ?></span>
                        </td>
                        
                        <!-- سطر 47-49: زر التعديل، يقوم بإرسال معرف الموعد (id) لصفحة edit.php[cite: 8] -->
                        <td>
                            <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">تعديل</a>
                        </td>
                    </tr>
                <?php } // سطر 51: إغلاق حلقة الـ while[cite: 8] ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>