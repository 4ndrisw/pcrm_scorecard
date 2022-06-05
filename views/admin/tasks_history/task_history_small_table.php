<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>


<div class="panel_s">
    <div class="panel-body">
     <div class="table-responsive">
        <?php render_datatable(array(
            _l('tasks_name'),
            _l('projects_name'),
            _l('staff_task_name'),
            ),'scorecards'); 
         ?>
        </div>
    </div>
</div>