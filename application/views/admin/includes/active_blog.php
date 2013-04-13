<div id="blog_options">
    <ul> 
<?php if($blog_activated == 1) : ?>
    <li>  <strong>Blog Active:</strong> Yes <a href="<?php echo base_url(); ?>admin/dashboard/deactivate_blog">(Deactivate)</a></li>
    <?php else : ?>
         <li>  <strong>Blog Active:</strong> No <a href="<?php echo base_url(); ?>admin/dashboard/activate_blog">(Activate)</a></li>
    <?php endif; ?>
         <?php if($blog_activated == 1) : ?>
         <li>    <strong>Blog Settings: </strong><a href="<?php echo base_url(); ?>admin/settings/blog">Edit</a></li>
 <?php endif; ?>
</ul>
</div>