<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="average_tasks_duration_by_staff col-md-6 col-sm-12">
                                <?php $this->load->view('widgets/average_tasks_duration_by_staff'); ?>
                            </div>
                            <div class="maximum_tasks_duration_by_staff col-md-6 col-sm-12">
                                <?php $this->load->view('widgets/maximum_tasks_duration_by_staff'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="count_tasks_by_duration_per_staff col-md-6 col-sm-12">
                                <?php $this->load->view('widgets/count_tasks_by_duration_per_staff'); ?>                        
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