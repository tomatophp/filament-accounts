<?php

return [
    "group" => "الحسابات",
    "accounts" => [
        "label" => "الحسابات",
        "single" => "حساب",
        "coulmns" => [
            "id" => "المعرف",
            "teams" => "الفرق",
            "avatar" => "صورة الملف الشخصي",
            "name" => "الاسم",
            "email" => "البريد الالكتروني",
            "phone" => "الهاتف",
            "type" => "النوع",
            "address" => "العنوان",
            "password" => "كلمة المرور",
            "password_confirmation" => "تأكيد كلمة المرور",
            "loginBy" => "تسجيل الدخول بواسطة",
            "is_active" => "هل نشط؟",
            "is_login" => "يمكن تسجيل الدخول؟",
            "created_at" => "تم الإنشاء في",
            "updated_at" => "تم التحديث في",
        ],
        "filters" => [
            "type" => "حسب النوع",
            "teams" => "حسب الفريق",
            "is_active" => "هل هو مفعل؟",
            "is_login" => "هل يستطيع تسجيل الدخول؟",
        ],
        "actions" => [
            "teams" => "إدارة الفرق",
            "impersonate" => "تسجيل الدخول",
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
        ],
        "export" => [
            "title" => "تصدير",
            "columns" => "الأعمدة",
        ],
        "import" => [
            "title" => "استيراد",
            "excel" => "ملف اكسيل",
            "hint" => "يرجى تحميل ملف اكسيل لاستيراد الحسابات",
            "success" => 'تم استيراد الحسابات بنجاح',
            "body" => 'تم استيراد الحسابات بنجاح',
            "error" => "خطأ أثناء استيراد الحسابات",
            "error-body" => "حدث خطأ أثناء استيراد الحسابات",
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
    'profile' => [
        'title' => 'تعديل الملف الشخصي',
        'edit' => [
            'title' => 'تعديل المعلومات',
            'description' => 'تحديث معلومات الملف الشخصي وعنوان البريد الإلكتروني الخاص بحسابك.',
            'name' => 'الاسم',
            'email' => 'البريد الإلكتروني',
        ],
        'password' => [
            'title' => 'تغيير كلمة المرور',
            'description' => 'تأكد من أن حسابك يستخدم كلمة مرور طويلة وعشوائية للبقاء آمنًا.',
            'current_password' => 'كلمة المرور الحالية',
            'new_password' => 'كلمة المرور الجديدة',
            'confirm_password' => 'تأكيد كلمة المرور',
        ],
        'browser' => [
            "sessions_last_active"  => "اخر جلسة",
            'browser_section_title' => 'جلسات المتصفح',
            'browser_section_description' => 'إدارة وتسجيل الخروج من جلساتك النشطة على المتصفحات والأجهزة الأخرى.',
            'browser_sessions_log_out' => 'تسجيل الخروج من جلسات المتصفح الأخرى',
            'browser_sessions_confirm_pass' => 'يرجى إدخال كلمة المرور لتأكيد رغبتك في تسجيل الخروج من جلسات المتصفح الأخرى عبر جميع أجهزتك.',
            'password' => 'كلمة المرور',
            'confirm' => 'تأكيد',
            'nevermind' => 'لا بأس',
            'browser_sessions_logout_notification' => 'تم تسجيل الخروج من جلسات المتصفح الخاصة بك.',
            'browser_sessions_logout_failed_notification' => 'كلمة المرور غير صحيحة.',
            'sessions_device' => 'الجهاز',
            'sessions_content' => 'الأجهزة المتصلة',
            'incorrect_password' => 'كلمة المرور التي أدخلتها غير صحيحة.',
        ],
        'delete' => [
            'delete_account' => 'حذف الحساب',
            'delete_account_description' => 'حذف حسابك بشكل دائم.',
            'incorrect_password' => 'كلمة المرور التي أدخلتها غير صحيحة.',
            'are_you_sure' => 'هل أنت متأكد من أنك تريد حذف حسابك؟ بمجرد حذف حسابك، سيتم حذف جميع موارده وبياناته بشكل دائم. يرجى إدخال كلمة المرور لتأكيد رغبتك في حذف حسابك نهائيًا.',
            'yes_delete_it' => 'نعم، احذفه',
            'password' => 'كلمة المرور',
            'delete_account_card_description' => 'بمجرد حذف حسابك، سيتم حذف جميع موارده وبياناته بشكل دائم. قبل حذف حسابك، يرجى تنزيل أي بيانات أو معلومات ترغب في الاحتفاظ بها.',
        ],
        'delete-team' => [
            'title' => 'حذف الفريق',
            'description' => 'حذف فريقك بشكل دائم.',
            'body' => 'بمجرد حذف الفريق، سيتم حذف جميع موارده وبياناته بشكل دائم. قبل حذف هذا الفريق، يرجى تنزيل أي بيانات أو معلومات ترغب في الاحتفاظ بها.',
            'delete' => 'حذف الفريق',
            'delete_account' => 'حذف الفريق',
            'delete_account_description' => 'هل أنت متأكد من أنك تريد حذف فريقك؟ بمجرد حذف فريقك، سيتم حذف جميع موارده وبياناته بشكل دائم. يرجى إدخال كلمة المرور لتأكيد رغبتك في حذف فريقك نهائيًا.',
            'yes_delete_it' => 'نعم، احذفه',
            'password' => 'كلمة المرور',
            'incorrect_password' => 'كلمة المرور التي أدخلتها غير صحيحة.',
            'are_you_sure' => 'هل أنت متأكد من أنك تريد حذف فريقك؟ بمجرد حذف فريقك، سيتم حذف جميع موارده وبياناته بشكل دائم. يرجى إدخال كلمة المرور لتأكيد رغبتك في حذف فريقك نهائيًا.',
        ],
        'token' => [
            'title' => 'رموز API',
            'description' => 'تسمح رموز API للخدمات الخارجية بالمصادقة مع تطبيقنا نيابةً عنك.',
            'name' => 'الاسم',
            'created_at' => 'تم الإنشاء في',
            'expires_at' => 'تنتهي في',
            'abilities' => 'القدرات',
            'action_label' => 'إنشاء رمز',
            'create_notification' => 'تم إنشاء الرمز بنجاح!',
            'modal_heading' => 'إنشاء رمز',
            'empty_state_heading' => 'لا توجد رموز',
            'empty_state_description' => 'إنشاء رمز جديد للمصادقة مع API.',
            'delete_token' => 'حذف الرمز',
            'delete_token_description' => 'هل أنت متأكد من أنك تريد حذف هذا الرمز؟',
            'delete_token_confirmation' => 'نعم، احذفه',
            'delete_token_notification' => 'تم حذف الرمز بنجاح!',
            'modal_heading_2' => 'تم إنشاء الرمز بنجاح',
            'helper_text' => 'يمكنك تعديل الرمز أدناه. تأكد من نسخه الآن، حيث لن تتمكن من رؤيته مرة أخرى.',
            "token" => "الرمز",
        ],
    ],
    'teams' => [
        'title' => 'إعدادات الفريق',
        "actions" => [
            "cancel_invitation" => "إلغاء الدعوة",
            "resend_invitation" => "إعادة ارسال الدعوة",
        ],
        "edit" => [
            "title" => "تعديل إسم الفريق",
            "description" => "تحديث معلومات الفريق وصورة الفريقك.",
            "name" => "الاسم",
            "email" => "البريد الإلكتروني",
            "avatar" => "الصورة الرمزية",
            "save" => "حفظ",
            "owner" => "المالك"
        ],
        "members" => [
            "title" => "دعوة أعضاء الفريق",
            "description" => "إضافة عضو فريق جديد إلى فريقك، مما يسمح له بالتعاون معك.",
            "team-members" => "يرجى تقديم عنوان البريد الإلكتروني للشخص الذي ترغب في إضافته إلى هذا الفريق.",
            "email" => "البريد الإلكتروني",
            "role" => "الدور",
            "send_invitation" => "إرسال الدعوة",
            "cancel" => "إلغاء",
            "not_in" => "عنوان البريد الإلكتروني هو بالفعل عضو في الفريق.",
            "required" => "حقل البريد الإلكتروني مطلوب.",
            "unique" => "عنوان البريد الإلكتروني هو بالفعل عضو في الفريق.",
            "role_required" => "حقل الدور مطلوب.",
            "notifications" => [
                "title" => "دعوة عضو فريق",
                "body" => "لقد تمت دعوتك للانضمام إلى فريق :team.",
                "accept" => "قبول الدعوة",
                "cancel" => "إلغاء الدعوة"
            ],
            "leave_team" => "مغادرة الفريق",
            "remove_member" => "إزالة عضو",
            "manage_role" => "إدارة الدور",
            "list" => [
                "title" => "أعضاء الفريق",
                "description" => "جميع الأشخاص الذين هم جزء من هذا الفريق.",
            ]
        ],
        "delete" => [
            "title" => "حذف الفريق",
            "description" => "حذف فريقك بشكل دائم.",
            "body" => "بمجرد حذف فريق، سيتم حذف جميع موارده وبياناته بشكل دائم. قبل حذف هذا الفريق، يرجى تنزيل أي بيانات أو معلومات تتعلق بهذا الفريق التي ترغب في الاحتفاظ بها.",
            "delete" => "حذف الفريق",
            "delete_account" => "حذف الفريق",
            "delete_account_description" => "هل أنت متأكد أنك تريد حذف فريقك؟ بمجرد حذف فريقك، سيتم حذف جميع موارده وبياناته بشكل دائم. يرجى إدخال كلمة المرور الخاصة بك لتأكيد أنك ترغب في حذف فريقك بشكل دائم.",
            "yes_delete_it" => "نعم، احذفه",
            "password" => "كلمة المرور",
            "incorrect_password" => "كلمة المرور التي أدخلتها غير صحيحة.",
            "are_you_sure" => "هل أنت متأكد أنك تريد حذف فريقك؟ بمجرد حذف فريقك، سيتم حذف جميع موارده وبياناته بشكل دائم. يرجى إدخال كلمة المرور الخاصة بك لتأكيد أنك ترغب في حذف فريقك بشكل دائم.",
        ],
    ],
    "team" => [
        "title" => "الفرق",
        "single" => "فريق",
        "columns" => [
            "avatar" => "الشعار",
            "name" => "الاسم",
            "owner" => "المالك",
            "personal_team" => "فريق شخصي",
        ],
    ],
    "roles" => [
        "admin" => [
            "name" => "مدير النظام",
            "description" => "مدير النظام يمكنه إدارة النظام بالكامل."
        ],
        "user" =>[
            "name" =>  "مستخدم",
            "description" => "مستخدم عادي يمكنه القراءة والتحديث."
        ],
    ],
    "login" => [
        "active" => "عفواً برجاء تاكيد الحساب اولاً ثم اعادة تسجيل الدخول"
    ],

    "settings" => [
        "types" => [
            "title" => "أنواع الحسابات",
        ]
    ],

    "address" => [
        "title" => "تعديل العناوين",
    ],

    "account-requests" => [
        "title" => "طلبات الحساب",
        "status" => "الحالة",
        "types" => "النوع",
        "button" => "تعديل الانواع والحالات"
    ],

    "contact-us" => [
        "footer" => "هل لديك اي مشكلة؟ او تحتاج الى مساعدة؟",
        "modal" => 'برجاء مليء هذا النموذج للتواصل معانا',
        "label" => "تواصل معنا",
        "form" => [
            "name" => "الاسم",
            "email" => "البريد الالكتروني",
            "phone" => "الهاتف",
            "subject" => "الموضوع",
            "message" => "الرسالة",
        ],
        "notification" => [
            "title" => "عملية ناجحة",
            "body" => "تم ارسال الرسالة بنجاح",
        ]
    ]
];
