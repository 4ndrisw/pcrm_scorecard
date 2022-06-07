<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php 
    $CI = &get_instance();
    $CI->load->model('scorecards/tasks_history_model');
    $scorecards = $CI->company_recapitulation_model->get_daily_count_update_status();

 //   echo $scorecards; return;
?>


<div class="widget" id="widget-<?php echo create_widget_id(); ?>" data-name="<?php echo _l('daily_count_update_status'); ?>">
    <?php if(staff_can('view', 'scorecards') || staff_can('view_own', 'scorecards')) { ?>
    <div class="panel_s scorecards-expiring">
        <div class="panel-body padding-10">
            <p class="padding-5"><?php echo _l('daily_count_update_status'); ?></p>
            <hr class="hr-panel-heading-dashboard">
            <?php if (!empty($scorecards)) { ?>
                <div class="table-vertical-scroll">
                    <a href="<?php echo admin_url('scorecards'); ?>" class="mbot20 inline-block full-width"><?php echo _l('home_widget_view_all'); ?></a>

                    <table id="widget-<?php echo create_widget_id(); ?>" class="table dt-table" data-order-col="1" data-order-type="desc">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th><?php echo _l('date'); ?></th>
                                <th><?php echo _l('task_status_1'); ?></th>
                                <th><?php echo _l('task_status_4'); ?></th>
                                <th><?php echo _l('task_status_3'); ?></th>
                                <th><?php echo _l('task_status_2'); ?></th>
                                <th><?php echo _l('task_status_5'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($scorecards as $scorecard) { ?>
                                <tr>
                                    <td> <?php echo $i; ?></td>
                                    <td><?php echo $scorecard->date_added; ?></td>
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

