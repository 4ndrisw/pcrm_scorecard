<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12 scorecards-today ">
                <div class="panel_s">
                    <div class="panel-body">

                         <div class="row filter-form">
                            <?php echo form_open($this->uri->uri_string() . ($this->input->get('project_id') ? '?project_id='.$this->input->get('project_id') : ''));?>
                            <div class="col-md-3">
                               <?php $value = _d(date('Y-m-d')); ?>
                               <?php echo render_date_input(
                                  'recapitulation_date',
                                  'recapitulation_date_select',
                                  $value
                               ); ?>
                            </div>

                            <div class="col-md-2  center-block">
                                <button type="submit" class="btn btn-info btn-block filter" style="margin-top:3px;"><?php echo _l('filter'); ?></button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                     <?//= $scorecards ?>
                    <div class="widget" id="widget-<?php echo create_widget_id(); ?>" data-name="<?php echo _l('clients_recapitulation_today '); ?>">
                      <?php if(staff_can('view', 'scorecards') || staff_can('view_own', 'scorecards')) { ?>
                      <div class="panel_s scorecards-expiring">
                          <div class="panel-body padding-10">
                              <p class="padding-5"><?php echo _l('clients_recapitulation_today ') .': ' . $client_recapitulation_today['recapitulation_date']; ?></p>
                              <hr class="hr-panel-heading-dashboard">
                              <?php if (!empty($scorecards)) { ?>
                                  <div class="table-vertical-scroll">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="<?php echo admin_url('scorecards'); ?>" class="mbot20 inline-block full-width"><?php echo _l('home_widget_view_all'); ?></a>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="pull-right _buttons">
                                                <div class="btn-group">
                                                    <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf-o"></i><?php if(is_mobile()){echo ' PDF';} ?> <span class="caret"></span></a>
                                                    <ul class="dropdown-menu dropdown-menu-right">
                                                        <li class="hidden-xs"><a href="<?php echo admin_url('scorecards/client_today/pdf'.'?output_type=I'); ?>"><?php echo _l('view_pdf'); ?></a></li>
                                                        <li class="hidden-xs"><a href="<?php echo admin_url('scorecards/client_today/pdf'.'?output_type=I'); ?>" target="_blank"><?php echo _l('view_pdf_in_new_window'); ?></a></li>
                                                        <li><a href="<?php echo admin_url('scorecards/client_today/pdf'); ?>"><?php echo _l('download'); ?></a></li>
                                                        <li>
                                                           <a href="<?php echo admin_url('scorecards/client_today/pdf'.'?print=true'); ?>" target="_blank">
                                                           <?php echo _l('print'); ?>
                                                           </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                      <table id="widget-<?php echo create_widget_id(); ?>" class="table dt-table" data-order-col="2" data-order-type="desc">
                                          <thead>
                                              <tr>
                                                  <th>No.</th>
                                                  <th><?php echo _l('client'); ?></th>
                                                  <th><?php echo _l('staff'); ?></th>
                                                  <th><?php echo _l('equipment'); ?></th>
                                                  <th><?php //echo _l('tasks'); ?></th>

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
                                                <?php $task_status = 'status_task_uncomplete'; ?>
                                                <?php if($scorecard->task == $scorecard->task_status_5){$task_status = 'status_task_complete';} ?>
                                                  <tr class="<?= $task_status?>">
                                                      <td> <?php echo $i; ?></td>
                                                      <td>
                                                        <?php 
                                                            echo $scorecard->company .'<div class="italic">#'. $scorecard->project_name .'</div>#' . $scorecard->start_date; 
                                                        ?>
                                                      </td>
                                                      <td><?php echo $scorecard->staff_name; ?> </td>
                                                      <td><?php echo $scorecard->tag_name; ?> </td>
                                                      <td><?php // echo $scorecard->task; ?> </td>

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
                                      <h4><?php echo _l('no_tasks_history_by_staff',["2"]) ; ?> </h4>
                                  </div>
                              <?php } ?>
                          </div>
                      </div>
                      <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12 messages">
                <div class="panel_s">
                    <div class="panel-body">
                        <?php 
                            foreach($staffs as $staff){
                                $message = scorecards_daily_report($scorecards, $staff);
                                $message = str_replace("\r\n", "<br />", $message);
                                echo $message;
                            }
                        ?>
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
        initDataTable('.table-scorecards', window.location.href, 'undefined', 'undefined','fnServerParams', [7, 'desc']);
    });
</script>
</body>
</html>