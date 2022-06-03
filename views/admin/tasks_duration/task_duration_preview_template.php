<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="col-md-12 no-padding">
   <div class="panel_s">
      <div class="panel-body">

         <div class="row mtop10">
            <div class="col-md-3 no-padding">
               <?php //echo format_task_duration_status($task_duration->status,'mtop5');  ?>
            </div>
            <div class="col-md-9 no-padding">
               <div class="visible-xs">
                  <div class="mtop10"></div>
               </div>
               <div class="pull-right _buttons">
                  <?php if((staff_can('edit', 'task_durations')) || is_admin()){ ?>                     
                     <a href="<?php echo admin_url('task_durations/update/'.$task_duration->id); ?>" class="btn btn-default btn-with-tooltip" data-toggle="tooltip" title="<?php echo _l('edit_task_duration_tooltip'); ?>" data-placement="bottom"><i class="fa fa-pencil-square-o"></i></a>
                  
                  <?php } ?>
                  <div class="btn-group">
                     <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf-o"></i><?php if(is_mobile()){echo ' PDF';} ?> <span class="caret"></span></a>
                     <ul class="dropdown-menu dropdown-menu-right">
                        <li class="hidden-xs"><a href="<?php echo site_url('task_durations/pdf/'.$task_duration->id.'?output_type=I'); ?>"><?php echo _l('view_pdf'); ?></a></li>
                        <li class="hidden-xs"><a href="<?php echo site_url('task_durations/pdf/'.$task_duration->id.'?output_type=I'); ?>" target="_blank"><?php echo _l('view_pdf_in_new_window'); ?></a></li>
                        <li><a href="<?php echo site_url('task_durations/pdf/'.$task_duration->id); ?>"><?php echo _l('download'); ?></a></li>
                        <li>
                           <a href="<?php echo site_url('task_durations/pdf/'.$task_duration->id.'?print=true'); ?>" target="_blank">
                           <?php echo _l('print'); ?>
                           </a>
                        </li>
                     </ul>
                  </div>


               </div>
            </div>
         </div>
         <div class="clearfix"></div>
         <hr class="hr-panel-heading" />
         <div class="tab-content">
            <div role="tabanel" class="tab-pane ptop10 active" id="tab_task_duration">
               <div id="task_duration-preview">
                  <div class="row">
                     <?php if($task_duration->rel_id != 0){ ?>
                     <div class="col-md-12">
                        <h4 class="font-medium mbot15"><?php echo _l('related_to_project',array(
                           _l('task_duration_lowercase'),
                           _l('task_lowercase'),
                           '<a href="'.admin_url('tasks/view/'.$task_duration->task_id).'" target="_blank">' . $task_duration->name . '</a>',
                           )); ?></h4>
                     </div>
                     <?php } ?>
                     <div class="col-md-6 col-sm-6">
                        <h4 class="bold">
                           <?php
                              $tags = get_tags_in($task_duration->task_id,'tasks');
                              if(count($tags) > 0){
                                echo '<i class="fa fa-tag" aria-hidden="true" data-toggle="tooltip" data-title="'.html_escape(implode(', ',$tags)).'"></i>';
                              }
                              ?>
                           <a href="<?php echo site_url('task_durations/show/'.$task_duration->id/*.'/'.$task_duration->hash*/); ?>">
                           <span id="task_duration-number">
                           <?php //echo format_task_duration_number($task_duration->id); ?>
                           <?php echo _l('task_duration') .' '. $task_duration->id; ?>
                           </span>
                           </a>
                        </h4>

                     </div>
                  </div>
                  <div class="row">
                     <div class="container-fluid">
                        <div class="task_duration-overview col-md-12">
                         <?php $client = $task_duration->project_data->client_data; ?>
                         <?php $project = $task_duration->project_data; ?>
                        <dl class="dl-horizontal">
                          <dt><?= _l('task_duration_dateadded') ?> <span class="float-right">:</span></span></dt><dd><?=$task_duration->dateadded ?></dd>
                          <dt><?= _l('task_duration_datefinished') ?> <span class="float-right">:</span></dt><dd><?=$task_duration->datefinished ?></dd>
                          <dt><?= _l('task_duration_duration') ?> <span class="float-right">:</span></dt><dd><?=$task_duration->duration .' '. _l('days') ?></dd>
                          <dt><?= _l('task_duration_staff_id') ?> <span class="float-right">:</span></dt><dd><?=$task_duration->firstname .' '. $task_duration->lastname ?></dd>
                          <dt><?= _l('task_duration_client_company') ?> <span class="float-right">:</span></dt><dd><?=$client->company ?></dd>
                          <dt><?= _l('task_duration_project_name') ?> <span class="float-right">:</span></dt><dd><?=$project->name ?></dd>
                        </dl>
                         <?php $task_history = $task_duration->task_history_data; ?>
                         <div class="table-responsive">
                            <table class="table dt-table">
                               <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                  </tr>
                               </thead>
                               <tbody>
                                 <?php $i = 1; ?>
                                  <?php foreach($task_history as $history){ ?>
                                    <tr>
                                       <td><?= $i ?></td>
                                       <td><?= $history->dateadded ?></td>
                                       <td>
                                       <?php echo format_task_status($history->status,'mtop5');  ?>

                                       </td>
                                    </tr>
                                  <?php $i++; ?>
                                  <?php } ?>
                               </tbody>
                            </table>                         
                         </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-12 task_duration-items">
                        <div class="table-responsive">
                              <?php
                                 //$items = get_task_duration_items_table_data($task_duration, 'task_duration', 'html', true);
                                 //echo $items->table();
                              ?>
                        </div>
                     </div>

                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
