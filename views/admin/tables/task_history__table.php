<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    db_prefix() . 'tasks.name',
    db_prefix() . 'projects.name',
    db_prefix() . 'staff.firstname',
];

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'scorecards_tasks_history';


$join = [
    'JOIN ' . db_prefix() . 'tasks ON ' . db_prefix() . 'scorecards_tasks_history.task_id = ' . db_prefix() . 'tasks.id',
    'LEFT JOIN ' . db_prefix() . 'task_assigned ON ' . db_prefix() . 'task_assigned.taskid = ' . db_prefix() . 'tasks.id',
    'LEFT JOIN ' . db_prefix() . 'projects ON ' . db_prefix() . 'projects.id = ' . db_prefix() . 'tasks.rel_id',
    'LEFT JOIN ' . db_prefix() . 'staff ON ' . db_prefix() . 'staff.staffid = ' . db_prefix() . 'task_assigned.staffid',

];


$where  = [];

//array_push($where, 'AND ' . db_prefix() . 'scorecards_tasks_history.task_id IS NOT NULL');

/*
if($this->ci->session->has_userdata('task_history_filter')){
    $task_history_filter  = $this->ci->session->userdata('task_history_filter');
    
    $staff_id = isset($task_history_filter['member']) ? $task_history_filter['member'] : '';
    $month = isset($task_history_filter['month']) ? $task_history_filter['month'] : date('m');
}
if(is_numeric($staff_id)){
    array_push($where, 'AND ' . db_prefix() . 'scorecards_tasks_history.staff_id =' . $staff_id);
}

if(is_numeric($month)){
    array_push($where, 'AND MONTH(' . db_prefix() . 'scorecards_tasks_history.dateadded) =' . $month);
}

log_activity('_task_history_filter_ ' . json_encode($task_history_filter));
*/

$additionalColumns = hooks()->apply_filters('scorecards_table_additional_columns_sql', [
    db_prefix() . 'scorecards_tasks_history.id',
    db_prefix() . 'tasks.id',
    db_prefix() . 'staff.firstname',
    db_prefix() . 'staff.lastname',
]);

$sGroupBy = ' GROUP BY ' .db_prefix() . 'scorecards_tasks_history.task_id, ' .db_prefix() . 'projects.name, '. db_prefix() . 'staff.firstname';

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, $additionalColumns, $sGroupBy);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        if ($aColumns[$i] == db_prefix() . 'tasks.name') {
            $_data = '<a href="' . admin_url('scorecards/task_history/' . $aRow['id']) . '">' . $_data . '</a>';
        }
        elseif ($aColumns[$i] ==  db_prefix() . 'projects.name') {
            $_data = $_data;
        }
        elseif ($aColumns[$i] == db_prefix() . 'staff.firstname') {
            $_data = $aRow['firstname'] .' '. $aRow['lastname'] ;
        }

        $row[] = $_data;
    }
    $row['DT_RowClass'] = 'has-row-options';
    $output['aaData'][] = $row;
}
