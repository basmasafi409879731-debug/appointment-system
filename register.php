<?php
// سطر 2: تضمين ملف الاتصال بقاعدة البيانات (db.php) للتمكن من تنفيذ أوامر الاستعلام[cite: 9]
include 'db.php'; 

// سطر 4: التحقق مما إذا تم إرسال النموذج عبر الضغط على زر "تسجيل الحساب"[cite: 9]
if (isset($_POST['register'])) {
    
    // سطر 6-7: استخدام دالة mysqli_real_escape_string لتنظيف البيانات المدخلة من رموز SQL الخطيرة لمنع ثغرات الحقن[cite: 9]
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // سطر 10: تشفير كلمة المرور باستخدام دالة password_hash مع خوارزمية PASSWORD_DEFAULT لضمان تخزينها بشكل آمن ومبهم في قاعدة البيانات[cite: 9]
    $pass_secure = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // سطر 13: تنفيذ استعلام SELECT للبحث في جدول المستخدمين (users) عما إذا كان اسم المستخدم أو الإيميل موجودين مسبقاً[cite: 9]
    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' OR email='$email'");
    
    // سطر 15: التحقق مما إذا كان الاستعلام قد أعاد أي نتائج (أي وجود مستخدم بنفس البيانات)[cite: 9]
    if (mysqli_num_rows($check) > 0) {
        // سطر 16: في حال وجود تطابق، يتم عرض تنبيه للمستخدم وإيقاف عملية التسجيل[cite: 9]
        echo "<script>alert('هذا الحساب مسجل مسبقاً بقاعدة البيانات!');</script>";
    } else {
        // سطر 19: في حال كانت البيانات جديدة، نقوم بإدخال السجل الجديد في قاعدة البيانات مع تعيين الصلاحية الافتراضية 'user'[cite: 9]
        mysqli_query($conn, "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$pass_secure', 'user')");
        // سطر 20: إظهار تنبيه بنجاح العملية ثم إعادة توجيه المستخدم لصفحة تسجيل الدخول[cite: 9]
        echo "<script>alert('تم إنشاء حسابكِ بنجاح!'); window.location='login.php';</script>";
    }
}
?>

<!-- سطر 24-30: بداية كود HTML لتعريف الصفحة وتنسيقها[cite: 9] -->
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إنشاء حساب جديد</title>
    <!-- استدعاء ملفات Bootstrap لضمان تجاوب الصفحة وتنسيقها بشكل مريح[cite: 9] -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="salon-style.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    <!-- سطر 33: حاوية بطاقة تسجيل الحساب (Card) لتوسيط النموذج في الشاشة[cite: 9] -->
    <div class="card p-4 shadow-sm" style="width: 380px; border-radius: 12px;">
        <h3 class="text-center text-success mb-4">إنشاء حساب جديد ✨</h3>
        
        <!-- سطر 36: نموذج التسجيل الذي يرسل البيانات لنفس الصفحة (register.php) عبر POST[cite: 9] -->
        <form action="register.php" method="POST">
            <!-- سطر 38-46: حقول إدخال اسم المستخدم، البريد الإلكتروني، وكلمة المرور[cite: 9] -->
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="اسم المستخدم الخاص بكِ" required>
            </div>
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="البريد الإلكتروني" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="كلمة المرور" required>
            </div>
           <!-- سطر 47: زر إرسال النموذج[cite: 9] -->
           <button type="submit" name="register" class="btn btn-primary w-100">تسجيل الحساب</button>
            <!-- سطر 48: رابط اختياري للانتقال لصفحة تسجيل الدخول[cite: 9] -->
            <a href="login.php" class="d-block text-center text-muted small">لديكِ حساب بالفعل؟ سجلي دخولكِ</a>
        </form>
    </div>
</body>
</html>