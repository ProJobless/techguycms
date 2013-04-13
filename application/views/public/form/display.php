<!--Display Errors-->
<?php echo validation_errors('<p class="error">'); ?>
<!--Display Messages-->
 <?php if($this->session->flashdata('mail_sent')) : ?>
<?php echo '<p class="error">' .$this->session->flashdata('mail_sent') . '</p>'; ?>
<?php endif; ?>
<!--Start Page-->
<h1><?php echo ucwords($form->name); ?></h1>
<?php echo $code; ?>