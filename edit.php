<!DOCTYPE html>
<!-- تحديد لغة الصفحة العربية واتجاه النص من اليمين لليسار -->
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <!-- استدعاء مكتبة Bootstrap لتنسيق العناصر وجعل التصميم متجاوباً[cite: 2] -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- ربط ملف التنسيق الخارجي الخاص بالصالون[cite: 2] -->
    <link rel="stylesheet" href="salon-style.css"> 
    <style>
        /* تنسيقات إضافية مخصصة */
        body { background-color: #fcecef; } /* ضبط لون خلفية الصفحة[cite: 2] */
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); } /* تنسيق بطاقة النموذج[cite: 2] */
        .btn-primary { background-color: #d6989f !important; } /* تحديد لون الزر الأساسي[cite: 2] */
    </style>
</head>
<body>
<!-- حاوية رئيسية بحد أقصى للعرض 400 بكسل لتوسيط النموذج[cite: 2] -->
<div class="container mt-5" style="max-width: 400px;">
    <div class="card p-4">
        <h3 class="text-center mb-4">تعديل الموعد</h3>
        <!-- نموذج إرسال البيانات للمعالجة في نفس الصفحة -->
        <form method="POST">
            <!-- حقل التاريخ، يتم جلب القيمة الحالية من قاعدة البيانات[cite: 2] -->
            <input type="date" name="date" class="form-control mb-3" value="<?php echo $row['appointment_date']; ?>" required>
            <!-- حقل الوقت، يتم جلب القيمة الحالية من قاعدة البيانات[cite: 2] -->
            <input type="time" name="time" class="form-control mb-3" value="<?php echo $row['appointment_time']; ?>" required>
            <!-- زر حفظ التعديلات عند الضغط عليه يتم إرسال النموذج[cite: 2] -->
            <button type="submit" name="update" class="btn btn-primary w-100">حفظ التعديلات</button>
            <!-- رابط للعودة لصفحة المواعيد دون حفظ أي تغييرات[cite: 2] -->
            <a href="my_appointments.php" class="btn btn-secondary w-100 mt-2">إلغاء</a>
        </form>
    </div>
</div>
</body>
</html>