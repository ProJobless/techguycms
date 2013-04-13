<h1>Global Settings</h1>
<?php if($this->session->flashdata('settings_saved')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('settings_saved') . '</p>'; ?>
<?php endif; ?>

<?php echo validation_errors('<p class="error">'); ?>
<?php $attributes = array('id' => 'settings_form'); ?>
<?php echo form_open_multipart('admin/settings',$attributes); ?>
<h2>General</h2>
<!--Website name-->
<p>
<label for="site_name">Website Name:</label><br />
<?php echo form_input('site_name',$website_name->value); ?>
<span class="info">This text will be used as your logo if you choose a text logo</span>
</p>

<!--Headline-->
<p>
<label for="headline_text">Headline Text:</label><br />
<?php echo form_input('headline_text',$headline_text->value); ?>
<span class="info">This will only be used if you choose a text logo</span>
</p>
<!--logo type-->
<p>
<label for="logo_type">Logo Type:</label><br />
 <?php if($logo_type->value == 'image') : ?>
 Image <?php echo form_radio('logo_type', 'image', TRUE); ?>
 Text  <?php echo form_radio('logo_type', 'text', FALSE); ?>
 <?php else : ?>
 Image <?php echo form_radio('logo_type', 'image', FALSE); ?>
 Text  <?php echo form_radio('logo_type', 'text', TRUE); ?>
 <?php endif; ?>
</p>

    <!--Logo-->
<p>
    
<label for="logo_image">Website Logo:</label><br />
Upload Main Image
<img  style="float:left;margin-right:15px" width="80" src="<?php echo base_url(); ?>assets/images/<?php echo $logo_image->value; ?>" />

<input type="file" name="userfile" size="20" />
<p>
Current Image Name: <strong><?php echo $logo_image->value; ?></strong>
</p>
<br /><br />
</p>

<!--Copyright-->
<p>
<label for="copyright">Copyright Text:</label><br />
<?php echo form_input('copyright',$copyright->value); ?>
<span class="info"></span>
</p>

<h2>Global META & SEO</h2>
<!--Page Title-->
<p>
<label for="page_title">Global Page Title:</label><br />
<?php echo form_input('page_title',$page_title->value); ?>
<span class="info">This will be used on pages that you do not specify a custom page title</span>
</p>

<!--Keywords-->
<p>
<label for="meta_keywords">Meta Keywords:</label><br />
<?php echo form_input('meta_keywords',$meta_keywords->value); ?>
<span class="info">This will be used on pages that you do not specify a custom page keywords</span>
</p>

<!--Description-->
<p>
<label for="meta_description">Meta Description:</label><br />
<?php echo form_textarea('meta_description',$meta_description->value); ?>
<span class="info">This will be used on pages that you do not specify a meta description</span>
</p>

<h2>Other Settings</h2>
<!--Analytics-->
<p>
<label for="analytics">Google Analytics :</label><br />
<?php echo form_textarea('analytics',$google_analytics->value); ?>
<span class="info">Enter the code from your Google analytics account</span>
</p>

<?php
$data = array(
              'name'        => 'submit',
              'id'          => 'settings_submit',
              'value'       =>  'Save Settings'
        );
?>
<br />
<p>
    <?php echo form_submit($data); ?> or <a href="<?php echo base_url(); ?>admin/dashboard">Cancel</a>
</p>
<?php echo form_close(); ?>
