<!--Display Errors-->
<?php echo validation_errors('<p class="error">'); ?>
<!--Start Page-->
<div id="close">
<div id="content">
<h1>Add A New Form</h1>
<!--Start Form-->
<?php $attributes = array('id' => 'add_form_form'); ?>
<?php echo form_open('admin/form/add',$attributes); ?>

<!--Field: Form Name-->
<p>
<?php echo form_label('Form Name:'); ?><br />
<?php
$data = array(
              'name'        => 'form_name',
              'value'       => set_value('form_name')
            );
?>
<?php echo form_input($data); ?>
<a href="" class="someClass" title="Name of form will show as menu item title"><img class="tipimage" style="margin:0 0 -4px 4px" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>


<!--Field: Email-->
<p>
<?php echo form_label('To Email::'); ?><br />
<?php
$data = array(
              'name'        => 'to_email',
              'value'       => set_value('to_email')
            );
?>
<?php echo form_input($data); ?>
<a href="" class="someClass" title="Email that submissions will be sent to"><img class="tipimage" style="margin:0 0 -4px 4px" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>


<!--Field: Subject-->
<p>
<?php echo form_label('Subject:'); ?><br />
<?php
$data = array(
              'name'        => 'subject',
              'value'       => set_value('subject')
            );
?>
<?php echo form_input($data); ?>
<a href="" class="someClass" title="Email submission subject"><img class="tipimage" style="margin:0 0 -4px 4px" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>


<!--Field: Form Modules-->
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
</select><a href="" class="someClass" title="Choose which modules will show on this page"><img class="tipimage" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>

</p>


<br />
<!--Field: Published-->
<p>
<?php echo form_label('Published:'); ?><br />
   Yes <?php echo form_radio(array("name"=>"published","id"=>"published_yes","value"=>"1", 'checked'=>set_radio('published', '1', TRUE))); ?>
   No  <?php echo form_radio(array("name"=>"published","id"=>"published_no","value"=>"0", 'checked'=>set_radio('published', '0', FALSE))); ?>
</p>

</div>

    
<div class="content-right">

<!--Field: Menu Options-->
<h1>Menu Options</h1>
<p>
<?php echo form_label('Add Form To Menu:'); ?><br />
<select name="page_menu">
    <option value="0">No Menu</option>
    <?php foreach($menu_select as $menu) : ?>
        <option value="<?php echo $menu->id; ?>" <?php echo set_select('page_menu',$menu->id); ?>><?php echo $menu->name; ?></option>
    <?php endforeach; ?>
</select>
<a href="" class="someClass" title="Choose a menu to link the form to"><img class="tipimage" style="margin:0 0 -4px 4px" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
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
<a href="" class="someClass" title="Choose a menu item title"><img class="tipimage" style="margin:0 0 -4px 4px" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
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
</div><!--content right-->

<div style="clear:both;"></div>
<!--Submit Button-->
<?php
$data = array(
              'name'        => 'submit',
              'id'          => 'form_submit',
              'value'       =>  'Add Form'
        );
?>
<br />
<p>
    <?php echo form_submit($data); ?> or <a href="<?php echo base_url(); ?>admin/forms">Cancel</a>
</p>

</div>
