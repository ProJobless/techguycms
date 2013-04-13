<!--Display form validation errors-->
<?php echo validation_errors('<p class="error">'); ?>
<!--Display Message-->
<?php if($this->session->flashdata('form_saved')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('form_saved') . '</p>'; ?>
<a style="padding-bottom:10px" href="<?php echo base_url(); ?>admin/forms">Back to Forms</a>
<?php endif; ?>
<?php echo validation_errors('<p class="error">'); ?>
<!--Start Page-->
<div id="close">
<div id="content">
<h1>Edit Form: <?php echo $this_form->name; ?></h1>
<!--Start Form-->
<?php $attributes = array('id' => 'edit_form_form'); ?>
<?php echo form_open('admin/form/edit/' .$this_form->id . '',$attributes); ?>

<!--Field: Form Name-->
<p>
<?php echo form_label('Form Name:'); ?><br />
<?php
$data = array(
              'name'        => 'form_name',
              'value'       => $this_form->name
            );
?>
<?php echo form_input($data); ?>
<a href="" class="someClass" title="Name of form will show as menu item title"><img class="tipimage" style="margin:0 0 -4px 4px" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>


<!--Field: Email-->
<p>
<?php echo form_label('To Email:'); ?><br />
<?php
$data = array(
              'name'        => 'to_email',
              'value'       => $this_form->to_email
            );
?>
<?php echo form_input($data); ?>
<a href="" class="someClass" title="Email that submissions will be sent to"><img class="tipimage" style="margin:0 0 -4px 4px" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>


<!--Field: Subject-->
<p>
<?php echo form_label('Subject Line of Emali:'); ?><br />
<?php
$data = array(
              'name'        => 'subject',
              'value'       => $this_form->subject
            );
?>
<?php echo form_input($data); ?>
<a href="" class="someClass" title="Email submission subject"><img class="tipimage" style="margin:0 0 -4px 4px" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>


<!--Field: Form Modules-->
<p>
<?php echo form_label('Page Modules');?><br />
<select name ="page_modules[]" multiple="multiple">
<!--If front login is disabled, dont show login module as a choice-->
<?php if($mod_select[0]->id == 1 && $activate_frontend_login->value == 0) : ?>
<!--Remove login module from the array-->
    <?php unset($mod_select[0]); ?>)
<?php endif; ?>
<?php foreach($mod_select as $module) : ?>
<option value="<?php echo $module->id; ?>" 
    <?php
        if(in_array($module->id,$selected_modules)){
            echo 'selected';
        }
    ?>
><?php echo $module->name; ?></option>
<?php endforeach; ?>
</select><a href="" class="someClass" title="Choose which modules will show on this page"><img class="tipimage" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>


<br />
<!--Field: Published-->
<p>
<?php echo form_label('Published');?><br />
    <?php if($this_form->is_published == 1) : ?>
    Yes <?php echo form_radio('published', '1', TRUE); ?>
    No  <?php echo form_radio('published', '0', FALSE); ?>
    <?php else : ?>
     Yes <?php echo form_radio('published', '1', FALSE); ?>
     No  <?php echo form_radio('published', '0', TRUE); ?>
    <?php endif; ?>
</p>
</div>
    
<div class="content-right">

<!--Field: Menu Options-->
<h1>Menu Options</h1>
<p>
<?php echo form_label('Add Form To Menu');?><br />
<select name="page_menu">
    <option value="0">No Menu</option>
    <?php foreach($menu_select as $menu) : ?>
        <option value="<?php echo $menu->id; ?>"
                <?php
                if(isset($selected_menu->menu_id) && $selected_menu->menu_id == $menu->id){
                    echo 'selected';
                } else {
                    echo "";
                }
                ?>
                ><?php echo $menu->name; ?></option>
    <?php endforeach; ?>
</select><a href="" class="someClass" title="Choose a menu to link the page to"><img style="margin:0 0 -4px 7px" class="tipimage" 
             src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>


<!--Field: Parent Item-->
<p>
<?php echo form_label('Parent Item:'); ?><br />
<select name="parent_item">
    <option value="0">No Parent</option>
    <?php foreach($menu_items as $item) : ?>
        <option value="<?php echo $item->item_id; ?>" 
                 <?php
                if(isset($selected_parent->parent_id) && $selected_parent->parent_id == $item->item_id){
                    echo 'selected';
                } else {
                    echo "";
                }
                ?>
       ><?php echo $item->anchor; ?></option>
    <?php endforeach; ?>
</select><a href="" class="someClass" title="Choose a parent menu item"><img style="margin:0 0 -4px 8px" class="tipimage" 
             src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>


<!--Field: Menu Item Title-->
<p>
<?php echo form_label('Menu Item Title');?><br />
    <?php if(isset($selected_menu->anchor)) : ?>
        <?php echo form_input('anchor',$selected_menu->anchor); ?>
    <?php else : ?>
        <?php echo form_input('anchor',set_value('anchor')); ?>
    <?php endif; ?>
</p>


<!--Field: Order-->
<p>
<?php echo form_label('Order');?><br />
<?php
$data = array(
              'name'        => 'order',
              'value'       => $this_item->order,
              'style'       => 'text-align:center;width:30px;'
            );
?>
<?php echo form_input($data); ?>
<a href="" class="someClass"  title="Choose the order position for this form/page. Current order is listed below"><img class="tipimage" style="margin:0 0 -4px 4px;" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>


<!--Current Order-->
<p>
<?php echo form_label('Current Page Order:'); ?><br />
<table style="margin-top:0;" width="200">
<?php foreach($top_items as $item) : ?>
<tr>
    <td><?php if($this_item->item_id == $item->item_id){echo '<strong>';} ?><?php echo $item->anchor; ?><?php if($this_item->item_id == $item->item_id){echo '</strong>';} ?></td>
     <td><?php if($this_item->item_id == $item->item_id){echo '<strong>';} ?><?php echo $item->order; ?><?php if($this_item->item_id == $item->item_id){echo '</strong>';} ?></td>
     <?php foreach($child_items as $child) : ?>
     <?php if($item->item_id == $child->parent_id) : ?>
     <tr>
     <td><?php if($this_item->item_id == $child->item_id){echo '<strong>';} ?>---<?php echo $child->anchor; ?><?php if($this_item->item_id == $child->item_id){echo '</strong>';} ?></td>
     <td><?php if($this_item->item_id == $child->item_id){echo '<strong>';} ?><?php echo $child->order; ?><?php if($this_item->item_id == $child->item_id){echo '</strong>';} ?></td>
     </tr>
     <?php endif; ?>
     <?php endforeach; ?>
</tr>
    <?php endforeach; ?>
</table>
</p>

</div><!--content right-->

<div style="clear:both;"></div>

<!--Submit Buttons-->
<?php
$data = array(
              'name'        => 'submit',
              'id'          => 'form_submit',
              'value'       =>  'Save Form'
        );
?>
<br />
<p>
    <?php echo form_submit($data); ?> or <a href="<?php echo base_url(); ?>admin/forms">Cancel</a>
</p>

</div>
