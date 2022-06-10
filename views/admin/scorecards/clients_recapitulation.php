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

                    </div>
                     <?//= $scorecards ?>
                    <div>
                       

                  <div class="widget" id="widget-<?php echo create_widget_id(); ?>" data-name="<?php echo _l('clients_recapitulation'); ?>">
                      <?php if(staff_can('view', 'scorecards') || staff_can('view_own', 'scorecards')) { ?>
                      <div class="panel_s scorecards-expiring">
                          <div class="panel-body padding-10">
                              <p class="padding-5"><?php echo _l('clients_recapitulation'); ?></p>
                              <hr class="hr-panel-heading-dashboard">
                              <?php if (!empty($scorecards)) { ?>
                                  <div class="table-vertical-scroll">
                                      <a href="<?php echo admin_url('scorecards'); ?>" class="mbot20 inline-block full-width"><?php echo _l('home_widget_view_all'); ?></a>

                                      <table id="widget-<?php echo create_widget_id(); ?>" class="table dt-table" data-order-col="1" data-order-type="desc">
                                          <thead>
                                              <tr>
                                                  <th>No.</th>
                                                  <th><?php echo _l('company'); ?></th>
                                                  <th><?php echo _l('projects'); ?></th>
                                                  <th><?php echo _l('start_date'); ?></th>
                                                  <th><?php echo _l('equipment'); ?></th>
                                                  <th><?php echo _l('tasks'); ?></th>

                                                  <th><?php echo 'N'; ?></th>
                                                  <th><?php echo 'R'; ?></th>
                                                  <th><?php echo 'L'; ?></th>
                                                  <th><?php echo 'P'; ?></th>
                                                  <th><?php echo 'C'; ?></th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              <?php $i = 1; ?>
                                              <?php foreach ($scorecards as $scorecard) { ?>
                                                  <tr>
                                                      <td> <?php echo $i; ?></td>
                                                      <td><?php echo $scorecard->company; ?></td>
                                                      <td><?php echo $scorecard->project_name; ?> </td>
                                                      <td><?php echo $scorecard->start_date; ?> </td>
                                                      <td><?php echo $scorecard->tag_name; ?> </td>
                                                      <td><?php echo $scorecard->task; ?> </td>

                                                      <td><?php echo $scorecard->task_status_1; ?> </td>
                                                      <td><?php echo $scorecard->task_status_4; ?> </td>
                                                      <td><?php echo $scorecard->task_status_3; ?> </td>
                                                      <td><?php echo $scorecard->task_status_2; ?> </td>
                                                      <td><?php echo $scorecard->task_status_5; ?> </td>
                                                  </tr>
                                              <?php $i++; ?>
                                              <?php } ?>
                                          </tbody>
                                      </table>



                                  </div>
                              <?php } else { ?>
                                  <div class="text-center padding-5">
                                      <i class="fa fa-check fa-5x" aria-hidden="true"></i>
                                      <h4><?php echo _l('no_tasks_duration_by_staff',["7"]) ; ?> </h4>
                                  </div>
                              <?php } ?>
                          </div>
                      </div>
                      <?php } ?>
                  </div>



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
        initDataTable('.table-scorecards', window.location.href, 'undefined', 'undefined','fnServerParams', [3, 'desc']);
    });
</script>
</body>
</html>