<!--Field: Google Analytics-->
<p>
<?php echo form_label('Google Analytics:'); ?><br />
<?php
$data = array(
              'name'        => 'analytics',
              'value'       => $google_analytics->value
            );
?>
<?php echo form_textarea($data); ?>
<a href="" class="someClass" title="<?php echo $google_analytics->description; ?>"><img class="tipimage" style="margin:0 0 0 5px"src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>

<!--Submit Button-->
<?php
$data = array(
              'name'        => 'submit',
              'id'          => 'settings_submit',
              'value'       => 'Save Settings'
        );
?>
<br />
<p>
    <?php echo form_submit($data); ?> or <a href="<?php echo base_url(); ?>admin/dashboard">Cancel</a>
</p>