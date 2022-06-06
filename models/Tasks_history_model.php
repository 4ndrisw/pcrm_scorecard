<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tasks_history_model extends App_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('tasks_model');
        $this->load->model('staff_model');
    }

    /**
     * Get task hostory by id
     * @param  mixed $id task id
     * @return object
     */
    public function get($id, $where = [])
    {
        if(is_numeric($id)){
            $this->db->where('id', $id);
        }
        $this->db->where($where);
        $task_history = $this->db->get(db_prefix() . 'scorecards_tasks_history')->row();
        return $task_history;
    }

    /**
     * Get task hostory by id
     * @param  mixed $id task id
     * @return object
     */
    public function get_history_by_task_id($task_id, $where = [])
    {
        $this->db->where('task_id', $task_id);
        
        //return $this->db->get_compiled_select(db_prefix() . 'scorecards_tasks_history');

        $task_history =  $this->db->get(db_prefix() . 'scorecards_tasks_history')->result();

        return $task_history;
    }

    public function get_task_history_last_updated(){
        $this->db->select(['max(firstname) AS first_name', 'max(lastname) AS last_name', 'max(dateadded) AS date_added']);
        $this->db->group_by(['firstname']); 
        $this->db->join(db_prefix() . 'task_assigned',db_prefix() . 'task_assigned.taskid = ' . db_prefix() . 'scorecards_tasks_history.task_id');
        $this->db->join(db_prefix() . 'staff',db_prefix() . 'task_assigned.staffid = ' . db_prefix() . 'staff.staffid');
        
        //return $this->db->get_compiled_select(db_prefix() . 'scorecards_tasks_history');

        $last_updated =  $this->db->get(db_prefix() . 'scorecards_tasks_history')->result();

        return $last_updated;
    }
}