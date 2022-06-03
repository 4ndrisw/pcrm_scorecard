<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="panel_s">
    <div class="panel-body">
     <?php if(has_permission('scorecards','','create')){ ?>
     <div class="_buttons">
        <a href="<?php echo admin_url('scorecards/task_duration'); ?>" class="btn btn-primary pull-right display-block"><?php echo _l('tasks_duration'); ?></a>
     </div>
     <?php } ?>
     <div class="clearfix"></div>
     <hr class="hr-panel-heading" />
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
