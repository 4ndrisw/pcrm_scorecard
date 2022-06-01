<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tasks_duration_model extends App_Model
{
    private $statuses;

    //private $shipping_fields = ['shipping_street', 'shipping_city', 'shipping_city', 'shipping_state', 'shipping_zip', 'shipping_country'];

    public function __construct()
    {
        parent::__construct();

        $this->load->model('tasks_model');
        $this->load->model('projects_model');
        $this->load->model('staff_model');
    }

    /**
     * Get task by id
     * @param  mixed $id task id
     * @return object
     */
    public function get($id, $where = [])
    {
        $is_admin = is_admin();
        if(is_numeric($id)){
            $this->db->where('id', $id);
        }
        $this->db->where($where);
        $this->db->limit(3, 0);
        $task = $this->db->get(db_prefix() . 'tasks')->row();


        //$task = $this->db->get_compiled_select('tasks');
        //return $task;

        if ($task) {
            $task->assignees     = $this->tasks_model->get_task_assignees($id);
            $task->assignees_ids = [];

            foreach ($task->assignees as $follower) {
                array_push($task->assignees_ids, $follower['assigneeid']);
            }

            if (is_staff_logged_in()) {
                $task->current_user_is_assigned = $this->tasks_model->is_task_assignee(get_staff_user_id(), $id);
                $task->current_user_is_creator  = $this->tasks_model->is_task_creator(get_staff_user_id(), $id);
            }

            if ($task->rel_type == 'project') {
                $task->project_data = $this->projects_model->get($task->rel_id);
            }
        }

        //return hooks()->apply_filters('get_task', $task);
        return $task;
    }

    public function get_billable_tasks($customer_id = false, $project_id = '')
    {
        $has_permission_view = has_permission('tasks', '', 'view');
        $noPermissionsQuery  = get_tasks_where_string(false);

        $this->db->select(['id','name', 'rel_id', 'rel_type', 'dateadded', 'datefinished']);
        $this->db->where('billable', 1);
        $this->db->where('billed', 0);
        $this->db->where('datefinished !=', NULL, true);
        //$this->db->where(db_prefix() .'tasks.datefinished IS NOT NULL');
        //$this->db->query("SELECT * FROM `tbltasks` WHERE `billable` = 1 AND `datefinished` IS NOT NULL");
        
        $this->db->limit(3, 0);

        if ($project_id == '') {
            $this->db->where('rel_type', 'project');
        } else {
            $this->db->where('rel_type', 'project');
            $this->db->where('rel_id', $project_id);
        }
        return $this->db->get_compiled_select(db_prefix() . 'tasks');

        $tasks = $this->db->get(db_prefix() . 'tasks')->result_array();

        $i = 0;
        foreach ($tasks as $task) {
            $task_rel_data         = get_relation_data($task['rel_type'], $task['rel_id']);
            $task_rel_value        = get_relation_values($task_rel_data, $task['rel_type']);
            $tasks[$i]['rel_name'] = $task_rel_value['name'];
            if (total_rows(db_prefix() . 'taskstimers', [
                'task_id' => $task['id'],
                'end_time' => null,
            ]) > 0) {
                $tasks[$i]['started_timers'] = true;
            } else {
                $tasks[$i]['started_timers'] = false;
            }
            $i++;
        }

        return $tasks;
    }

    public function get_average_tasks_duration_by_staff($staff_id = ''){

        $this->db->select(['staff_id', 'firstname']);
        $this->db->select('AVG(`duration`) As avg_duration',FALSE);
        $this->db->group_by(['staff_id', 'firstname']); 
        $this->db->order_by('avg_duration', 'DESC'); 

        $tasks = $this->db->get(db_prefix() . 'scorecards_tasks_duration')->result_array();
        return $tasks;

    }
    public function get_maximum_tasks_duration_by_staff($staff_id = ''){

        $this->db->select(['staff_id', 'firstname']);
        $this->db->select('MAX(`duration`) As max_duration',FALSE);
        $this->db->group_by(['staff_id', 'firstname']); 
        $this->db->order_by('max_duration', 'DESC'); 

        $tasks = $this->db->get(db_prefix() . 'scorecards_tasks_duration')->result_array();
        return $tasks;

    }

    public function get_count_tasks_by_duration_per_staff($staff_id = ''){

        $this->db->select(['staff_id', 'firstname', 'duration']);
        $this->db->select('COUNT(`duration`) As count_duration',FALSE);
        $this->db->group_by(['duration','staff_id','firstname']); 
        $this->db->order_by('duration', 'DESC'); 

        //return $this->db->get_compiled_select(db_prefix() . 'scorecards_tasks_duration');

        $tasks = $this->db->get(db_prefix() . 'scorecards_tasks_duration')->result_array();
        return $tasks;

    }

    public function get_daily_completed_task_by_staff($staff_id = ''){

        $this->db->select('COUNT(`id`) As count_id',FALSE);
        $this->db->select(['staff_id', 'firstname']);
        $this->db->select('DATE(`datefinished`) As date_finished',FALSE);
        $this->db->group_by(['date_finished','staff_id','firstname']); 
        $this->db->order_by('date_finished', 'DESC'); 

        //return $this->db->get_compiled_select(db_prefix() . 'scorecards_tasks_duration');

        $tasks = $this->db->get(db_prefix() . 'scorecards_tasks_duration')->result_array();
        return $tasks;

    }
    

}

