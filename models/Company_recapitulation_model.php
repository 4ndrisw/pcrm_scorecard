    <?php
    defined('BASEPATH') or exit('No direct script access allowed');

    class Company_recapitulation_model extends App_Model
    {
        public function __construct()
        {
            parent::__construct();

            $this->load->model('tasks_model');
            $this->load->model('projects_model');
            $this->load->model('staff_model');
        }

        public function get_average_tasks_duration(){
            $this_month = date('m', time());
            $this_year = date('Y', time());
            $tasks=[];

            $this->db->select('AVG(`duration`) As atd_duration',FALSE);
            $this->db->order_by('atd_duration', 'DESC'); 

            $tasks_alltime = $this->db->get(db_prefix() . 'scorecards_tasks_duration')->result_array();
            $tasks['alltime'] = $tasks_alltime[0];
            
            $this->db->select('AVG(`duration`) As atd_duration',FALSE);
            $this->db->where('MONTH(`datefinished`)', $this_month);
            $this->db->where('YEAR(`datefinished`)', $this_year);
            $this->db->order_by('atd_duration', 'DESC'); 

            //return $this->db->get_compiled_select(db_prefix() . 'scorecards_tasks_duration');

            $tasks_this_month = $this->db->get(db_prefix() . 'scorecards_tasks_duration')->result_array();
            $tasks['this_month'] = $tasks_this_month[0];

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

        public function get_daily_task_completed(){

            $this->db->select('COUNT(`id`) As count_id',FALSE);
            $this->db->select('DATE(`datefinished`) As dtc_finished',FALSE);
            $this->db->group_by(['dtc_finished']); 
            $this->db->order_by('dtc_finished', 'DESC'); 

            //return $this->db->get_compiled_select(db_prefix() . 'scorecards_tasks_duration');

            $tasks = $this->db->get(db_prefix() . 'scorecards_tasks_duration')->result_array();
            return $tasks;

        }
        
        public function get_daily_update_status(){
            $this->db->select(['DATE(dateadded) AS date_added', 'COUNT(status) AS update_status']);
            $this->db->group_by('date_added');
            $this->db->order_by('date_added', 'DESC');

            $this->db->join(db_prefix() . 'task_assigned',db_prefix() . 'task_assigned.taskid = ' . db_prefix() . 'scorecards_tasks_history.task_id');
            
            //return $this->db->get_compiled_select(db_prefix() . 'scorecards_tasks_history');

            $last_updated =  $this->db->get(db_prefix() . 'scorecards_tasks_history')->result();

            return $last_updated;
        }


    public function get_daily_count_update_status(){
        $this->db->select(['DATE(dateadded) AS date_added',  
            'COUNT(IF( STATUS = 1, 1, NULL )) task_status_1',
            'COUNT(IF( STATUS = 4, 1, NULL )) task_status_4',
            'COUNT(IF( STATUS = 3, 1, NULL )) task_status_3',
            'COUNT(IF( STATUS = 2, 1, NULL )) task_status_2',
            'COUNT(IF( STATUS = 5, 1, NULL )) task_status_5',
        ]);
        $this->db->group_by('date_added');
        $this->db->order_by('date_added', 'DESC');

        $this->db->join(db_prefix() . 'task_assigned',db_prefix() . 'task_assigned.taskid = ' . db_prefix() . 'scorecards_tasks_history.task_id');
    
        //return $this->db->get_compiled_select(db_prefix() . 'scorecards_tasks_history');

        $last_updated =  $this->db->get(db_prefix() . 'scorecards_tasks_history')->result();

        return $last_updated;
    }

    }

