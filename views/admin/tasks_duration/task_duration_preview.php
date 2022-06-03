<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-6 no-padding">
				<?php 
		        	if ($this->input->is_ajax_request()) {
		            $this->app->get_table_data(module_views_path('scorecards', 'admin/tables/small_table'));
		        	}
					//$this->load->view('admin/tasks_duration/task_duration_small_table'); 
				?>
			</div>
			<div class="col-md-6 no-padding task_duration-preview">
				<?php $this->load->view('admin/tasks_duration/task_duration_preview_template'); ?>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>

<script>
    $(function(){
        initDataTable('.table-tasks_duration', window.location.href, 'undefined', 'undefined','fnServerParams', [0, 'desc']);
    });
</script>

</body>
</html>
