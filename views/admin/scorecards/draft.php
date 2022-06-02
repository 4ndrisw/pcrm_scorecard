<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="panel_s">
                    <div class="panel-body">


                        <?php 
                            echo form_open($this->uri->uri_string(), array('class'=>'pull-right mtop7 action-button'));
                            echo form_hidden('scorecards_action', 4);
                            echo '<button type="submit" data-loading-text="'._l('wait_text').'" autocomplete="off" class="btn btn-success action-button accept"><i class="fa fa-check"></i> '._l('clients_accept_schedule').'</button>';
                            echo form_close();
                        ?>
                        <div class="clearfix"></div>
                        <?php 
/*
                            $records = [];
                            foreach($tasks as $key => $task){
                                $records[$key] = $task;
                            }
*/
                            echo '<pre>';
//                            var_dump($records);
                            if(is_array($tasks)){
                                var_dump($tasks);
                            }
                            else{
                                echo($tasks);                                
                            }
                            echo '</pre>';
                        ?>

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