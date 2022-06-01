<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Scorecards_model extends App_Model
{
    private $statuses;

    //private $shipping_fields = ['shipping_street', 'shipping_city', 'shipping_city', 'shipping_state', 'shipping_zip', 'shipping_country'];

    public function __construct()
    {
        parent::__construct();

        $this->load->model('tasks_model');
        $this->load->model('projects_model');
        $this->load->model('staff_model');
        $this->statuses = hooks()->apply_filters('before_set_inspection_statuses', [
            1,
            2,
            5,
            3,
            4,
        ]);   
    }

    /**
     * Get task by id
     * @param  mixed $id task id
     * @return object
     */
    public function get($id, $where = [])
    {
    }
}