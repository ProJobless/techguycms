<!--Display form validation errors-->
<?php echo validation_errors('<p class="error">'); ?>

<!--Page Start-->
<div id="content">
<h1>Add A New Category</h1>
<!--Start Form-->
<?php $attributes = array('id' => 'add_category_form'); ?>
<?php echo form_open_multipart('admin/post/add_category',$attributes); ?>


<!--Field: Category Name-->
<p>
<?php echo form_label('Category Name:');?><br />
<?php
$data = array(
              'name'        => 'category_name',
              'value'       => set_value('category_name')
            );
?>
<?php echo form_input($data); ?>
</p>

<!--Field: Category Description-->
<p>
<?php echo form_label('Category Description:');?><br />
<?php
$data = array(
              'name'        => 'category_description',
              'id'          => 'category_description',
              'value'       =>  set_value('category_description'),
              'maxlength'   => '500',
              'style'       => 'width:100%;height:70px',
        );
?>
<?php echo form_textarea($data); ?>
</p>

<!--Field: Published-->
<p>
<?php echo form_label('Published:');?><br />
    Yes <?php echo form_radio('published', '1', TRUE); ?>
    No  <?php echo form_radio('published', '0', FALSE); ?>
</p>

</div>

<div class="clr"></div>

<!--Submit Button-->
<?php
$data = array(
              'name'        => 'submit',
              'id'          => 'category_submit',
              'value'       =>  'Add Category'
        );
?>
<br />
<p>
    <?php echo form_submit($data); ?> or <a href="<?php echo base_url(); ?>admin/post/categories">Cancel</a>
</p>

