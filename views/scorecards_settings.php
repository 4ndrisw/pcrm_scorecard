<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php echo form_hidden('scorecards_settings'); ?>
<div class="horizontal-scrollable-tabs mbot15">
   <div role="tabpanel" class="tab-pane" id="scorecards">
      <div class="form-group">
         <label class="control-label" for="scorecard_prefix"><?php echo _l('scorecard_prefix'); ?></label>
         <input type="text" name="settings[scorecard_prefix]" class="form-control" value="<?php echo get_option('scorecard_prefix'); ?>">
      </div>
      
      <?php echo render_input('settings[scorecard_year]','scorecard_year',get_option('scorecard_year'), 'number', ['min'=>2020]); ?>
      <hr />
      
   </div>
 <?php hooks()->do_action('after_scorecards_tabs_content'); ?>
</div>
