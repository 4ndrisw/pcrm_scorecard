<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
    $CI = &get_instance();
    $CI->load->model('scorecards/tasks_duration_model');
    $scorecards = $CI->tasks_duration_model->get_maximum_task_duration_by_staff(get_staff_user_id());
?>

<div class="widget" id="widget-<?php echo create_widget_id(); ?>" data-name="<?php echo _l('maximum_tasks_duration_by_staff'); ?>">
    <?php if(staff_can('view', 'scorecards') || staff_can('view_own', 'scorecards')) { ?>
    <div class="panel_s scorecards-expiring">
        <div class="panel-body padding-10">
            <p class="padding-5"><?php echo _l('maximum_tasks_duration_by_staff'); ?></p>
            <hr class="hr-panel-heading-dashboard">
            <?php if (!empty($scorecards)) { ?>
                <div class="table-vertical-scroll">
                    <a href="<?php echo admin_url('scorecards'); ?>" class="mbot20 inline-block full-width"><?php echo _l('home_widget_view_all'); ?></a>
                    <table id="widget-<?php echo create_widget_id(); ?>" class="table dt-table" data-order-col="2" data-order-type="desc">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th><?php echo _l('staff_task_name'); ?></th>
                                <th><?php echo _l('days'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($scorecards as $scorecard) { ?>
                                <tr>
                                    <td> <?php echo $i; ?>
                                    </td>
                                    <td>
                                        <?php echo $scorecard['firstname']; ?>
                                    </td>
                                    <td>
                                        <?php echo round($scorecard['max_duration'],PHP_ROUND_HALF_DOWN); ?>
                                        <?php //echo round($scorecard['max_duration'],PHP_ROUND_HALF_DOWN) .' ' . _l('days'); ?>
                                    </td>
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
