<div id="content">
    <h1><?php echo $website_name->value; ?> Dashboard</h1>
   
        <?php $this->load->view('admin/includes/quick_links'); ?>
    <div style="clear:both"></div>
    <br />
    <br />
     <?php if(!empty($unwriteable)) : ?>
    <p class="error"><strong>Important:</strong> The following files are not writable and need to be in order for the site to run properly..Please chmod them to 777 via FTP client, file manager or SSH</p>
    <ul>
        <?php foreach($unwriteable as $file) : ?>
            <li><strong><?php echo $file; ?></strong></li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
</div>

<div id="sidebar">
       <?php $this->load->view('admin/includes/active_blog'); ?>
       <?php $this->load->view('admin/includes/stats'); ?>
</div>