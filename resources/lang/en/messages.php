<?php

return [
    "group" => "Accounts",
    "accounts" => [
        "label" => "Accounts",
        "single" => "Account",
        "coulmns" => [
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
            "password" => "Change Password",
            "notifications" => "Send Notifications",
            "edit" => "Edit",
            "delete" => "Delete",
            "force_delete" => "Force Delete",
            "restore" => "Restore",
        ]
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
