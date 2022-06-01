<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <?php 
                                $atd_this_month = isset($atd['this_month']['atd_duration']) ? $atd['this_month']['atd_duration'] : 0;
                                $atd_alltime = isset($atd['alltime']['atd_duration']) ? $atd['alltime']['atd_duration'] : 0;
                            ?>
                            <div class="quick-stats-projects col-xs-12 col-md-6 col-sm-6 col-lg-3">
                              <div class="top_stats_wrapper">
                                <p class="text-uppercase mtop5">
                                  <i class="hidden-sm fa fa-cubes"></i> <?= _l('average_tasks_duration') ?>
                                </p>
                                <div class="clearfix"></div>
                                <div class="progress no-margin progress-bar-mini">
                                  <div class="progress-bar no-percent-text not-dynamic" style="background: rgb(3, 169, 244); width: 8.43%;" role="progressbar" aria-valuenow="8.43" aria-valuemin="0" aria-valuemax="100" data-percent="8.43"></div>
                                </div><span class="pull-left  mtop5">M/A</span> <span class="pull-right  mtop5"><?=  $atd_this_month . '/'. $atd_alltime ?></span>
                              </div>
                            </div>


                            <div class="quick-stats-projects col-xs-12 col-md-6 col-sm-6 col-lg-3">
                              <div class="top_stats_wrapper">
                                <p class="text-uppercase mtop5">
                                  <i class="hidden-sm fa fa-cubes"></i> <?= _l('maximum_tasks_duration') ?>
                                </p>
                                <div class="clearfix"></div>
                                <div class="progress no-margin progress-bar-mini">
                                  <div class="progress-bar no-percent-text not-dynamic" style="background: rgb(3, 169, 244); width: 8.43%;" role="progressbar" aria-valuenow="8.43" aria-valuemin="0" aria-valuemax="100" data-percent="8.43"></div>
                                </div> <span class="pull-right  mtop5"><?= '*/'. $mtd[0]['mtd_duration'] ?></span>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="count_tasks_by_duration col-md-6 col-sm-12">
                                <?php $this->load->view('widgets/count_tasks_by_duration'); ?>                        
                            </div>
                            <div class="daily_completed_task col-md-6 col-sm-12">
                                <?php $this->load->view('widgets/daily_completed_task'); ?>                        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script type="text/javascript" id="scorecard-js" src="<?= base_url() ?>modules/scorecards/assets/js/scorecards.js?"></script>

</body>
</html>