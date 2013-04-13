<!--Display form validation errors-->
<?php echo validation_errors('<p class="error">'); ?>
<!--Display Message-->
<?php if($this->session->flashdata('page_edited')) : ?>
    <?php echo '<p class="message">' .$this->session->flashdata('page_edited') . '</p>'; ?>
    <a style="padding-bottom:10px" href="<?php echo base_url(); ?>admin/pages">Back to Pages</a>
    <p></p>
<?php endif; ?>
<!--Display Message-->
<?php if($this->session->flashdata('page_routes_writable')) : ?> 
    <?php echo '<p class="error">' .$this->session->flashdata('page_routes_writable') . '</p>'; ?>
<?php endif; ?>

<!--Start Page-->
<div id="content">
<h1>Edit Page</h1>
<!--Start Form-->
<?php $attributes = array('id' => 'add_page_form'); ?>
<?php echo form_open('admin/page/edit/' .$this_page->id . '',$attributes); ?>

<!--Field: Page Name-->
<p>
<?php echo form_label('Page Name:'); ?><br />
<?php
$data = array(
              'name'        => 'page_name',
              'value'       =>  $this_page->name
        );
?>
<?php echo form_input($data); ?>
</p>

<!--Field: Page Body (Form Helper)-->
<p>
<script type="text/javascript">
	window.onload = function()
	{
		CKEDITOR.replace( 'page_body' );
	};
</script>
<?php echo form_label('Page Body:'); ?><br />
<?php
$data = array(
              'name'        => 'page_body',
              'id'          => 'page_body',
              'value'       => $this_page->body,
              'maxlength'   => '500',
              'style'       => 'width:90%',
            );
?>
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

<!--Field: Featured-->
<p>
    <?php echo form_label('Featured:'); ?><br />
    <?php if($this_page->is_featured == 1) : ?>
    Yes <?php echo form_radio('featured', '1', TRUE); ?>
    No  <?php echo form_radio('featured', '0', FALSE); ?><a href="" class="someClass" title="If 'featured', it will show on the homepage"><img class="tipimage" style="margin:0 0 -3px 5px"src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
     <?php else : ?>
     Yes <?php echo form_radio('featured', '1', FALSE); ?>
    No  <?php echo form_radio('featured', '0', TRUE); ?><a href="" class="someClass" title="If 'featured', it will show on the homepage"><img class="tipimage" style="margin:0 0 -3px 5px"src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
    <?php endif; ?>
</p>

<br />

<!--Field: Page Access-->
<p>
    <?php echo form_label('Page Access:'); ?><br />
    <?php if($this_page->registered_only == 1) : ?>
    Everyone <?php echo form_radio('page_access', '0', FALSE); ?><span class="info-padding">Everyone can see this page and menu item</span><br />
    Registered Users Only <?php echo form_radio('page_access', '1', TRUE); ?><span class="info-padding">Only logged in users can see this page and menu item</span><br />
   
     <?php else : ?>
    Everyone <?php echo form_radio('page_access', '0', TRUE); ?><span class="info-padding">Everyone can see this page and menu item</span><br />
     Registered Users Only <?php echo form_radio('page_access', '1', FALSE); ?><span class="info-padding">Only logged in users can see this page and menu item</span><br />
    <?php endif; ?>
</p>

<br />

<!--Field: Published-->
<p>
    <?php echo form_label('Published:'); ?><br />
    <?php if($this_page->is_published == 1) : ?>
    Yes <?php echo form_radio('published', '1', TRUE); ?>
    No  <?php echo form_radio('published', '0', FALSE); ?>
    <?php else : ?>
     Yes <?php echo form_radio('published', '1', FALSE); ?>
     No  <?php echo form_radio('published', '0', TRUE); ?>
    <?php endif; ?>
</p>

</div>

<!--Sidebar-->
<div id="sidebar">
    
<h1>SEO Options</h1>

<!--Field: Page Title-->
<p>
<?php echo form_label('Page Title:'); ?><br />
<?php
$data = array(
              'name'        => 'page_title',
              'value'       =>  $this_page->page_title
        );
?>
<?php echo form_input($data); ?>
</p>

<!--Field: Meta Keywords-->
<p>
<?php echo form_label('Meta Keywords:'); ?><br />
<?php
$data = array(
              'name'        => 'page_keywords',
              'value'       =>  $this_page->meta_keywords
        );
?>
<?php echo form_input($data); ?>
</p>

<!--Field: Meta Description-->
<p>
<?php echo form_label('Meta Description:'); ?><br />
<?php
$data = array(
              'name'        => 'page_description',
              'id'          => 'page_description',
              'value'       =>  $this_page->meta_description,
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


<!--Field: Menu Item Anchor -->
<p>
<?php echo form_label('Menu Item Title:'); ?><br />
<?php
$data = array(
              'name'        => 'anchor',
              'value'       =>  @$selected_menu->anchor
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
              'value'       =>  @$this_item->order,
              'style'       =>  'text-align:center;width:30px;'
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

</div><!--sidebar-->
<div class="clr"></div>
<?php
$data = array(
              'name'        => 'submit',
              'id'          => 'page_submit',
              'value'       =>  'Save Page'
        );
?>
<br />
<p>
    <?php echo form_submit($data); ?> or <a href="<?php echo base_url(); ?>admin/pages">Cancel</a>
</p>


