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

// Създаване на акаунт
$lang['account_creation_successful'] = 'Акаунтът е създаден успешно';
$lang['account_creation_unsuccessful'] = 'Невъзможно създаване на акаунт';
$lang['account_creation_duplicate_email'] = 'Имейл вече използван или невалиден';
$lang['account_creation_duplicate_identity'] = 'Самоличност, вече използвана или невалидна';
$lang['account_creation_missing_default_group'] = 'Групата по подразбиране не е зададена';
$lang['account_creation_invalid_default_group'] = 'Невалиден набор от име на група по подразбиране';


// Парола
$lang['password_change_successful'] = 'Паролата е успешно променена';
$lang['password_change_unsuccessful'] = 'Невъзможно промяна на парола';
$lang['Forgot_password_successful'] = 'Изпращане на парола за изпращане на имейл';
$lang['borav_password_unsuccessful '] =' Невъзможно задаване на парола ';

// Активиране
$lang['activate_successful'] = 'Активиран акаунт';
$lang['activate_unsuccessful'] = 'Невъзможно активиране на акаунта';
$lang['deaktiviraj_successful'] = 'Активиран акаунт';
$lang['deaktiviraj_unsuccessful'] = 'Невъзможно деактивиране на акаунт';
$lang['activation_email_successful'] = 'Изпратен имейл за активиране';
$lang['activation_email_unsuccessful'] = 'Невъзможно изпращане на имейл за активиране';

// Вход / Изход
$lang['login_successful'] = 'Влезхте успешно';
$lang['login_unsuccessful'] = 'Неправилно влизане';
$lang['login_unsuccessful_not_active'] = 'Акаунтът е неактивен';
$lang['login_timeout'] = 'Временно заключена. Опитайте отново по-късно.';
$lang['logout_successful'] = 'Излизане успешно';

// Промени в акаунта
$lang['update_successful'] = 'Информацията за акаунта успешно актуализирана';
$lang['update_unsuccessful'] = 'Невъзможно актуализиране на информацията за акаунта';
$lang['delete_successful'] = 'Потребителят е изтрит';
$lang['delete_unsuccessful'] = 'Невъзможно изтриване на потребителя';

// Групи
$lang['group_creation_successful'] = 'Групата е създадена успешно';
$lang['group_already_exists'] = 'Име на групата вече е взето';
$lang['group_update_successful'] = 'Подробности за групата са актуализирани';
$lang['group_delete_successful'] = 'Групата е изтрита';
$lang['group_delete_unsuccessful'] = 'Невъзможно изтриване на група';
$lang['group_delete_notallowed'] = 'Не мога да изтрия администраторите \' group ';
$lang['group_name_required'] = 'Името на групата е задължително поле';
$lang['group_name_admin_not_alter'] = 'Името на администраторската група не може да бъде променено';

// Имейл за активиране
$lang['email_activation_subject'] = 'Активиране на акаунт';
$lang['email_activate_heading'] = 'Активиране на акаунт за% s';
$lang['email_activate_subheading'] = 'Моля, кликнете върху тази връзка към% s.';
$lang['email_activate_link'] = 'Активирайте акаунта си';

// Забравена парола
$lang['email_forgotten_password_subject'] = 'Проверка на забравена парола';
$lang['email_forgot_password_heading'] = 'Нулиране на парола за% s';
$lang['email_forgot_password_subheading'] = 'Моля, щракнете върху тази връзка към% s.';
$lang['email_forgot_password_link'] = 'Възстановяване на паролата ви';

// Нов имейл с парола
$lang['email_new_password_subject'] = 'Нова парола';
$lang['email_new_password_heading'] = 'Нова парола за% s';
$lang['email_new_password_subheading'] = 'Паролата ви е възстановена до:% s';