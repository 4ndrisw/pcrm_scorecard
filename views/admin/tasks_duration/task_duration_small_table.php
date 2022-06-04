<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="panel_s">
    <div class="panel-body">
   
     <div class="table-responsive">
        <?php render_datatable(array(
                        _l('tasks_name'),
                        _l('projects_name'),
                        _l('staff_task_name'),
                        _l('tasks_dateadded'),
                        _l('tasks_datefinished'),
                        _l('tasks_duration'),
            ),'tasks_duration'); ?>
     </div>
    </div>
</div>
