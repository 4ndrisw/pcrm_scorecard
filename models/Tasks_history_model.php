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
}