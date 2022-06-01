<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
    $CI = &get_instance();
    $CI->load->model('scorecards/company_recapitulation_model');
    $scorecards = $CI->company_recapitulation_model->get_count_tasks_by_duration();
?>


<div class="widget" id="widget-<?php echo create_widget_id(); ?>" data-name="<?php echo _l('count_tasks_by_duration'); ?>">
    <?php if(staff_can('view', 'scorecards') || staff_can('view_own', 'scorecards')) { ?>
    <div class="panel_s scorecards-expiring">
        <div class="panel-body padding-10">
            <p class="padding-5"><?php echo _l('count_tasks_by_duration'); ?></p>
            <hr class="hr-panel-heading-dashboard">
            <?php if (!empty($scorecards)) { ?>
                <div class="table-vertical-scroll">
                    <a href="<?php echo admin_url('scorecards'); ?>" class="mbot20 inline-block full-width"><?php echo _l('home_widget_view_all'); ?></a>
                    <table id="widget-<?php echo create_widget_id(); ?>" class="table dt-table" data-order-col="1" data-order-type="desc">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th><?php echo _l('days'); ?></th>
                                <th><?php echo _l('count'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($scorecards as $scorecard) { ?>
                                <tr>
                                    <td> <?php echo $i; ?></td>
                                    <td><?php echo $scorecard['duration']; ?></td>
                                    <td><?php echo $scorecard['ctd_duration']; ?></td>
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

