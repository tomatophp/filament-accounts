<?php

return [
    "group" => "Accounts",
    "accounts" => [
        "label" => "Accounts",
        "single" => "Account",
        "coulmns" => [
            "id" => "Profile",
            "avatar" => "Avatar",
            "name" => "Name",
            "email" => "Email",
            "phone" => "Phone",
            "type" => "Type",
            "address" => "Address",
            "password" => "Password",
            "password_confirmation" => "Password Confirmation",
            "loginBy" => "Login By",
            "is_active" => "Is Active?",
            "is_login" => "Can Login?"
        ],
        "filters" => [
            "type" => "Type"
        ],
        "actions" => [
            "impersonate" => "Login As",
            "password" => "Change Password",
            "notifications" => "Send Notifications",
            "edit" => "Edit",
            "delete" => "Delete",
            "force_delete" => "Force Delete",
            "restore" => "Restore",
        ],
        "notifications" => [
            "use_notification_template" => "Use Notification Template",
            "template_id" => "Template",
            "image" => "Image",
            "title" => "Title",
            "body" => "Body",
            "action" => "Action",
            "url" => "URL",
            "icon" => "Icon",
            "type" => "Type",
            "providers" => "Send By"
        ]
    ],
    "meta" => [
        "label" => "Metas",
        "single" => "Meta",
        "create" => "Create Meta",
        "columns" => [
            "account" => "Account",
            "key" => "Key",
            "value" => "Value"
        ],
    ],
    "locations" => [
        "label" => "Locations",
        "single" => "Location",
        "create" => "Create Location",
    ],
    "requests" => [
        "label" => "Account Requests",
        "single" => "Account Request",
        "columns" => [
            "account" => "Account",
            "user" => "User",
            "type" => "Type",
            "status" => "Status",
            "is_approved" => "Is Approved?",
            "is_approved_at" => "Is Approved At"
        ],
    ],
    "contacts" => [
        "label" => "Contacts",
        "single" => "Contact",
        "columns" => [
            "type" => "Type",
            "status" => "Status",
            "name" => "Name",
            "email" => "Email",
            "phone" => "Phone",
            "subject" => "Subject",
            "active" => "Active"
        ],
    ],
];
