    <?php
    defined('BASEPATH') or exit('No direct script access allowed');

    class Clients_recapitulation_model extends App_Model
    {
        public function __construct()
        {
            parent::__construct();

            $this->load->model('clients_model');
            $this->load->model('projects_model');
            $this->load->model('staff_model');
        }

    public function get_client_progress(){
        $this->db->select([
           db_prefix().'clients.company',
           db_prefix().'projects.name AS project_name',
           db_prefix().'projects.status AS project_status',
           'CONCAT(' .db_prefix().'staff.firstname," ", ' . db_prefix().'staff.lastname) AS "staff_name"',
           db_prefix().'projects.start_date',
           db_prefix().'tags.name AS tag_name',
           'count('. db_prefix().'tasks.id) AS "task"',
           'COUNT(IF(  '.db_prefix().'tasks.status = 1, 1, NULL )) task_status_1',
           'COUNT(IF(  '.db_prefix().'tasks.status = 4, 1, NULL )) task_status_4',
           'COUNT(IF(  '.db_prefix().'tasks.status = 3, 1, NULL )) task_status_3',
           'COUNT(IF(  '.db_prefix().'tasks.status = 2, 1, NULL )) task_status_2',
           'COUNT(IF(  '.db_prefix().'tasks.status = 5, 1, NULL )) task_status_5',  
        ]);

        $this->db->join(db_prefix() . 'task_assigned', db_prefix() . 'task_assigned.taskid = ' . db_prefix() . 'tasks.id');
        $this->db->join(db_prefix() . 'staff', db_prefix() . 'staff.staffid = ' . db_prefix() . 'task_assigned.staffid');
        $this->db->join(db_prefix() . 'projects', db_prefix() . 'projects.id = ' . db_prefix() . 'tasks.rel_id');
        $this->db->join(db_prefix() . 'clients', db_prefix() . 'clients.userid = ' . db_prefix() . 'projects.clientid');
        $this->db->join(db_prefix() . 'taggables', db_prefix() . 'taggables.rel_id = ' . db_prefix() . 'tasks.id');
        $this->db->join(db_prefix() . 'tags', db_prefix() . 'tags.id = ' . db_prefix() . 'taggables.tag_id');
    
        $this->db->group_by(['company',db_prefix().'projects.name',db_prefix().'tags.name',db_prefix().'staff.firstname',db_prefix().'staff.lastname']);
        $this->db->where(db_prefix() . 'projects.status !=', '4');
        $this->db->order_by('start_date', 'DESC');

        //return $this->db->get_compiled_select(db_prefix() . 'tasks');

        $scorecards =  $this->db->get(db_prefix() . 'tasks')->result();

        return $scorecards;

    }

    /**
     * Get the scorecards about to expired in the given days
     *
     * @param  integer|null $staffId
     * @param  integer $days
     *
     * @return array
     */
    public function __get_client_recapitulation_today($staffId = null)
    {

        $today = date('Y-m-d', time());
        /*
        if ($staffId && ! staff_can('view', 'scorecards', $staffId)) {
            $this->db->where(db_prefix() . 'scorecards.addedfrom', $staffId);
        }
        */


        $this->db->select([
           db_prefix().'clients.company',
           db_prefix().'projects.name AS project_name',
           db_prefix().'projects.status AS project_status',
           'CONCAT(' .db_prefix().'staff.firstname," ", ' . db_prefix().'staff.lastname) AS "staff_name"',
           db_prefix().'projects.start_date',
           db_prefix().'tags.name AS tag_name',
           'count('. db_prefix().'tasks.id) AS "task"',
           'COUNT(IF(  '.db_prefix().'tasks.status = 1, 1, NULL )) task_status_1',
           'COUNT(IF(  '.db_prefix().'tasks.status = 4, 1, NULL )) task_status_4',
           'COUNT(IF(  '.db_prefix().'tasks.status = 3, 1, NULL )) task_status_3',
           'COUNT(IF(  '.db_prefix().'tasks.status = 2, 1, NULL )) task_status_2',
           'COUNT(IF(  '.db_prefix().'tasks.status = 5, 1, NULL )) task_status_5',  
        ]);

        $this->db->join(db_prefix() . 'task_assigned', db_prefix() . 'task_assigned.taskid = ' . db_prefix() . 'tasks.id', 'LEFT');
        $this->db->join(db_prefix() . 'staff', db_prefix() . 'staff.staffid = ' . db_prefix() . 'task_assigned.staffid', 'LEFT');
        $this->db->join(db_prefix() . 'projects', db_prefix() . 'projects.id = ' . db_prefix() . 'tasks.rel_id', 'LEFT');
        $this->db->join(db_prefix() . 'clients', db_prefix() . 'clients.userid = ' . db_prefix() . 'projects.clientid', 'LEFT');
        $this->db->join(db_prefix() . 'taggables', db_prefix() . 'taggables.rel_id = ' . db_prefix() . 'tasks.id', 'LEFT');
        $this->db->join(db_prefix() . 'tags', db_prefix() . 'tags.id = ' . db_prefix() . 'taggables.tag_id', 'LEFT');
        $this->db->join(db_prefix() . 'scorecards_tasks_history', db_prefix() . 'scorecards_tasks_history.task_id = ' . db_prefix() . 'tasks.id', 'LEFT');
    
        $this->db->group_by(['company',db_prefix().'projects.name',db_prefix().'tags.name',db_prefix().'staff.firstname',db_prefix().'staff.lastname']);
        //$this->db->where(db_prefix() . 'projects.status !=', '4');

        $this->db->where('DATE('.db_prefix() . 'scorecards_tasks_history.dateadded) =', $today);

        $this->db->order_by('start_date', 'DESC');

        //return $this->db->get_compiled_select(db_prefix() . 'tasks');

        $scorecards =  $this->db->get(db_prefix() . 'tasks')->result();

        return $scorecards;

    }
    /**
     * Get the scorecards about to expired in the given days
     *
     * @param  integer|null $staffId
     * @param  integer $days
     *
     * @return array
     */
    public function get_client_recapitulation_today($staffId = false)
    {
        $today = date('Y-m-d', time());

        $this->db->select([
           db_prefix().'clients.company',
           db_prefix().'projects.name AS project_name',
           db_prefix().'projects.status AS project_status',
           'CONCAT(' .db_prefix().'staff.firstname," ", ' . db_prefix().'staff.lastname) AS "staff_name"',
           db_prefix().'projects.start_date',
           db_prefix().'tags.name AS tag_name',
           'count('. db_prefix().'tasks.name) AS `task`','DATE('.db_prefix() . 'scorecards_tasks_history.dateadded) AS date_added', 'CONCAT(firstname," ",lastname) AS staff', 
           'COUNT(IF(  '.db_prefix().'scorecards_tasks_history.status = 1, 1, NULL )) task_status_1',
           'COUNT(IF(  '.db_prefix().'scorecards_tasks_history.status = 4, 1, NULL )) task_status_4',
           'COUNT(IF(  '.db_prefix().'scorecards_tasks_history.status = 3, 1, NULL )) task_status_3',
           'COUNT(IF(  '.db_prefix().'scorecards_tasks_history.status = 2, 1, NULL )) task_status_2',
           'COUNT(IF(  '.db_prefix().'scorecards_tasks_history.status = 5, 1, NULL )) task_status_5',  
        ]);
        $this->db->group_by([db_prefix().'clients.company',db_prefix().'projects.name',db_prefix().'tags.name','staff','date_added']);
        $this->db->order_by('date_added, staff', 'DESC');

        $this->db->join(db_prefix() . 'task_assigned',db_prefix() . 'task_assigned.taskid = ' . db_prefix() . 'scorecards_tasks_history.task_id');
        $this->db->join(db_prefix() . 'staff',db_prefix() . 'task_assigned.staffid = ' . db_prefix() . 'staff.staffid');
        $this->db->join(db_prefix() . 'tasks', db_prefix() . 'scorecards_tasks_history.task_id = ' . db_prefix() . 'tasks.id', 'LEFT');
    

        $this->db->join(db_prefix() . 'projects', db_prefix() . 'projects.id = ' . db_prefix() . 'tasks.rel_id', 'LEFT');
        $this->db->join(db_prefix() . 'clients', db_prefix() . 'clients.userid = ' . db_prefix() . 'projects.clientid', 'LEFT');
        $this->db->join(db_prefix() . 'taggables', db_prefix() . 'taggables.rel_id = ' . db_prefix() . 'tasks.id', 'LEFT');
        $this->db->join(db_prefix() . 'tags', db_prefix() . 'tags.id = ' . db_prefix() . 'taggables.tag_id', 'LEFT');
        

        $this->db->where('DATE('.db_prefix() . 'scorecards_tasks_history.dateadded) =', $today);
        
        //return $this->db->get_compiled_select(db_prefix() . 'scorecards_tasks_history');

        $scorecards =  $this->db->get(db_prefix() . 'scorecards_tasks_history')->result();

        return $scorecards;

    }

    /**
     * Get the scorecards about to expired in the given days
     *
     * @param  integer|null $staffId
     * @param  integer $days
     *
     * @return array
     */
    public function get_client_recapitulation_this_week($staffId = null, $days = 6)
    {
        $diff1 = date('Y-m-d', strtotime('-' . $days . ' days'));
        $diff2 = date('Y-m-d', strtotime('+' . 1 . ' days'));
        /*
        if ($staffId && ! staff_can('view', 'scorecards', $staffId)) {
            $this->db->where(db_prefix() . 'scorecards.addedfrom', $staffId);
        }
        */


        $this->db->select([
           db_prefix().'clients.company',
           db_prefix().'projects.name AS project_name',
           db_prefix().'projects.status AS project_status',
           'CONCAT(' .db_prefix().'staff.firstname," ", ' . db_prefix().'staff.lastname) AS "staff_name"',
           db_prefix().'projects.start_date',
           db_prefix().'tags.name AS tag_name',
           'count('. db_prefix().'tasks.id) AS "task"',
           'COUNT(IF(  '.db_prefix().'tasks.status = 1, 1, NULL )) task_status_1',
           'COUNT(IF(  '.db_prefix().'tasks.status = 4, 1, NULL )) task_status_4',
           'COUNT(IF(  '.db_prefix().'tasks.status = 3, 1, NULL )) task_status_3',
           'COUNT(IF(  '.db_prefix().'tasks.status = 2, 1, NULL )) task_status_2',
           'COUNT(IF(  '.db_prefix().'tasks.status = 5, 1, NULL )) task_status_5',  
        ]);

        $this->db->join(db_prefix() . 'task_assigned', db_prefix() . 'task_assigned.taskid = ' . db_prefix() . 'tasks.id', 'LEFT');
        $this->db->join(db_prefix() . 'staff', db_prefix() . 'staff.staffid = ' . db_prefix() . 'task_assigned.staffid', 'LEFT');
        $this->db->join(db_prefix() . 'projects', db_prefix() . 'projects.id = ' . db_prefix() . 'tasks.rel_id', 'LEFT');
        $this->db->join(db_prefix() . 'clients', db_prefix() . 'clients.userid = ' . db_prefix() . 'projects.clientid', 'LEFT');
        $this->db->join(db_prefix() . 'taggables', db_prefix() . 'taggables.rel_id = ' . db_prefix() . 'tasks.id', 'LEFT');
        $this->db->join(db_prefix() . 'tags', db_prefix() . 'tags.id = ' . db_prefix() . 'taggables.tag_id', 'LEFT');
        $this->db->join(db_prefix() . 'scorecards_tasks_history', db_prefix() . 'scorecards_tasks_history.task_id = ' . db_prefix() . 'tasks.id', 'LEFT');
    
        $this->db->group_by(['company',db_prefix().'projects.name',db_prefix().'tags.name',db_prefix().'staff.firstname',db_prefix().'staff.lastname']);
        $this->db->where(db_prefix() . 'projects.status !=', '4');

        $this->db->where(db_prefix() . 'scorecards_tasks_history.dateadded >=', $diff1);
        $this->db->where(db_prefix() . 'scorecards_tasks_history.dateadded <=', $diff2);

        $this->db->order_by('start_date', 'DESC');

        //return $this->db->get_compiled_select(db_prefix() . 'tasks');

        $scorecards =  $this->db->get(db_prefix() . 'tasks')->result();

        return $scorecards;

    }

    /**
     * Get the schedules about to expired in the given days
     *
     * @param  integer|null $staffId
     * @param  integer $days
     *
     * @return array
     */
    public function get_staff_grouped_this_week($days = 6)
    {
        $diff1 = date('Y-m-d', strtotime('-' . $days . ' days'));
        $diff2 = date('Y-m-d', strtotime('+' . 1 . ' days'));


        $this->db->select([
           'CONCAT(' .db_prefix().'staff.firstname," ", ' . db_prefix().'staff.lastname) AS "staff_name"',
        ]);

        $this->db->join(db_prefix() . 'task_assigned', db_prefix() . 'task_assigned.taskid = ' . db_prefix() . 'tasks.id');
        $this->db->join(db_prefix() . 'staff', db_prefix() . 'staff.staffid = ' . db_prefix() . 'task_assigned.staffid');
        $this->db->join(db_prefix() . 'projects', db_prefix() . 'projects.id = ' . db_prefix() . 'tasks.rel_id');
        $this->db->join(db_prefix() . 'scorecards_tasks_history', db_prefix() . 'scorecards_tasks_history.task_id = ' . db_prefix() . 'tasks.id', 'LEFT');
    
        $this->db->group_by([db_prefix().'staff.firstname',db_prefix().'staff.lastname']);
        $this->db->where(db_prefix() . 'projects.status !=', '4');

        $this->db->where(db_prefix() . 'scorecards_tasks_history.dateadded >=', $diff1);
        $this->db->where(db_prefix() . 'scorecards_tasks_history.dateadded <=', $diff2);

        $this->db->order_by('staff_name', 'ASC');

        //return $this->db->get_compiled_select(db_prefix() . 'tasks');

        $scorecards =  $this->db->get(db_prefix() . 'tasks')->result();

        return $scorecards;

    }
    /**
     * Get the schedules about to expired in the given days
     *
     * @param  integer|null $staffId
     * @param  integer $days
     *
     * @return array
     */
    public function get_staff_grouped_today($days = 1)
    {

        $today = date('Y-m-d', time());
        
        $this->db->select([
           'CONCAT(' .db_prefix().'staff.firstname," ", ' . db_prefix().'staff.lastname) AS "staff_name"',
        ]);

        $this->db->join(db_prefix() . 'task_assigned', db_prefix() . 'task_assigned.taskid = ' . db_prefix() . 'tasks.id');
        $this->db->join(db_prefix() . 'staff', db_prefix() . 'staff.staffid = ' . db_prefix() . 'task_assigned.staffid');
        $this->db->join(db_prefix() . 'projects', db_prefix() . 'projects.id = ' . db_prefix() . 'tasks.rel_id');
        $this->db->join(db_prefix() . 'scorecards_tasks_history', db_prefix() . 'scorecards_tasks_history.task_id = ' . db_prefix() . 'tasks.id', 'LEFT');
    
        $this->db->group_by([db_prefix().'staff.firstname',db_prefix().'staff.lastname']);
        $this->db->where(db_prefix() . 'projects.status !=', '4');

        $this->db->where('DATE('.db_prefix() . 'scorecards_tasks_history.dateadded) =', $today);

        $this->db->order_by('staff_name', 'ASC');

        //return $this->db->get_compiled_select(db_prefix() . 'tasks');

        $scorecards =  $this->db->get(db_prefix() . 'tasks')->result();

        return $scorecards;

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

        $this->db->join(db_prefix() . 'task_assigned',db_prefix() . 'task_assigned.taskid = ' . db_prefix() . 'scorecards_clients_history.task_id');
    
        //return $this->db->get_compiled_select(db_prefix() . 'scorecards_clients_history');

        $last_updated =  $this->db->get(db_prefix() . 'scorecards_clients_history')->result();

        return $last_updated;
    }


    }

