<!--Display form validation errors-->
<?php echo validation_errors('<p class="error">'); ?>
<!--Display Message-->
<?php if($this->session->flashdata('page_routes_writable')) : ?> 
<?php echo '<p class="error">' .$this->session->flashdata('page_routes_writable') . '</p>'; ?>
<?php endif; ?>

<!--Start Page-->
<div id="content">
<h1>Add A New Page</h1>
<!--Start Form-->
<?php $attributes = array('id' => 'add_page_form'); ?>
<?php echo form_open('admin/page/add',$attributes); ?>

<!--Field: Page Name-->
<p>
<?php echo form_label('Page Name:'); ?><br />
<?php
$data = array(
              'name'        => 'page_name',
              'value'       => set_value('page_name')
            );
?>
<?php echo form_input($data); ?>
</p>

<!--Field: Page Body-->
<?php
$data = array(
              'name'        => 'page_body',
              'id'          => 'page_body',
              'value'       => set_value('page_body'),
              'maxlength'   => '500',
              'style'       => 'width:90%',
            );
?>
<p>
<script type="text/javascript">
	window.onload = function()
	{
		CKEDITOR.replace( 'page_body' );
	};
</script>
<?php echo form_label('Page Body:'); ?><br />
<?php echo form_textarea($data); ?>
</p>

<!--Field: Page Modules-->
<p>
<?php echo form_label('Page Modules:'); ?><br />
<select name ="page_modules[]" multiple="multiple">
    <!--If front login is disabled, dont show login module as a choice-->
<?php if($mod_select[0]->id == 1 && $activate_frontend_login->value == 0) : ?>
    <!--Remove login module from the array-->
    <?php unset($mod_select[0]); ?>)
<?php endif; ?>
<!--Display modules for selection-->
<?php foreach($mod_select as $module) : ?>
    <option value="<?php echo $module->id; ?>" <?php echo set_select('page_modules',$module->id); ?>><?php echo $module->name; ?></option>
<?php endforeach; ?>
</select>
<a href="" class="someClass" title="Choose which modules will show on this page"><img class="tipimage" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>

<br />

<!--Field: Featured-->
<p>
    <?php echo form_label('Featured:'); ?><br />
    Yes <?php echo form_radio(array("name"=>"featured","id"=>"featured_yes","value"=>"1", 'checked'=>set_radio('featured', '1', FALSE))); ?>
   No  <?php echo form_radio(array("name"=>"featured","id"=>"featured_no","value"=>"0", 'checked'=>set_radio('featured', '0', TRUE))); ?><a href="" class="someClass" title="If 'featured', it will show on the homepage"><img class="tipimage" style="margin:0 0 -2px 5px"src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>
</p>

<br />

<!--Field: Access-->
<p>
  <?php echo form_label('Page Access:'); ?><br />
   Everyone  <?php echo form_radio('page_access', '0', TRUE); ?><span class="info-padding">Everyone can see this page and menu item</span><br />
   Registered Users Only <?php echo form_radio('page_access', '1', FALSE); ?><span class="info-padding">Only logged in users can see this page and menu item</span>
</p>

<br />

<!--Field: Published-->
<p>
    <?php echo form_label('Published:'); ?><br />
    Yes <?php echo form_radio(array("name"=>"published","id"=>"published_yes","value"=>"1", 'checked'=>set_radio('published', '1', TRUE))); ?>
   No  <?php echo form_radio(array("name"=>"published","id"=>"published_no","value"=>"0", 'checked'=>set_radio('published', '0', FALSE))); ?>
</p>

</div>

<!--SIDEBAR-->
<div id="sidebar">
    
<h1>SEO Options</h1>

<!--Field: Page Title-->
<p>
<?php echo form_label('Page Title:'); ?><br />
<?php
$data = array(
              'name'        => 'page_title',
              'value'       => set_value('page_title')
            );
?>
<?php echo form_input($data); ?>
</p>

<!--Field: Page Keywords-->
<p>
<?php echo form_label('Meta Keywords:'); ?><br />
<?php
$data = array(
              'name'        => 'page_keywords',
              'value'       => set_value('page_keywords')
            );
?>
<?php echo form_input($data); ?>
</p>

<!--Field: Page Description-->
<p>
<?php echo form_label('Page Description:'); ?><br />
<?php
$data = array(
              'name'        => 'page_description',
              'id'          => 'page_description',
              'value'       =>  set_value('page_description'),
              'maxlength'   => '500',
              'style'       => 'width:100%;height:70px',
        );
?>
<?php echo form_textarea($data); ?>
</p>

<!--Menu Options-->
<h1>Menu Options</h1>

<!--Field: Menu-->
<p>
<?php echo form_label('Add Page To Menu:'); ?><br />
<select name="page_menu">
    <option value="0">No Menu</option>
    <?php foreach($menu_select as $menu) : ?>
        <option value="<?php echo $menu->id; ?>" <?php echo set_select('page_menu',$menu->id); ?>><?php echo $menu->name; ?></option>
    <?php endforeach; ?>
</select><a href="" class="someClass" title="Choose a menu to link the page to"><img style="margin:0 0 -5px 7px" class="tipimage" 
             src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>

<!--Field: Parent Item-->
<p>
<?php echo form_label('Parent Item:'); ?><br />
<select name="parent_item">
    <option value="0">No Parent</option>
    <?php foreach($menu_items as $item) : ?>
        <option value="<?php echo $item->item_id; ?>" <?php echo set_select('parent_item',$item->item_id); ?>><?php echo $item->anchor; ?></option>
    <?php endforeach; ?>
</select><a href="" class="someClass" title="Choose a parent menu item"><img style="margin:0 0 -4px 8px" class="tipimage" 
             src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>

<!--Field: Menu Item Title-->
<p>
<?php echo form_label('Menu Item Title:'); ?><br />
<?php
$data = array(
              'name'        => 'anchor',
              'value'       => set_value('anchor')
            );
?>
    <?php echo form_input($data); ?>
</p>

<!--Field: Order-->
<p>
<?php echo form_label('Order:'); ?><br />
<?php
$data = array(
              'name'        => 'order',
              'value'       => set_value('order'),
              'style'       => 'text-align:center;width:30px;'
            );
?>
<?php echo form_input($data); ?>
    <a href="" class="someClass"  title="Choose the order position for this page. Current order is listed below"><img class="tipimage" style="margin:0 0 -4px 4px;" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>

<!--Current Order-->
<p>
<?php echo form_label('Current Page Order:'); ?><br />
<table style="margin-top:0;" width="200">
<?php foreach($top_items as $item) : ?>
<tr>
    <td><?php echo $item->anchor; ?></td>
     <td><?php echo $item->order; ?></td>
     <?php foreach($child_items as $child) : ?>
     <?php if($item->item_id == $child->parent_id) : ?>
     <tr>
     <td>---<?php echo $child->anchor; ?></td>
     <td><?php echo $child->order; ?></td>
     </tr>
     <?php endif; ?>
     <?php endforeach; ?>
</tr>
    <?php endforeach; ?>
</table>
</p>

</div><!--sidebar end-->
<div class="clr"></div>

<!--Submit Buttons-->
<?php
$data = array(
              'name'        => 'submit',
              'id'          => 'page_submit',
              'value'       =>  'Add Page'
        );
?>
<br />
<p>
    <?php echo form_submit($data); ?> or <a href="<?php echo base_url(); ?>admin/pages">Cancel</a>
</p>

