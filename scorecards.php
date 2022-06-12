<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: scorecards
Description: Default module for defining scorecards
Version: 1.0.1
Requires at least: 2.3.*
*/

define('SCORECARDS_MODULE_NAME', 'scorecards');
define('SCORECARD_ATTACHMENTS_FOLDER', 'uploads/scorecards/');

hooks()->add_filter('before_scorecard_updated', '_format_data_scorecard_feature');
hooks()->add_filter('before_scorecard_added', '_format_data_scorecard_feature');

hooks()->add_action('after_cron_run', 'scorecards_notification');
hooks()->add_action('admin_init', 'scorecards_module_init_menu_items');
hooks()->add_action('admin_init', 'scorecards_permissions');
//hooks()->add_action('clients_init', 'scorecards_clients_area_menu_items');

hooks()->add_action('staff_member_deleted', 'scorecards_staff_member_deleted');

hooks()->add_action('after_scorecard_updated', 'scorecard_create_assigned_qrcode');

hooks()->add_filter('migration_tables_to_replace_old_links', 'scorecards_migration_tables_to_replace_old_links');
//hooks()->add_filter('get_dashboard_widgets', 'scorecards_add_dashboard_widget');
hooks()->add_filter('module_scorecards_action_links', 'module_scorecards_action_links');

hooks()->add_action('task_status_changed','scorecards_task_status_changed');

/*
function scorecards_add_dashboard_widget($widgets)
{
    
    $widgets[] = [
        'path'      => 'scorecards/widgets/scorecard_this_week',
        'container' => 'left-8',
    ];

    return $widgets;

}
*/

function scorecards_staff_member_deleted($data)
{
    $CI = &get_instance();
    $CI->db->where('staff_id', $data['id']);
    $CI->db->update(db_prefix() . 'scorecards', [
            'staff_id' => $data['transfer_data_to'],
        ]);
}

function scorecards_migration_tables_to_replace_old_links($tables)
{
    $tables[] = [
                'table' => db_prefix() . 'scorecards',
                'field' => 'description',
            ];

    return $tables;
}

function scorecards_permissions()
{
    $capabilities = [];

    $capabilities['capabilities'] = [
            'view'   => _l('permission_view') . '(' . _l('permission_global') . ')',
            'create' => _l('permission_create'),
            'edit'   => _l('permission_edit'),
            'delete' => _l('permission_delete'),
    ];

    register_staff_capabilities('scorecards', $capabilities, _l('scorecards'));
}


/**
* Register activation module hook
*/
register_activation_hook(SCORECARDS_MODULE_NAME, 'scorecards_module_activation_hook');

function scorecards_module_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}

/**
* Register deactivation module hook
*/
register_deactivation_hook(SCORECARDS_MODULE_NAME, 'scorecards_module_deactivation_hook');

function scorecards_module_deactivation_hook()
{

     log_activity( 'Hello, world! . scorecards_module_deactivation_hook ' );
}

//hooks()->add_action('deactivate_' . $module . '_module', $function);

/**
* Register language files, must be registered if the module is using languages
*/
register_language_files(SCORECARDS_MODULE_NAME, [SCORECARDS_MODULE_NAME]);

/**
 * Init scorecards module menu items in setup in admin_init hook
 * @return null
 */
