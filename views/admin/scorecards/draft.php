<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
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