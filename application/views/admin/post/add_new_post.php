<!--Display form validation errors-->
<?php echo validation_errors('<p class="error">'); ?>
<!--Display Message-->
 <?php if($this->session->flashdata('images_folder')) : ?> 
<?php echo '<p class="error">' .$this->session->flashdata('images_folder') . '</p>'; ?>
<?php endif; ?>
<!--Display Message-->
<?php if($this->session->flashdata('images_blog_folder')) : ?>
<?php echo '<p class="error">' .$this->session->flashdata('images_blog_folder') . '</p>'; ?>
<?php endif; ?>
<!--Start Page-->
<div id="content">
<h1>Add A New Blog Post</h1>
<?php //If the page_routes file is not writeable       
       if(!is_writeable(base_url().'application/cache/post_routes.php')){
            $perm_message = '<p class="error">You need to apply chmod 777 to the file below in order for your blog to work correctly<br />
                <strong>application/cache/post_routes.php</strong></p>';
        } 
        ?>
<!--Start Form-->
<?php $attributes = array('id' => 'add_page_form'); ?>
<?php echo form_open_multipart('admin/post/add',$attributes); ?>


<!--Field: Post Name-->
<p>
<?php echo form_label('Post Title:'); ?><br />
<?php echo form_input('post_title',set_value('post_title')); ?>
</p>

<!--Field: Post Body-->
<p>
<?php echo form_label('Post Body:'); ?><br />
<?php
$data = array(
              'name'        => 'post_body',
              'id'          => 'post_body',
              'value'       => set_value('post_body'),
              'maxlength'   => '500',
              'style'       => 'width:90%',
            );
?>
<script type="text/javascript">
	window.onload = function()
	{
		CKEDITOR.replace( 'post_body' );
	};
</script>
<?php echo form_textarea($data); ?>
</p>

<!--Field: Category-->
<p>
<?php echo form_label('Choose Category:'); ?><br />
<select name="category">
    <option value="0">Uncategorized</option>
    <?php foreach($categories as $category) : ?>
        <option value="<?php echo $category->id; ?>" <?php echo set_select('category',$category->id); ?>><?php echo $category->name; ?></option>
    <?php endforeach; ?>
</select><span class="info-padding">Choose a category for your post</span>
</p>

<!--Field: Authors-->
<p>
<?php echo form_label('Choose Author:'); ?><br />
<select name="author">
    <option value="none">Select Author</option>
    <?php foreach($authors as $author) : ?>
        <option 
            <?php if($author_id == $author->id) : ?>
            selected="selected"
            <?php endif; ?>
            value="<?php echo $author->id; ?>"><?php echo $author->first_name . ' ' . $author->last_name; ?></option>
    <?php endforeach; ?>
</select><span class="info-padding">Choose an author for your post</span>
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
<option value="<?php echo $module->id; ?>" <?php echo set_select('page_modules',$module->id); ?>><?php echo $module->name; ?></option>
<?php endforeach; ?>
</select><a href="" class="someClass" style="margin:0 0 0 5px;" title="Choose which modules will show on this page"><img class="tipimage" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>

</p>

<br />
<!--Field: Published-->
<p>
<?php echo form_label('Published:'); ?><br />
Yes <?php echo form_radio('published', '1', TRUE); ?>
No  <?php echo form_radio('published', '0', FALSE); ?>
</p>

</div>

<!--Sidebar-->
<div id="sidebar">
   
<!--Field: Main Image-->
<p>
<h1>Media</h1>
Upload Main Image
<input type="file" name="userfile" size="20" />
<br /><br />
<span class="info">This image will show in the main blog roll, not in the post itself</span>
</p>

<h1>SEO Options</h1>

<!--Field: Page Title-->
<p>
<?php echo form_label('Page Title:'); ?><br />
<?php echo form_input('page_title',set_value('page_title')); ?>
</p>

<!--Field: Page Keywords-->
<p>
<?php echo form_label('Page Keywords:'); ?><br />
<?php echo form_input('tags',set_value('tags')); ?>
</p>

<!--Field: Page Description-->
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

</div><!--sidebar div end-->
<div class="clr"></div>

<!--Submit Buttons-->
<?php
$data = array(
              'name'        => 'submit',
              'id'          => 'post_submit',
              'value'       =>  'Add Post'
        );
?>
<br />
<p>
    <?php echo form_submit($data); ?> or <a href="<?php echo base_url(); ?>admin/posts">Cancel</a>
</p>

