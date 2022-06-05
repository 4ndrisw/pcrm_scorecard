<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">                
                <div class="panel_s">
                   <div class="panel-body">
                      <?php echo form_open($this->uri->uri_string() . ($this->input->get('project_id') ? '?project_id='.$this->input->get('project_id') : '')); ?>
                      <div class="row">
                         <?php echo form_hidden('project_id',$this->input->get('project_id')); ?>
                         <?php if(has_permission('tasks','','view')){ ?>
                         <div class="col-md-2 border-right">
                            <?php
                               echo render_select('member',$members,array('staffid',array('firstname','lastname')),'',$staff_id,array('data-none-selected-text'=>_l('all_staff_members')),array(),'no-margin'); ?>
                         </div>
                         <?php } ?>
                         <div class="col-md-2 border-right">
                            <?php
                               $months = array();

                               for ($m = 1; $m <= 12; $m++) {
                                 $data = array();
                                 $data['month'] = $m;
                                 $data['name'] = _l(date('F', mktime(0, 0, 0, $m, 1)));
                                 $months[] = $data;
                               }                               
                               $selected = ($month ? $month : date('m'));
                               if($this->input->post() && $this->input->post('month') == ''){
                                 $selected = '';
                               }
                               echo render_select('month',$months,array('month',array('name')),'',$selected,array('data-none-selected-text'=>_l('task_filter_detailed_all_months')),array(),'no-margin');
                               ?>
                         </div>
                         <div class="col-md-2 text-center border-right">
                            <div class="form-group no-margin select-placeholder">
                               <select name="status" id="status" class="selectpicker no-margin" data-width="100%" data-title="<?php echo _l('task_status'); ?>" disabled>
                                  <option value="" selected><?php echo _l('task_list_all'); ?></option>
                                  <?php foreach($task_statuses as $status){ ?>
                                  <option value="<?php echo $status['id']; ?>" <?php if($this->input->post('status') == $status['id']){echo 'selected'; } ?>><?php echo $status['name']; ?></option>
                                  <?php } ?>
                               </select>
                            </div>
                         </div>
                         <div class="col-md-2 border-right select-placeholder">
                            <select name="year" id="year" class="selectpicker no-margin" data-width="100%">
                               <?php foreach($years as $data){ ?>
                               <option value="<?php echo $data['year']; ?>" <?php if($this->input->post('year') == $data['year'] || date('Y') == $data['year']){echo 'selected'; } ?>><?php echo $data['year']; ?></option>
                               <?php } ?>
                            </select>
                         </div>
                         <div class="col-md-2">
                            <button type="submit" class="btn btn-info btn-block" style="margin-top:3px;"><?php echo _l('filter'); ?></button>
                         </div>
                      </div>
                      <?php echo form_close(); ?>
                   </div>
                </div>
                <div class="panel_s">
                    <div class="panel-body">
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