function scorecards_module_init_menu_items()
{
    $CI = &get_instance();

    $CI->app->add_quick_actions_link([
            'name'       => _l('scorecard'),
            'url'        => 'scorecards',
            'permission' => 'scorecards',
            'position'   => 57,
            ]);

    if (has_permission('scorecards', '', 'view')) {
        $CI->app_menu->add_sidebar_menu_item('scorecards', [
                'slug'     => 'scorecards-tracking',
                'name'     => _l('scorecards'),
                'collapse' => true, // Indicates that this item will have submitems
                'icon'     => 'fa fa-hourglass-half',
                'href'     => admin_url('scorecards'),
                'position' => 2,
        ]);
    }
    if (has_permission('scorecards', '', 'view')) {
    $CI->app_menu->add_sidebar_children_item('scorecards', [
                'slug'     => 'scorecards-clients-recapitulation-thisweek',
                'name'     => _l('this_week'),
                'icon'     => 'fa fa-hourglass',
                'href'     => admin_url('scorecards/client_recapitulation_this_week'),
                'position' => 8,
        ]);
    }
    if (has_permission('scorecards', '', 'view')) {
    $CI->app_menu->add_sidebar_children_item('scorecards', [
                'slug'     => 'scorecards-clients-recapitulation',
                'name'     => _l('scorecards_clients_recapitulation'),
                'icon'     => 'fa fa-hourglass',
                'href'     => admin_url('scorecards/clients_recapitulation'),
                'position' => 8,
        ]);
    }
    if (has_permission('scorecards', '', 'view')) {
    $CI->app_menu->add_sidebar_children_item('scorecards', [
                'slug'     => 'scorecards-company-recapitulation',
                'name'     => _l('scorecards_company_recapitulation'),
                'icon'     => 'fa fa-hourglass',
                'href'     => admin_url('scorecards/company_recapitulation'),
                'position' => 9,
        ]);
    }
    if (has_permission('scorecards', '', 'view')) {
    $CI->app_menu->add_sidebar_children_item('scorecards', [
                'slug'     => 'scorecards-task-recapitulation',
                'name'     => _l('scorecards_task_recapitulation'),
                'icon'     => 'fa fa-hourglass',
                'href'     => admin_url('scorecards/task_recapitulation'),
                'position' => 10,
        ]);
    }
    if (has_permission('scorecards', '', 'view')) {
    $CI->app_menu->add_sidebar_children_item('scorecards', [
                'slug'     => 'scorecards-task-duration',
                'name'     => _l('scorecards_task_duration'),
                'icon'     => 'fa fa-hourglass-half',
                'href'     => admin_url('scorecards/task_duration'),
                'position' => 11,
        ]);
    }
    if (has_permission('scorecards', '', 'view')) {
    $CI->app_menu->add_sidebar_children_item('scorecards', [
                'slug'     => 'scorecards-task-history',
                'name'     => _l('scorecards_task_history'),
                'icon'     => 'fa fa-hourglass-half',
                'href'     => admin_url('scorecards/task_history'),
                'position' => 11,
        ]);
    }
    if (has_permission('scorecards', '', 'create')) {
    $CI->app_menu->add_sidebar_children_item('scorecards', [
                'slug'     => 'scorecards-task-import',
                'name'     => _l('scorecards_task_import'),
                'icon'     => 'fa fa-hourglass-half',
                'href'     => admin_url('scorecards/task_import'),
                'position' => 11,
        ]);
    }
}

function module_scorecards_action_links($actions)
{
    $actions[] = '<a href="' . admin_url('settings?group=scorecards') . '">' . _l('settings') . '</a>';

    return $actions;
}

/**
 * [perfex_dark_theme_settings_tab net menu item in setup->settings]
 * @return void
 */
function scorecards_settings_tab()
{
    $CI = &get_instance();
    $CI->app_tabs->add_settings_tab('scorecards', [
        'name'     => _l('settings_group_scorecards'),
        'view'     => 'scorecards/scorecards_settings',
        'position' => 52,
    ]);
}

$CI = &get_instance();
$CI->load->helper(SCORECARDS_MODULE_NAME . '/scorecards');

if(($CI->uri->segment(0)=='admin' && $CI->uri->segment(1)=='scorecards') || $CI->uri->segment(1)=='scorecards'){
    $CI->app_css->add(SCORECARDS_MODULE_NAME.'-css', base_url('modules/'.SCORECARDS_MODULE_NAME.'/assets/css/'.SCORECARDS_MODULE_NAME.'.css'));
    $CI->app_scripts->add(SCORECARDS_MODULE_NAME.'-js', base_url('modules/'.SCORECARDS_MODULE_NAME.'/assets/js/'.SCORECARDS_MODULE_NAME.'.js'));
}

