<!--Display Messages-->
<?php if($this->session->flashdata('post_routes_writable')) : ?> 
<?php echo '<p class="error">' .$this->session->flashdata('post_routes_writable') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('images_folder')) : ?> 
<?php echo '<p class="error">' .$this->session->flashdata('images_folder') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('images_blog_folder')) : ?> 
<?php echo '<p class="error">' .$this->session->flashdata('images_blog_folder') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('post_added')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('post_added') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('post_deleted')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('post_deleted') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('post_published')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('post_published') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('post_unpublished')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('post_unpublished') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('post_featured')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('post_featured') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('post_unfeatured')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('post_unfeatured') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('post_edited')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('post_edited') . '</p>'; ?>
<?php endif; ?>
<!--Start Page-->
<div id="content">
<h1>Website Blog Posts</h1>
<div id="content_list">
    <div id="create_cat"><a href="<?php echo base_url(); ?>admin/post/add_category">Create Category</a> | <a href="<?php echo base_url(); ?>admin/post/categories">View Categories</a>
         | <a href="<?php echo base_url(); ?>admin/post/comments">Comments</a></div>
<!--Start Form-->
<?php $attributes = array('class' => 'post_form', 'onsubmit' => '
    if(checkDelete){
        if(!confirm(\'Are you sure you want to delete this post?\')){
            return false;
        }
    }
    '); ?>
<?php echo form_open('admin/post/action_direct_post',$attributes); ?>
    <div id="submit_buttons">
        <!--Submit Buttons-->
        <input type="submit" name="add" id="add" value="New" />
        <input type="submit" name="edit" id="edit" value="Edit" />
        <input type="submit" name="publish" id="publish" value="Publish" />
        <input type="submit" name="unpublish" id="unpublish" value="Unpublish" />
        <input type="submit" name="delete" id="delete" value="Delete" onclick="checkDelete=true"/>
    </div>
<div class="clr"></div>
</div>
<table id="content_table">
    <thead>
        <tr>
             <th>
                #
            </th>
            <th>
                ID
            </th>
             <th width="170">
                Post Name
            </th>
             <th width="80">
                Created
            </th>
             <th>
               Category
            </th>
             <th width="110">
               Author
            </th>
             <th>
                Published
            </th>
            
        </tr>
    </thead>
    <tbody>
        <?php foreach ($posts as $post) : ?>
        <tr>
            <td>
                <input type="checkbox" name="post_id[]" id="check_list[]" value="<?php echo $post->id; ?>" />
            </td>
            <td>
                <?php echo $post->id; ?>
            </td>
             <td>
               <a href="<?php base_url(); ?>post/edit/<?php echo $post->id;?>"> <?php echo $post->title; ?></a>
            </td>
             <td>
                <?php echo date("n-j-Y",strtotime($post->create_date)); ?>
            </td>
             <td>
                 <?php if($post->cat_id != 0) : ?>
                <?php echo $post->name; ?>
                 <?php else : ?>
                 Uncategorized
                 <?php endif; ?>
            </td>
             <td>
                <?php echo $post->first_name . ' ' . $post->last_name; ?>
            </td>
             <td>
                  <?php if($post->is_published == 1) : ?>
                     Yes
                <?php else : ?>
                     No
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php echo form_close(); ?>
 <?php if(empty($posts)) : ?>
            No posts to display
        <?php endif; ?>
</div><!--content-->

<div id="sidebar">
  <?php $this->load->view('admin/includes/stats'); ?>
</div>

