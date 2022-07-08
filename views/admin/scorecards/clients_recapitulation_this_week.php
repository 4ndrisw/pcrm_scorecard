<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">

                    </div>
                     <?//= $scorecards; return; ?>
                    <div>

                  <div class="widget" id="widget-<?php echo create_widget_id(); ?>" data-name="<?php echo _l('clients_recapitulation_this_week '); ?>">
                      <?php if(staff_can('view', 'scorecards') || staff_can('view_own', 'scorecards')) { ?>
                      <div class="panel_s scorecards-expiring">
                          <div class="panel-body padding-10">
                              <p class="padding-5"><?php echo _l('clients_recapitulation_this_week '); ?></p>
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
                                                        <li class="hidden-xs"><a href="<?php echo admin_url('scorecards/pdf/this_week'.'?output_type=I'); ?>"><?php echo _l('view_pdf'); ?></a></li>
                                                        <li class="hidden-xs"><a href="<?php echo admin_url('scorecards/pdf/this_week'.'?output_type=I'); ?>" target="_blank"><?php echo _l('view_pdf_in_new_window'); ?></a></li>
                                                        <li><a href="<?php echo admin_url('scorecards/pdf/this_week'); ?>"><?php echo _l('download'); ?></a></li>
                                                        <li>
                                                           <a href="<?php echo admin_url('scorecards/pdf/this_week'.'?print=true'); ?>" target="_blank">
                                                           <?php echo _l('print'); ?>
                                                           </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                      <table id="widget-<?php echo create_widget_id(); ?>" class="table dt-table" data-order-col="1" data-order-type="desc">
                                          <thead>
                                              <tr>
                                                  <th>No.</th>
                                                  <th><?php echo _l('client'); ?></th>
                                                  <th><?php echo _l('equipment'); ?></th>
                                                  <th><?php echo _l('staff'); ?></th>
                                                  <th><?php echo _l('Item'); ?></th>
                                                 
                                                  <th><?php echo 'N'; ?></th>
                                                  <th><?php echo 'R'; ?></th>
                                                  <th><?php echo 'L'; ?></th>
                                                  <th><?php echo 'P'; ?></th>
                                                  <th><?php echo 'C'; ?></th>
                                                  <th><?php echo _l('licences_proposed'); ?></th>
                                                  <th><?php echo _l('licences_released'); ?></th>
                                                  <th><?php echo _l('jobreport_date'); ?></th>
                                                  
                                              </tr>
                                          </thead>
                                          <tbody>
                                              <?php $i = 1; ?>
                                              <?php foreach ($scorecards as $scorecard) { ?>
                                                <?php $task_status = 'status_task_uncomplete'; ?>
                                                <?php //if($scorecard->task == $scorecard->task_status_5){$task_status = 'status_task_complete';} ?>
                                                  <tr class="<?= $task_status?>">
                                                      <td> <?php echo $i; ?></td>
                                                      <td>
                                                        <?php 
                                                            echo $scorecard->company .'<div class="italic">#'. $scorecard->project_name .'</div>#' . $scorecard->start_date; 
                                                        ?>
                                                      </td>
                                                      <td><?php echo $scorecard->tag_name; ?> </td>
                                                      <td><?php echo $scorecard->staff_name; ?> </td>
                                                      <td><?php echo $scorecard->count_task; ?> </td>
                                                      <td><?php echo $scorecard->task_status_1; ?> </td>
                                                      <td><?php echo $scorecard->task_status_4; ?> </td>
                                                      <td><?php echo $scorecard->task_status_3; ?> </td>
                                                      <td><?php echo $scorecard->task_status_2; ?> </td>
                                                      <td><?php echo $scorecard->task_status_5; ?> </td>
                                                      <td><?php echo _d($scorecard->proposed_date); ?> </td>
                                                      <td><?php echo _d($scorecard->released_date); ?> </td>
                                                      <td><?php echo _d($scorecard->jobreport_date); ?> </td>

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