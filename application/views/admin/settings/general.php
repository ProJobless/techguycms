
<!--Field: Website Name-->
<p>
<?php echo form_label('Website Name:'); ?><br />
<?php
$data = array(
              'name'        => 'site_name',
              'value'       => $website_name->value
            );
?>
<?php echo form_input($data); ?>
<a href="" class="someClass" title="<?php echo $website_name->description; ?>"><img class="tipimage" style="margin:0 0 -5px 5px"src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>

<!--Field: Headline-->
<p>
<?php echo form_label('Headline Text:'); ?><br />
<?php
$data = array(
              'name'        => 'headline_text',
              'value'       => $headline_text->value
            );
?>
<?php echo form_input($data); ?>
<a href="" class="someClass" title="<?php echo $headline_text->description; ?>"><img class="tipimage" style="margin:0 0 -5px 5px"src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>

<!--Field: Logo Type-->
<p>
<?php echo form_label('Logo Type:'); ?><br />
 <?php if($logo_type->value == 'image') : ?>
 Image <?php echo form_radio('logo_type', 'image', TRUE); ?>
 Text  <?php echo form_radio('logo_type', 'text', FALSE); ?>
 <?php else : ?>
 Image <?php echo form_radio('logo_type', 'image', FALSE); ?>
 Text  <?php echo form_radio('logo_type', 'text', TRUE); ?>
 <?php endif; ?> <a href="" class="someClass" title="<?php echo $logo_type->description; ?>"><img class="tipimage" style="margin:0 0 -5px 5px"src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>

<!--Field: Logo-->
<p>
    
<?php echo form_label('Website Logo:'); ?><br />
Upload Main Image
<img  style="float:left;margin-right:15px" width="80" src="<?php echo base_url(); ?>assets/images/logo/<?php echo $logo_image->value; ?>" />

<input type="file" name="userfile" size="20" />
<p>
Current Image Name: <strong><?php echo $logo_image->value; ?></strong>
</p>
<br /><br />
</p>

<!--Field: Logo Width-->
<p>
<?php echo form_label('Logo Width:'); ?><br />
<?php
$data = array(
              'name'        => 'logo_width',
              'value'       => $logo_width->value,
              'style'       => 'width:40px'
            );
?>
<?php echo form_input($data); ?>
<span class="info">px</span>
</p>

<!--Field: Logo Height-->
<p>
<?php echo form_label('Logo Height:'); ?><br />
<?php
$data = array(
              'name'        => 'logo_height',
              'value'       => $logo_height->value,
              'style'       => 'width:40px'
            );
?>
<?php echo form_input($data); ?>
    <span class="info">px</span>
</p>

<!--Field: Copyright-->
<p>
<?php echo form_label('Copyright Text:'); ?><br />
<?php if($copyright->value == "" || !isset($copyright->value)) : ?>
<?php echo form_input('copyright',$website_name->value); ?>
<?php else : ?>
<?php echo form_input('copyright',$copyright->value); ?>
<?php endif; ?>
<a href="" class="someClass" title="<?php echo $copyright->description; ?>"><img class="tipimage" style="margin:0 0 -5px 5px"src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>

<!--Field: Frontend Login-->
<p>
<?php echo form_label('Activate Frontend Login/Registration:'); ?><br />
 <?php if($activate_frontend_login->value == '1') : ?>
 Yes <?php echo form_radio('frontend_login', '1', TRUE); ?>
 No  <?php echo form_radio('frontend_login', '0', FALSE); ?>
 <?php else : ?>
 Yes <?php echo form_radio('frontend_login', '1', FALSE); ?>
 No  <?php echo form_radio('frontend_login', '0', TRUE); ?>
 <?php endif; ?>
<a href="" class="someClass" title="<?php echo $activate_frontend_login->description; ?>"><img class="tipimage" style="margin:0 0 -5px 5px"src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>

