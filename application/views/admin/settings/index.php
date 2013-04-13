<script>
    $(document).ready(function(){
       var dd = $('dd');
       dd.filter(':nth-child(n+4)').addClass('hide');
       
       $('dl').on('click', 'dt', function(){
           $(this)
                .next()
                .slideDown(800)
                .siblings('dd')
                .slideUp(800);
       });
    });
</script>
<?php
$data = array(
              'name'        => 'submit',
              'id'          => 'settings_submit',
              'value'       =>  'Save Settings'
        );
?>
<br />
<?php $attributes = array('id' => 'settings_form'); ?>
<?php echo form_open_multipart('admin/settings',$attributes); ?>

<p style="float:right">
    <?php echo form_submit($data); ?> or <a href="<?php echo base_url(); ?>admin/dashboard">Cancel</a>
</p>
<div style="clear:both;"></div>

 <?php if($this->session->flashdata('settings_saved')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('settings_saved') . '</p>'; ?>
<?php endif; ?>

 <?php if($this->session->flashdata('images_folder')) : ?> 
<?php echo '<p class="error">' .$this->session->flashdata('images_folder') . '</p>'; ?>
<?php endif; ?>
         <?php if($this->session->flashdata('images_logo_folder')) : ?>
<?php echo '<p class="error">' .$this->session->flashdata('images_logo_folder') . '</p>'; ?>
<?php endif; ?>

<?php echo validation_errors('<p class="error">'); ?>

<div id="settings">
<h1>Settings</h1>
<dl>
	<dt>General</dt>
	<dd>
          <?php
            $this->load->view('admin/settings/general')
          ?>
        </dd>
        <dt>Global SEO & Meta</dt>
	<dd>
          <?php
            $this->load->view('admin/settings/seo')
          ?>
        </dd>
	<dt>Blog Settings</dt>
	<dd>
          <?php
            $this->load->view('admin/settings/blog')
          ?>
        </dd>
	<dt>Social Media & Integration</dt>
	<dd>
          <?php
            $this->load->view('admin/settings/social')
          ?>
        </dd>
	<dt>Misc</dt>
	<dd>
          <?php
            $this->load->view('admin/settings/misc')
          ?>
        </dd>
	
</dl>

<?php echo form_close(); ?>
</div>