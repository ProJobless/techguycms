<h5>Quick Links</h5>
<ul id="admin_quick_links">
    <li><a href="<?php echo base_url(); ?>admin/pages">
            <img src="<?php echo base_url(); ?>assets/images/admin/icons/document_48.png" /><br />
            Pages<br />
            <div style="padding:5px;background:#4b4a4a;margin-top:10px">
            <a href="<?php echo base_url(); ?>admin/page/add">Add</a> | <a href="<?php echo base_url(); ?>admin/pages">View</a>
            </div>
    </a></li>
    <?php if($activate_blog->value == 1) : ?>
        <li><a href="<?php echo base_url(); ?>admin/posts">
            <img src="<?php echo base_url(); ?>assets/images/admin/icons/pencil_48.png" /><br />
            Blog Manager<br />
            <div style="padding:5px;background:#4b4a4a;margin-top:10px">
            <a href="<?php echo base_url(); ?>admin/post/add">Add</a> | <a href="<?php echo base_url(); ?>admin/posts">View</a>
            </div>
            </a>
        </li>
    
     <li><a href="<?php echo base_url(); ?>admin/post/comments">
            <img src="<?php echo base_url(); ?>assets/images/admin/icons/note_48.png" /><br />
            Comments<br />
            <div style="padding:5px;background:#4b4a4a;margin-top:10px">
            <a href="<?php echo base_url(); ?>admin/post/comments">View</a>
            </div>
    </a></li>
    <?php endif; ?>
      <li><a href="<?php echo base_url(); ?>admin/users">
            <img src="<?php echo base_url(); ?>assets/images/admin/icons/man_48.png" /><br />
           Users<br />
            <div style="padding:5px;background:#4b4a4a;margin-top:10px">
           <a href="<?php echo base_url(); ?>admin/user/add">Add</a> | <a href="<?php echo base_url(); ?>admin/users">View</a>
            </div>
    </a></li>
     <li><a href="<?php echo base_url(); ?>admin/forms">
            <img src="<?php echo base_url(); ?>assets/images/admin/icons/document_48.png" /><br />
           Forms<br />
            <div style="padding:5px;background:#4b4a4a;margin-top:10px">
           <a href="<?php echo base_url(); ?>admin/form/add">Add</a> | <a href="<?php echo base_url(); ?>admin/forms">View</a>
            </div>
    </a></li>
       <li><a href="<?php echo base_url(); ?>admin/modules">
            <img src="<?php echo base_url(); ?>assets/images/admin/icons/app_globe_48.png" /><br />
           Modules<br />
            <div style="padding:5px;background:#4b4a4a;margin-top:10px">
           <a href="<?php echo base_url(); ?>admin/module/add">Add</a> | <a href="<?php echo base_url(); ?>admin/modules">View</a>
            </div>
    </a></li>
      <li><a href="<?php echo base_url(); ?>admin/settings">
            <img src="<?php echo base_url(); ?>assets/images/admin/icons/gear_48.png" /><br />
            Settings<br />
            <div style="padding:5px;background:#4b4a4a;margin-top:10px">
            <a href="<?php echo base_url(); ?>admin/settings">Edit Settings</a>
            </div>
    </a></li>
      <li><a href="<?php echo base_url(); ?>admin/help">
            <img src="<?php echo base_url(); ?>assets/images/admin/icons/info_48.png" /><br />
           Help & Info<br />
            <div style="padding:5px;background:#4b4a4a;margin-top:10px">
           <a href="<?php echo base_url(); ?>admin/help">View</a>
            </div>
    </a></li>
</ul>