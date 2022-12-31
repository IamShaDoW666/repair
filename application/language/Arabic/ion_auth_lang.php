<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth Lang - English
*
* Author: Ben Edmunds
*         ben.edmunds@gmail.com
*         @benedmunds
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  03.14.2010
*
* Description:  English language file for Ion Auth messages and errors
*
*/

// Account Creation
$lang['account_creation_successful']            = 'تم إنشاء الحساب بنجاح';
$lang['account_creation_unsuccessful']          = 'تعذر إنشاء حساب';
$lang['account_creation_duplicate_email']       = 'البريد الإلكتروني مستخدم بالفعل أو غير صالح';
$lang['account_creation_duplicate_identity']    = 'هوية مستعملة مسبقا أو غير صالحة';
$lang['account_creation_missing_default_group'] = 'لم يتم تعيين المجموعة الافتراضية';
$lang['account_creation_invalid_default_group'] = 'اسم مجموعة افتراضي غير صالح';


// Password
$lang['password_change_successful']          = 'تم تغيير كلمة المرور بنجاح';
$lang['password_change_unsuccessful']        = 'تعذر تغيير كلمة المرور';
$lang['forgot_password_successful']          = 'تم إرسال بريد إلكتروني لإعادة تعيين كلمة المرور';
$lang['forgot_password_unsuccessful']        = 'غير قادر على إعادة تعيين كلمة المرور';

// Activation
$lang['activate_successful']                 = 'تم تفعيل الحساب';
$lang['activate_unsuccessful']               = 'تعذر تنشيط الحساب';
$lang['deactivate_successful']               = 'تم تعطيل الحساب';
$lang['deactivate_unsuccessful']             = 'تعذر تعطيل الحساب';
$lang['activation_email_successful']         = 'تم إرسال بريد التفعيل';
$lang['activation_email_unsuccessful']       = 'غير قادر على إرسال بريد إلكتروني للتنشيط';

// Login / Logout
$lang['login_successful']                    = 'تم تسجيل الدخول بنجاح';
$lang['login_unsuccessful']                  = 'تسجيل دخول خاطئ';
$lang['login_unsuccessful_not_active']       = 'الحساب غير نشط';
$lang['login_timeout']                       = 'مغلق مؤقتًا. حاول مرة أخرى في وقت لاحق.';
$lang['logout_successful']                   = 'تم تسجيل الخروج بنجاح';

// Account Changes
$lang['update_successful']                   = 'تم تحديث معلومات الحساب بنجاح';
$lang['update_unsuccessful']                 = 'تعذر تحديث معلومات الحساب';
$lang['delete_successful']                   = 'تم حذف المستخدم';
$lang['delete_unsuccessful']                 = 'تعذر حذف المستخدم';

// Groups
$lang['group_creation_successful']           = 'تم إنشاء المجموعة بنجاح';
$lang['group_already_exists']                = 'اسم المجموعة محجوز بالفعل';
$lang['group_update_successful']             = 'تم تحديث تفاصيل المجموعة';
$lang['group_delete_successful']             = 'تم حذف المجموعة';
$lang['group_delete_unsuccessful']           = 'تعذر حذف المجموعة';
$lang['group_delete_notallowed']             = 'لا يمكن حذف مجموعة المسؤولين';
$lang['group_name_required']                 = 'اسم المجموعة هو حقل مطلوب';
$lang['group_name_admin_not_alter']          = 'لا يمكن تغيير اسم مجموعة المسؤول';

// Activation Email
$lang['email_activation_subject']            = 'تفعيل الحساب';
$lang['email_activate_heading']              = 'تنشيط الحساب لـ %s';
$lang['email_activate_subheading']           = 'الرجاء الضغط على هذا الرابط ل %s.';
$lang['email_activate_link']                 = 'فعل حسابك';

// Forgot Password Email
$lang['email_forgotten_password_subject']    = 'نسيت كلمة المرور';
$lang['email_forgot_password_heading']       = 'إعادة تعيين كلمة المرور لـ %s';
$lang['email_forgot_password_subheading']    = 'الرجاء الضغط على هذا الرابط ل %s.';
$lang['email_forgot_password_link']          = 'اعد ضبط كلمه السر';

// New Password Email
$lang['email_new_password_subject']          = 'كلمة مرور جديدة';
$lang['email_new_password_heading']          = 'كلمة مرور جديدة لـ %s';
$lang['email_new_password_subheading']       = 'تمت إعادة تعيين كلمة المرور الخاصة بك إلى: %s';
