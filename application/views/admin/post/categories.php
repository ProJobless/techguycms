<!--Display Messages-->
<?php if($this->session->flashdata('category_added')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('category_added') . '</p>'; ?>
<br />
<?php endif; ?>
<?php if($this->session->flashdata('category_deleted')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('category_deleted') . '</p>'; ?>
<br />
<?php endif; ?>
<?php if($this->session->flashdata('category_published')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('category_published') . '</p>'; ?>
<br />
<?php endif; ?>
<?php if($this->session->flashdata('category_unpublished')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('category_unpublished') . '</p>'; ?>
<br />
<?php endif; ?>
<!--Start Page-->
<div id="content">
<h1>Website Blog Categories</h1>
<div id="content_list">
<!--Start Form-->
<?php $attributes = array('class' => 'category_form', 'onsubmit' => '
    if(checkDelete){
        if(!confirm(\'Are you sure you want to delete this category?\')){
            return false;
        }
    }
    '); ?>
<?php echo form_open('admin/post/action_direct_category',$attributes); ?>
    <div id="submit_buttons">
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
                Category Name
            </th>
             <th width="80">
                Published
            </th>
         
            
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $category) : ?>
        <tr>
            <td>
                <input type="checkbox" name="category_id[]" id="check_list[]" value="<?php echo $category->id; ?>" />
            </td>
            <td>
                <?php echo $category->id; ?>
            </td>
             <td>
               <a href="<?php echo base_url(); ?>admin/post/edit_category/<?php echo $category->id; ?>"> <?php echo $category->name; ?></a>
            </td>
      
             <td>
                  <?php if($category->is_published == 1) : ?>
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
 <?php if(empty($categories)) : ?>
            No categories to display
        <?php endif; ?>
            <a href="<?php echo base_url(); ?>admin/posts">Back to Posts</a>
</div><!--content-->

<div id="sidebar">
   <?php $this->load->view('admin/includes/stats'); ?>
</div>


