<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    db_prefix() . 'tasks.name',
    db_prefix() . 'projects.name',
    db_prefix() . 'scorecards_tasks_duration.firstname',
    db_prefix() . 'scorecards_tasks_duration.dateadded',
    db_prefix() . 'scorecards_tasks_duration.datefinished',
    'duration',
];

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'tasks';


$join = [
    //'LEFT JOIN ' . db_prefix() . 'clients ON ' . db_prefix() . 'clients.userid = ' . db_prefix() . 'scorecards.clientid',
    'LEFT JOIN ' . db_prefix() . 'projects ON ' . db_prefix() . 'projects.id = ' . db_prefix() . 'tasks.rel_id',
    'LEFT JOIN ' . db_prefix() . 'task_assigned ON ' . db_prefix() . 'task_assigned.taskid = ' . db_prefix() . 'tasks.id',
    'LEFT JOIN ' . db_prefix() . 'staff ON ' . db_prefix() . 'staff.staffid = ' . db_prefix() . 'task_assigned.staffid',
    'LEFT JOIN ' . db_prefix() . 'scorecards_tasks_duration ON ' . db_prefix() . 'tasks.id = ' . db_prefix() . 'scorecards_tasks_duration.task_id',


];


$where  = [];

$additionalColumns = hooks()->apply_filters('scorecards_table_additional_columns_sql', [
    db_prefix() . 'scorecards_tasks_duration.lastname',
    db_prefix() . 'scorecards_tasks_duration.rel_id',
]);

array_push($where, 'AND ' . db_prefix() . 'tasks.datefinished IS NOT NULL');
array_push($where, 'AND ' . db_prefix() . 'tasks.rel_id IS NOT NULL');
array_push($where, 'AND ' . db_prefix() . 'tasks.rel_type = "project"');
array_push($where, 'AND ' . db_prefix() . 'scorecards_tasks_duration.task_id IS NULL');

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, $additionalColumns);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        if ($aColumns[$i] == 'name') {
            /*
            $_data = '<a href="' . admin_url('scorecards/scorecard/' . $aRow['id']) . '">' . $_data . '</a>';
            $_data .= '<div class="row-options">';
            $_data .= '<a href="' . admin_url('scorecards/update/' . $aRow['id']) . '">' . _l('edit') . '</a>';

            if (has_permission('scorecards', '', 'delete')) {
                $_data .= ' | <a href="' . admin_url('scorecards/delete/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
            }
            $_data .= '</div>';
            */
            $_data = $_data;            
        }
        elseif ($aColumns[$i] == 'dateadded') {
            $_data = $_data;
        }
        elseif ($aColumns[$i] == 'datefinished') {
            $_data = $_data;
        }
        elseif ($aColumns[$i] == 'duration') {
            $_data = $_data .' days';
              
        }


        $row[] = $_data;
    }
    $row['DT_RowClass'] = 'has-row-options';
    $output['aaData'][] = $row;
}
