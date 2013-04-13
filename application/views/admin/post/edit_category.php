<!--Display form validation errors-->
<?php echo validation_errors('<p class="error">'); ?>
<!--Display Message-->
<?php if($this->session->flashdata('category_edited')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('category_edited') . '</p>'; ?>
<a href="<?php echo base_url(); ?>admin/post/categories">Back to categories</a>
<?php endif; ?>
<!--Page Start-->
<div id="content">
<h1>Edit Category</h1>

<?php $attributes = array('id' => 'add_category_form'); ?>
<?php echo form_open_multipart('admin/post/edit_category/' .$this_category->id . '',$attributes); ?>


<!--Field: Category Name-->
<p>
<label for="category_name">Category Name:</label><br />
<?php echo form_input('category_name',$this_category->name); ?>
</p>
<!--description-->
<?php
$data = array(
              'name'        => 'category_description',
              'id'          => 'category_description',
              'value'       =>  $this_category->description,
              'maxlength'   => '500',
              'style'       => 'width:100%;height:70px',
        );
?>
<p>
<label for="category_description">Category Description</label><br />
<?php echo form_textarea($data); ?>
</p>

<!--Field: Published-->
<p>
    <label for="published">Published</label><br />
    <?php if($this_category->is_published == 1) : ?>
    Yes <?php echo form_radio('published', '1', TRUE); ?>
    No  <?php echo form_radio('published', '0', FALSE); ?>
    <?php else : ?>
     Yes <?php echo form_radio('published', '1', FALSE); ?>
     No  <?php echo form_radio('published', '0', TRUE); ?>
    <?php endif; ?>
</p>
</div>


<div class="clr"></div>
<?php
$data = array(
              'name'        => 'submit',
              'id'          => 'category_submit',
              'value'       => 'Edit Category'
        );
?>
<br />
<p>
    <?php echo form_submit($data); ?> or <a href="<?php echo base_url(); ?>admin/post/categories">Cancel</a>
</p>

