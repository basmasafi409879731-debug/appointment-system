<?php
// 1. بدء الجلسة لحفظ بيانات المستخدم في المتصفح بعد تسجيل الدخول بنجاح[cite: 5]
session_start(); 
// 2. تضمين ملف الاتصال بقاعدة البيانات للوصول إلى جداول المستخدمين[cite: 5]
include 'db.php'; 

// 3. التحقق مما إذا تم إرسال نموذج تسجيل الدخول عبر طريقة POST[cite: 5]
if (isset($_POST['login'])) {
    // تنظيف المدخلات من رموز SQL الخاصة لمنع ثغرات الحقن (SQL Injection)[cite: 5]
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // استعلام لجلب سجل المستخدم من قاعدة البيانات بناءً على الاسم المدخل[cite: 5]
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    
    // التأكد من وجود مستخدم بهذا الاسم[cite: 5]
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // التحقق من صحة كلمة المرور المدخلة مقارنة بالمشفرة في قاعدة البيانات[cite: 5]
        if (password_verify($password, $user['password'])) {
            // حفظ بيانات المستخدم في الجلسة لاستخدامها في الصفحات الأخرى[cite: 5]
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; // تخزين نوع الصلاحية (admin أو user)[cite: 5]

            // توجيه المستخدم حسب نوع صلاحيته[cite: 5]
            if ($_SESSION['role'] == 'admin') {
                header("Location: manage_appointments.php"); // الأدمن يذهب للوحة التحكم[cite: 5]
            } else {
                header("Location: index.php"); // الزبونة تذهب للصفحة الرئيسية[cite: 5]
            }
            exit(); // إنهاء تنفيذ الكود لضمان التوجيه[cite: 5]
        }
    }
    // رسالة تنبيه في حال كان اسم المستخدم أو كلمة المرور غير صحيحة[cite: 5]
    echo "<script>alert('اسم المستخدم أو كلمة المرور غير صحيحة!');</script>";
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول</title>
    <!-- استدعاء Bootstrap و ملف التنسيق الخاص بالصالون[cite: 5] -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="salon-style.css"> 
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    <!-- بطاقة النموذج لتسجيل الدخول[cite: 5] -->
    <div class="card p-4 shadow-sm" style="width: 380px; border-radius: 12px;">
        <h3 class="text-center text-primary mb-4">تسجيل الدخول ✨</h3>
        <form action="login.php" method="POST">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="اسم المستخدم" required>
            </div>
            <div class="mb-3">
                <!-- حقل كلمة المرور مخفي لضمان السرية[cite: 5] -->
               <input type="password" name="password" class="form-control" placeholder="كلمة المرور" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100 mb-2">دخول</button>
            <a href="register.php" class="d-block text-center text-muted small">إنشاء حساب جديد</a>
        </form>
    </div>
</body>
</html>