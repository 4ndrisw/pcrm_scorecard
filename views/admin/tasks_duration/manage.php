<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                     <?php if(has_permission('scorecards','','create')){ ?> 

                     <div class="_buttons">
                        <a href="<?php echo admin_url('scorecards/create'); ?>" class="btn btn-info pull-left display-block"><?php echo _l('new_scorecard'); ?></a>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <?php } ?>
                    <?php render_datatable(array(
                        _l('tasks_name'),
                        _l('projects_name'),
                        _l('staff_task_name'),
                        _l('tasks_dateadded'),
                        _l('tasks_datefinished'),
                        _l('tasks_duration'),
                        ),'scorecards'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script type="text/javascript" id="scorecard-js" src="<?= base_url() ?>modules/scorecards/assets/js/scorecards.js?"></script>
<script>
    $(function(){
        initDataTable('.table-scorecards', window.location.href, 'undefined', 'undefined','fnServerParams', [4, 'desc']);
    });
</script>
</body>
</html>