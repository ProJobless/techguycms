<!--Messages-->
<?php if($this->session->flashdata('no_activation')) : ?>
<?php echo '<p class="error">' .$this->session->flashdata('no_activation') . '</p>'; //Activation is incorect ?>
<?php endif; ?>

<?php if($this->session->flashdata('yes_activation')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('yes_activation') . '</p>'; //Activation is corect ?>
<?php endif; ?>

<?php if($this->session->flashdata('no_reset')) : ?>
<?php echo '<p class="error">' .$this->session->flashdata('no_reset') . '</p>'; //Reset is incorect ?>
<?php endif; ?>

<?php if($this->session->flashdata('yes_reset')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('yes_reset') . '</p>'; //Reset is correct ?>
<?php endif; ?>

<?php if($this->session->flashdata('pass_login')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('pass_login') . '</p>'; //Login is correct ?>
<?php endif; ?>

<?php if($this->session->flashdata('logged_out')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('logged_out') . '</p>'; //User has been logged out ?>
<?php endif; ?>

<?php if($this->session->flashdata('reset_complete')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('reset_complete') . '</p>'; //Password was reset ?>
<?php endif; ?>

<?php if($this->session->flashdata('email_send_yes')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('email_send_yes') . '</p>'; //Activation email sent ?>
<?php endif; ?>

<?php if($this->session->flashdata('email_send_no')) : ?>
<?php echo '<p class="error">' .$this->session->flashdata('email_send_no') . '</p>'; //Activation email not sent ?>
<?php endif; ?>


<!--Display "featured" page feed-->
<?php foreach ($pages as $page) : ?>
    <h1><?php echo $page->name; ?></h1>
    <?php echo $page->body; ?>
<?php endforeach; ?>
 
    
   
    

  
  
 