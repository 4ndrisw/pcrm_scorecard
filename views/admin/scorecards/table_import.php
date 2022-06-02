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
                            <?php 
                            echo form_open($this->uri->uri_string(), array('class'=>'pull-right mtop7 action-button'));
                            echo form_hidden('scorecards_action', 4);
                            echo '<button type="submit" data-loading-text="'._l('wait_text').'" autocomplete="off" class="btn btn-success action-button accept"><i class="fa fa-check"></i> '._l('scorecards_task_import').'</button>';
                            echo form_close();
                            ?>
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