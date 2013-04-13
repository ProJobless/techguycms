<!--Display form validation errors-->
<?php echo validation_errors('<p class="error">'); ?>
<!--Display Message-->
<?php if($this->session->flashdata('post_edited')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('post_edited') . '</p>'; ?>
<a style="padding-bottom:10px" href="<?php echo base_url(); ?>admin/posts">Back to blog posts</a>
<?php endif; ?>
<!--Display Message-->
<?php if($this->session->flashdata('post_routes_writable')) : ?> 
<?php echo '<p class="error">' .$this->session->flashdata('post_routes_writable') . '</p>'; ?>
<?php endif; ?>
<!--Display Message-->
<?php if($this->session->flashdata('images_folder')) : ?> 
<?php echo '<p class="error">' .$this->session->flashdata('images_folder') . '</p>'; ?>
<?php endif; ?>
<!--Display Message-->
<?php if($this->session->flashdata('images_blog_folder')) : ?>
<?php echo '<p class="error">' .$this->session->flashdata('images_blog_folder') . '</p>'; ?>
<?php endif; ?>
    
<!--Page Start-->
<div id="content">
<h1>Edit Post</h1>
<!--Start Form-->
<?php $attributes = array('id' => 'edit_post_form'); ?>
<?php echo form_open_multipart('admin/post/edit/' .$this_post->id . '',$attributes); ?>

<!--Field: Post Name-->
<p>
<label for="post_name">Post Title:</label><br />
<?php echo form_input('post_title',$this_post->title); ?>
</p>

<!--Field: Post Body-->
<?php
$data = array(
              'name'        => 'post_body',
              'id'          => 'post_body',
              'value'       => $this_post->body,
              'maxlength'   => '500',
              'style'       => 'width:90%',
            );
?>
<p>
<script type="text/javascript">
	window.onload = function()
	{
		CKEDITOR.replace( 'post_body' );
	};
</script>
<label for="paqe_body">Post Body:</label><br />
<?php echo form_textarea($data); ?>
</p>


<!--Field: Category-->
<p>
<label for="category">Choose Category:</label><br />
<select name="category">
    <option value="0">Uncategorized</option>
    <?php foreach($categories as $category) : ?>
        <option 
            <?php if(isset($post_category->id)) : ?>
                <?php if($category->id == $post_category->id) : ?>
                selected="selected"
                <?php endif; ?>
            <?php endif; ?>
            value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
    <?php endforeach; ?>
</select><span class="info-padding">Choose a category for your post</span>
</p>

<!--Field: Authors-->
<p>
<label for="author">Choose Author:</label><br />
<select name="author">
    <option value="0" 
            <?php if(isset($post_author->id) && $post_author->id == 0) : ?>
            selected
            <?php endif; ?>
            >Select Author</option>
    <?php foreach($authors as $author) : ?>
        <option 
            <?php if(isset($post_author->id) && $author->id == $post_author->id) : ?>
            selected="selected"
            <?php endif; ?>
            value="<?php echo $author->id; ?>"><?php echo $author->first_name . ' ' . $author->last_name; ?></option>
    <?php endforeach; ?>
</select><span class="info-padding">Choose an author for your post</span>
</p>

<!--Field: Page Modules-->
<p>
<label for="page_modules">Page Modules:</label><br />
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
</select><a href="" class="someClass" style="margin:0 0 0 5px;" title="Choose which modules will show on this page"><img class="tipimage" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>

<br />

<!--Field: Published-->
<p>
    <label for="published">Published</label><br />
    <?php if($this_post->is_published == 1) : ?>
    Yes <?php echo form_radio('published', '1', TRUE); ?>
    No  <?php echo form_radio('published', '0', FALSE); ?>
    <?php else : ?>
     Yes <?php echo form_radio('published', '1', FALSE); ?>
     No  <?php echo form_radio('published', '0', TRUE); ?>
    <?php endif; ?>
</p>

</div>

<!--Sidebar Start-->
<div id="sidebar">
    
<!--Field: Main Image-->
<p>
<h1>Media</h1>
Upload Main Image:
<input type="file" name="userfile" size="20"  />
<?php if($this_post->main_image != "") : ?>
<p>
Current Image Name: <strong><?php echo $this_post->main_image; ?></strong>
</p>
<img width="80" src="<?php echo base_url(); ?>assets/images/blog/<?php echo $this_post->main_image; ?>" />
<br />
Delete Current Image <?php echo form_checkbox('delete_image', '1', false); ?>
<br />
</p>
<?php endif; ?>
<br /><br /><span class="info">This image will show in the main blog roll, not in the post itself</span><p></p>
<h1>SEO Options</h1>

<!--Field: Page Title-->
<p>
<label for="page_title">Page Title:</label><br />
<?php echo form_input('page_title',$this_post->page_title); ?>
</p>

<!--Field: Meta Keywords-->
<p>
<label for="page_keywords">Tags/Keywords</label><br />
<?php echo form_input('tags',$this_post->tags); ?>
</p>

<!--Field: Meta Description-->
<?php
$data = array(
              'name'        => 'page_description',
              'id'          => 'page_description',
              'value'       =>  $this_post->meta_description,
              'maxlength'   => '500',
              'style'       => 'width:100%;height:70px',
        );
?>
<p>
<label for="page_description'>Meta Description</label><br />
<?php echo form_textarea($data); ?>
</p>

</div><!--sidebar div end-->
<div class="clr"></div>
<?php
$data = array(
              'name'        => 'submit',
              'id'          => 'post_submit',
              'value'       =>  'Save Post'
        );
?>
<br />
<p>
    <?php echo form_submit($data); ?> or <a href="<?php echo base_url(); ?>admin/posts">Cancel</a>
</p>




