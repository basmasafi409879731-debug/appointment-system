-- سطر 2: إنشاء قاعدة بيانات جديدة باسم 'appointment_system' إذا لم تكن موجودة مسبقاً[cite: 11]
CREATE DATABASE IF NOT EXISTS appointment_system;
-- سطر 3: تحديد قاعدة البيانات هذه لاستخدامها في تنفيذ الأوامر التالية[cite: 11]
USE appointment_system;

-- سطر 6-11: إنشاء جدول 'users' للمستخدمين[cite: 11]
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY, -- معرف فريد لكل مستخدم، يزداد تلقائياً[cite: 11]
    username VARCHAR(50) NOT NULL,    -- اسم المستخدم (نص بحد أقصى 50 حرفاً)، لا يمكن تركه فارغاً[cite: 11]
    password VARCHAR(255) NOT NULL,   -- حقل كلمة المرور (مساحة كبيرة لتخزين التشفير)، لا يمكن تركه فارغاً[cite: 11]
    role ENUM('admin', 'user') DEFAULT 'user' -- تحديد صلاحية المستخدم (أدمن أو زبونة)، والقيمة الافتراضية 'user'[cite: 11]
);

-- سطر 14-19: إنشاء جدول 'services' للخدمات[cite: 11]
CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY, -- معرف الخدمة[cite: 11]
    service_name VARCHAR(100) NOT NULL, -- اسم الخدمة[cite: 11]
    price DECIMAL(10, 2) NOT NULL,      -- سعر الخدمة (عدد عشري بدقة 10 أرقام، منها 2 للكسور)[cite: 11]
    image_path VARCHAR(255)             -- مسار تخزين صورة الخدمة[cite: 11]
);

-- سطر 22-26: إنشاء جدول 'employees' للموظفين[cite: 11]
CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY, -- معرف الموظف[cite: 11]
    name VARCHAR(100) NOT NULL         -- اسم الموظف[cite: 11]
);

-- سطر 29-40: إنشاء جدول 'appointments' للمواعيد مع ربط العلاقات (Foreign Keys)[cite: 11]
CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,                       -- معرف الزبونة[cite: 11]
    service_id INT,                    -- معرف الخدمة المحجوزة[cite: 11]
    employee_id INT,                   -- معرف الموظف المسؤول[cite: 11]
    appointment_date DATE,             -- تاريخ الموعد[cite: 11]
    appointment_time TIME,             -- وقت الموعد[cite: 11]
    status ENUM('Pending', 'Confirmed', 'Cancelled') DEFAULT 'Pending', -- حالة الحجز الافتراضية 'قيد الانتظار'[cite: 11]
    -- ربط الحقول بالجداول الأصلية، مع حذف المواعيد تلقائياً عند حذف المستخدم أو الخدمة[cite: 11]
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE
);

-- سطر 43-44: إضافة بيانات تجريبية أولية لضمان عمل واجهات الموقع فور التشغيل[cite: 11]
INSERT INTO services (id, service_name, price, image_path) VALUES (1, 'قص شعر', 50.00, 'hair.jpg');
INSERT INTO employees (id, name) VALUES (1, 'الموظف الأول');