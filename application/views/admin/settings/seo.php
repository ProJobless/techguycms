<!--Field: Page Title-->
<p>
<?php echo form_label('Global Page Title:'); ?><br />
<?php
$data = array(
              'name'        => 'page_title',
              'value'       => $page_title->value
            );
?>
<?php echo form_input($data); ?>
<a href="" class="someClass" title="<?php echo $page_title->description; ?>"><img class="tipimage" style="margin:0 0 -5px 5px"src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>

<!--Field: Keywords-->
<p>
<?php echo form_label('Global Meta Keywords:'); ?><br />
<?php
$data = array(
              'name'        => 'meta_keywords',
              'value'       => $meta_keywords->value
            );
?>
<?php echo form_input($data); ?>
<a href="" class="someClass" title="<?php echo $meta_keywords->description; ?>"><img class="tipimage" style="margin:0 0 -5px 5px"src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>

<!--Field: Description-->
<p>
<?php echo form_label('Global Meta Description:'); ?><br />
<?php
$data = array(
              'name'        => 'meta_description',
              'value'       => $meta_description->value
            );
?>
<?php echo form_textarea($data); ?>
<a href="" class="someClass" title="<?php echo $meta_description->description; ?>"><img class="tipimage" style="margin:0 0 -2px 5px"src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>

