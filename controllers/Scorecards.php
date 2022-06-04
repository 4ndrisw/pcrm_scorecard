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

   
        if(is_numeric($id)){
            if ($this->input->is_ajax_request()) {
                $this->app->get_table_data(module_views_path('scorecards', 'admin/tables/table'));
            }

            $task_duration = $this->tasks_duration_model->get($id);
            //if(empty($task_duration)) goto end;

            $data['task_duration'] = $task_duration;
            $data['task_duration_id']            = $id;
            $data['title']                 = _l('task_duration_preview');
            $this->load->view('admin/tasks_duration/task_duration_preview', $data);

        }
        else{
            //end:
            if ($this->input->is_ajax_request()) {
                $this->app->get_table_data(module_views_path('scorecards', 'admin/tables/table'));
            }
            $data = [];
            //$where = ['datefinished'=>'IS NOT NULL']
            $data['tasks'] = $this->tasks_duration_model->get_billable_tasks();
            $data['inspectionid']            = $id;
            $data['title']                 = _l('scorecards_tracking');
            $this->load->view('admin/tasks_duration/manage', $data);
            //$this->load->view('admin/scorecards/draft', $data);
        }
    }

    /* Get all scorecards in case user go on index page */
    public function task_import($id = '')
    {
        if (!has_permission('scorecards', '', 'view')) {
            access_denied('scorecards');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data(module_views_path('scorecards', 'admin/tables/table_import'));
        }

        if ($this->input->post('scorecards_action')) {
            $action = $this->input->post('scorecards_action');
            /*
             * TODO some actions
             */
            $data = $this->tasks_duration_model->get_importable_tasks();
            if(!empty($data)){
                if($this->db->insert_batch(db_prefix() . 'scorecards_tasks_duration',$data)){
                    log_activity('Import scorecard data has successfully');
                }
                else{
                    log_activity('Import scorecard data has failed');
                }
            }
        }

        $data = [];
        $data['tasks'] = $this->tasks_duration_model->get_importable_tasks();
        $data['inspectionid']            = $id;
        $data['title']                 = _l('scorecards_tracking');
        $this->load->view('admin/scorecards/table_import', $data);
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
        //$data['atd']   = $this->company_recapitulation_model->get_average_tasks_duration();

        $data['mtd']   = $this->company_recapitulation_model->get_maximum_tasks_duration();
        $data['title']                 = _l('scorecards_company_recapitulation');
        //$this->load->view('widgets/tasks_duration_by_staff', $data);
        $this->load->view('admin/scorecards/company_recapitulation', $data);
    }

}