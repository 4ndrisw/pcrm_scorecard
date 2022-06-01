<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Company_recapitulation_model extends App_Model
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

    public function get_average_tasks_duration(){

        $this->db->select('AVG(`duration`) As atd_duration',FALSE);
        $this->db->order_by('atd_duration', 'DESC'); 

        //return $this->db->get_compiled_select(db_prefix() . 'scorecards_tasks_duration');

        $tasks = $this->db->get(db_prefix() . 'scorecards_tasks_duration')->result_array();
        return $tasks;

    }

    public function get_maximum_tasks_duration(){

        $this->db->select('MAX(`duration`) As mtd_duration',FALSE);
        $this->db->order_by('mtd_duration', 'DESC'); 

        $tasks = $this->db->get(db_prefix() . 'scorecards_tasks_duration')->result_array();
        return $tasks;

    }

    public function get_count_tasks_by_duration(){

        $this->db->select(['duration','COUNT(`duration`) As ctd_duration'],FALSE);
        $this->db->group_by(['duration',]); 
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

