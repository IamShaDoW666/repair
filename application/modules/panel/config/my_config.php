<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| CI Bootstrap 3 Configuration
| -------------------------------------------------------------------------
| This file lets you define default values to be passed into views 
| when calling MY_Controller's render() function. 
| 
| See example and detailed explanation from:
| 	/application/config/ci_bootstrap_example.php
*/

$config['my_config'] = array(

	// Site name
	'site_name' => 'Repairer',

	// Default page title prefix
	'page_title_prefix' => '',

	// Default page title
	'page_title' => '',

	// Default meta data
	'meta_data'	=> array(
		'author'		=> '',
		'description'	=> '',
		'keywords'		=> ''
	),
	
	

	// Default CSS class for <body> tag
	'body_class' => 'hold-transition sidebar-mini layout-fixed',
	
	// Menu items
	'menu' => array(
		'welcome' => array(
			'name'		=> 'home',
			'url'		=> 'welcome/index',
			'icon'		=> 'fas fa-tachometer-alt',
			'icon_material'		=> 'dashboard',
		),
		'reparation' => array(
			'name'		=> 'repair/index',
			'url'		=> 'reparation',
			'icon'		=> 'fas fa-list-alt',
			'icon_material'		=> 'list',
		),

		'customers' => array(
			'name'		=> 'customers/index',
			'url'		=> 'customers',
			'icon'		=> 'fas fa-users',
			'icon_material'		=> 'people',
		),

		'inventory' => array(
			'name'		=> 'inventory',
			'url'		=> 'inventory',
			'icon'		=> 'fa fa-tasks',
			'icon_material'		=> 'shopping_basket',
			'children'  => array(
				'inventory/index'	=> 'inventory',
				'inventory/add'	=> 'inventory/add',
				'inventory/suppliers'	=> 'inventory/suppliers',
				'inventory/manufacturers'	=> 'inventory/manufacturers',
				'inventory/models'	=> 'inventory/models',
			)
		),

		'pos' => array(
			'name'		=> 'pos/index',
			'url'		=> 'pos',
			'icon'		=> 'fa fa-desktop',
			'icon_material'		=> 'shopping_basket',

		),


		'purchases' => array(
			'name'		=> 'purchases',
			'url'		=> 'purchases',
			'icon'		=> 'fa fa-tasks',
			'icon_material'		=> 'list',
			'children'  => array(
				'purchases/index'	=> 'purchases',
				'purchases/add'	=> 'purchases/add',
			)
		),

		'reports' => array(
			'name'		=> 'reports',
			'url'		=> 'reports',
			'icon'		=> 'fas fa-chart-pie',
			'icon_material'		=> 'donut_small',
			'children'  => array(
				'reports/stock'			=> 'reports/stock',
				'reports/finance'		=> 'reports/finance',
				'reports/quantity_alerts'		=> 'reports/quantity_alerts',
				'logs/index'		=> 'log/index',
			)
		),


		'settings' => array(
			'name'		=> 'settings/index',
			'url'		=> 'settings',
			'icon'		=> 'fa fa-cog',
			'icon_material'		=> 'settings',
			'children'  => array(
				'settings/index'			=> 'settings/index',
				'sms_gateways'			=> 'settings/sms_gateways',
				'auth/index'			=> 'auth/index',
				'auth/user_groups'			=> 'auth/user_groups',
				'repair_statuses/index'			=> 'settings/repair_statuses',
				'tax_rates/index' => 'settings/tax_rates',
				'categories/index' => 'settings/categories',
				'utilities/index' => 'utilities/list_db',
				'errors/index'			=> 'errors/index',
			)
		),
		
	),

	// Login page
	'login_url' => 'panel/login',

	
	// AdminLTE settings
	'adminlte' => array(
		'body_class' 	=> array(
			'admin'	=> 'skin-purple',
		)
	),

	// Debug tools
	'debug' => array(
		'view_data'	=> FALSE,
		'profiler'	=> FALSE
	),
);

/*
| -------------------------------------------------------------------------
| Override values from /application/config/config.php
| -------------------------------------------------------------------------
*/
$config['sess_cookie_name'] = 'ci_session_admin';