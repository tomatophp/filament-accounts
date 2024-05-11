<?php

return [
    "group" => "الحسابات",
    "accounts" => [
        "label" => "الحسابات",
        "single" => "حساب",
        "coulmns" => [
            "name" => "الاسم",
            "email" => "البريد الالكتروني",
            "phone" => "الهاتف",
            "type" => "النوع",
            "address" => "العنوان",
            "password" => "كلمة المرور",
            "password_confirmation" => "تأكيد كلمة المرور",
            "loginBy" => "تسجيل الدخول بواسطة",
            "is_active" => "هل نشط؟",
            "is_login" => "يمكن تسجيل الدخول؟"
        ],
        "filters" => [
            "type" => "حسب النوع"
        ],
        "actions" => [
            "password" => "تغيير كلمة المرور",
            "notifications" => "إرسال الإشعارات",
            "edit" => "تعديل",
            "delete" => "حذف",
            "force_delete" => "حذف نهائي",
            "restore" => "استعادة",
        ],
        "notifications" => [
            "use_notification_template" => "استخدام قالب الإشعارات",
            "template_id" => "القالب",
            "image" => "الصورة",
            "title" => "العنوان",
            "body" => "النص",
            "action" => "العملية",
            "url" => "الرابط",
            "icon" => "الأيقونة",
            "type" => "النوع",
            "providers" => "ارسال عن طريق"
        ]
    ],
    "meta" => [
        "label" => "المعلومات",
        "single" => "معلومة",
        "create" => "إضافة معلومة",
        "columns" => [
            "account" => "الحساب",
            "key" => "المفتاح",
            "value" => "القيمة"
        ],
    ],
    "locations" => [
        "label" => "المواقع",
        "single" => "موقع",
        "create" => "إضافة موقع",
    ],
    "requests" => [
        "label" => "طلبات الحساب",
        "single" => "طلب للحساب",
        "columns" => [
            "account" => "الحساب",
            "user" => "المستخدم",
            "type" => "النوع",
            "status" => "الحالة",
            "is_approved" => "هل تم الموافقة؟",
            "is_approved_at" => "تمت الموافقة في"
        ],
    ],
    "contacts" => [
        "label" => "اتصل بنا",
        "single" => "اتصال",
        "columns" => [
            "type" => "النوع",
            "status" => "الحالة",
            "name" => "الاسم",
            "email" => "البريد الالكتروني",
            "phone" => "الهاتف",
            "subject" => "الموضوع",
            "active" => "نشط"
        ],
    ],
];
