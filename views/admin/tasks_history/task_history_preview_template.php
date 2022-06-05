<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="col-md-12 no-padding">
   <div class="panel_s">
      <div class="panel-body">
         <div class="row mtop10">
            <div class="col-md-3 no-padding">
               <?php //echo format_task_history_status($task_history->status,'mtop5');  ?>
            </div>
            <div class="col-md-9 no-padding">
               <div class="visible-xs">
                  <div class="mtop10"></div>
               </div>
               <div class="pull-right _buttons">
                  <div class="btn-group">
                     <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf-o"></i><?php if(is_mobile()){echo ' PDF';} ?> <span class="caret"></span></a>
                     <ul class="dropdown-menu dropdown-menu-right">
                        <li class="hidden-xs"><a href="<?php echo site_url('task_historys/pdf/'.$task->id.'?output_type=I'); ?>"><?php echo _l('view_pdf'); ?></a></li>
                        <li class="hidden-xs"><a href="<?php echo site_url('task_historys/pdf/'.$task->id.'?output_type=I'); ?>" target="_blank"><?php echo _l('view_pdf_in_new_window'); ?></a></li>
                        <li><a href="<?php echo site_url('task_historys/pdf/'.$task->id); ?>"><?php echo _l('download'); ?></a></li>
                        <li>
                           <a href="<?php echo site_url('task_historys/pdf/'.$task->id.'?print=true'); ?>" target="_blank">
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
            <div role="tabanel" class="tab-pane ptop10 active" id="tab_task_history">
               <div id="task_history-preview">
                  <div class="row">
                     <?php if($task->rel_id != 0){ ?>
                     <div class="col-md-12">
                        <h4 class="font-medium mbot15"><?php echo _l('related_to_project',array(
                           _l('task_history_lowercase'),
                           _l('task_lowercase'),
                           '<a href="'.admin_url('tasks/view/'.$task->id).'" target="_blank">' . $task->name . '</a>',
                           )); ?></h4>
                     </div>
                     <?php } ?>
                     <div class="col-md-6 col-sm-6">
                        <h4 class="bold">
                           <?php
                              $tags = get_tags_in($task->id,'tasks');
                              if(count($tags) > 0){
                                echo '<i class="fa fa-tag" aria-hidden="true" data-toggle="tooltip" data-title="'.html_escape(implode(', ',$tags)).'"></i>';
                              }
                              ?>
                           <a href="<?php echo site_url('task_historys/show/'.$task->id/*.'/'.$task_history->hash*/); ?>">
                           <span id="task_history-number">
                           <?php //echo format_task_history_number($task->id); ?>
                           <?php echo _l('task_history') .' '. $task->id; ?>
                           </span>
                           </a>
                        </h4>

                     </div>
                  </div>
                  <div class="row">
                     <div class="container-fluid">
                        <div class="task_history-overview col-md-12">
                         <?php $client = $task->project_data->client_data; ?>
                         <?php $project = $task->project_data; ?>
                        <dl class="dl-horizontal">
                          <dt><?= _l('task_history_dateadded') ?> <span class="float-right">:</span></span></dt><dd><?=$task->dateadded ?></dd>
                          <dt><?= _l('task_history_datefinished') ?> <span class="float-right">:</span></dt><dd><?=$task->datefinished ?></dd>
                          <dt><?= _l('task_history_staff_id') ?> <span class="float-right">:</span></dt><dd><?=$task->assignees[0]['firstname'] .' '. $task->assignees[0]['lastname'] ?></dd>
                          <dt><?= _l('task_history_client_company') ?> <span class="float-right">:</span></dt><dd><?=$client->company ?></dd>
                          <dt><?= _l('task_history_project_name') ?> <span class="float-right">:</span></dt><dd><?=$project->name ?></dd>
                        </dl>
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
                     <div class="col-md-12 task_history-items">
                        <div class="table-responsive">
                              <?php
                                 //$items = get_task_history_items_table_data($task_history, 'task_history', 'html', true);
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
