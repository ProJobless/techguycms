<!--Display Errors-->
<?php echo validation_errors('<p class="error">'); ?>
<!--Display Message-->
<?php if($this->session->flashdata('settings_saved')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('settings_saved') . '</p>'; ?>
<?php endif; ?>
<!--Start Page-->
<div id="close">
<div id="content">
<h1>Blog Settings</h1>
<!--Start Form-->
<?php echo form_open('admin/settings/blog'); ?>
<div id="blogsettings"></div>

<!--Field: Activate Blog-->
<p>
<?php echo form_label('Activate Blog:'); ?><br />
 <?php if($activate_blog->value == 1) : ?>
 Yes <?php echo form_radio('activate_blog', '1', TRUE); ?>
 No  <?php echo form_radio('activate_blog', '0', FALSE); ?>
 <?php else : ?>
 Yes <?php echo form_radio('activate_blog', '1', FALSE); ?>
 No  <?php echo form_radio('activate_blog', '0', TRUE); ?>
 <?php endif; ?>
<a href="" class="someClass" title="<?php echo $activate_blog->description; ?>"><img class="tipimage" style="margin:0 0 -4px 5px"src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>

</p>

<!--Field: Post Count-->
<p>
<?php echo form_label('Post Count:'); ?><br />
<?php
$data = array(
              'name'        => 'post_num',
              'value'       => $post_num->value
            );
?>
<?php echo form_input($data); ?>
<a href="" class="someClass" title="<?php echo $post_num->description; ?>"><img class="tipimage" style="margin:0 0 -5px 5px"src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>

</p>

<!--Field: Char Count-->
<p>
<?php echo form_label('Character Count:'); ?><br />
<?php
$data = array(
              'name'        => 'intro_text_count',
              'value'       => $intro_text_count->value
            );
?>
<?php echo form_input($data); ?>
<a href="" class="someClass" title="<?php echo $intro_text_count->description; ?>"><img class="tipimage" style="margin:0 0 -5px 5px"src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>

</p>

<!--Field: Image Width-->
<p>
<?php echo form_label('Main Image Width:'); ?><br />
<?php
$data = array(
              'name'        => 'main_image_width',
              'value'       => $main_image_width->value
            );
?>
<?php echo form_input($data); ?>
<a href="" class="someClass" title="<?php echo $main_image_width->description; ?>"><img class="tipimage" style="margin:0 0 -5px 5px"src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>

</p>

<!--Field: Main Blog Page Modules-->
<p>
<?php echo form_label('Main Blog Page Modules:'); ?><br />
<select name ="page_modules[]" multiple="multiple">
<!--If front login is disabled, dont show login module as a choice-->
<?php if($mod_select[0]->id == 1 && $activate_frontend_login->value == 0) : ?>
<!--Remove login module from the array-->
<?php unset($mod_select[0]); ?>)
<?php endif; ?>
<!--Display modules for selection-->
<?php foreach($mod_select as $module) : ?>
<option value="<?php echo $module->id; ?>" 
<?php 
if(in_array($module->id,$selected_modules)){
            echo 'selected';
}
?>
><?php echo $module->name; ?>
</option>
    
<?php endforeach; ?>
</select><a href="" class="someClass" title="<?php echo $blog_modules->description; ?>"><img class="tipimage" style="margin:0 0 0px 5px"src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>

</div>

<div class="content-right">
<h1>Menu Options</h1>


<!--Field: Choose Menu-->
<p>
<?php echo form_label('Choose Menu:'); ?><br />
<select name="menu_id">
    <option value="0">No Menu</option>
    <?php foreach($menu_select as $menu) : ?>
        <option value="<?php echo $menu->id; ?>"
                <?php
                if($blog_menu_id->value == $menu->id){
                    echo 'selected';
                } else {
                    echo "";
                }
                ?>
                ><?php echo $menu->name; ?></option>
    <?php endforeach; ?>
</select><a href="" class="someClass" title="<?php echo $blog_menu_id->description; ?>"><img class="tipimage" style="margin:0 0 -5px 5px"src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>

<!--Field: Anchor-->
<p>
<?php echo form_label('Blog Menu Item Name:'); ?><br />
<?php
$data = array(
              'name'        => 'blog_menu_anchor',
              'value'       => $blog_menu_anchor->value
            );
?>
<?php echo form_input($data); ?>
<a href="" class="someClass" title="<?php echo $blog_menu_anchor->description; ?>"><img class="tipimage" style="margin:0 0 -5px 5px"src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>


<!--Field: Order-->
<p>
<?php echo form_label('Blog Menu Item Order:'); ?><br />
<?php
$data = array(
              'name'        => 'order',
              'value'       => $blog_item->order,
              'style'       => 'text-align:center;width:30px;'
            );
?>
<?php echo form_input($data); ?>
<a href="" class="someClass"  title="Choose the order position for the blog menu item. Current order is listed below"><img class="tipimage" style="margin:0 0 -4px 4px;" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>

<!--Current Page Order-->
<p>
<?php echo form_label('Current Page Orer:'); ?><br />
<table style="margin-top:0;" width="200">
<?php foreach($menu_items as $item) : ?>
<tr>
    <td><?php echo $item->anchor; ?></td>
     <td><?php echo $item->order; ?></td>
</tr>
    <?php endforeach; ?>
</table>
</p>
</div>
<div style="clear:both"></div>
 <?php echo form_submit('blog_submit','Save Settings'); ?> or <a href="<?php echo base_url(); ?>admin">Cancel</a>