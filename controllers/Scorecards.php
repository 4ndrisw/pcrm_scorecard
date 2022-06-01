<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Scorecards extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('company_recapitulation_model');
        $this->load->model('tasks_duration_model');
        $this->load->model('tasks_model');
        $this->load->model('projects_model');
    }

    /* Get all scorecards in case user go on index page */
    public function task_duration($id = '')
    {
        if (!has_permission('scorecards', '', 'view')) {
            access_denied('scorecards');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data(module_views_path('scorecards', 'admin/tables/table'));
        }
        $data = [];
        //$where = ['datefinished'=>'IS NOT NULL']
        $data['tasks'] = $this->tasks_duration_model->get_billable_tasks();
        $data['inspectionid']            = $id;
        $data['title']                 = _l('scorecards_tracking');
        $this->load->view('admin/scorecards/manage', $data);
        //$this->load->view('admin/scorecards/draft', $data);
    }

    /* Get all scorecards in case user go on index page */
    public function task_recapitulation($id = '')
    {
        if (!has_permission('scorecards', '', 'view')) {
            access_denied('scorecards');
        }
        
        //$data['tasks'] = $this->tasks_duration_model->get_tasks_duration_by_staff();
        $data['title']                 = _l('scorecards_task_recapitulation');
        //$this->load->view('widgets/tasks_duration_by_staff', $data);
        $this->load->view('admin/scorecards/task_recapitulation', $data);
    }

    /* Get all scorecards in case user go on index page */
    public function company_recapitulation($id = '')
    {
        if (!has_permission('scorecards', '', 'view')) {
            access_denied('scorecards');
        }
        $data['atd']   = $this->company_recapitulation_model->get_average_tasks_duration();
        $data['mtd']   = $this->company_recapitulation_model->get_maximum_tasks_duration();
        $data['title']                 = _l('scorecards_company_recapitulation');
        //$this->load->view('widgets/tasks_duration_by_staff', $data);
        $this->load->view('admin/scorecards/company_recapitulation', $data);
    }

}