<!--Display Messages-->
<?php if($this->session->flashdata('page_routes_writable')) : ?> 
<?php echo '<p class="error">' .$this->session->flashdata('page_routes_writable') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('page_added')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('page_added') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('page_deleted')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('page_deleted') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('page_published')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('page_published') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('page_unpublished')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('page_unpublished') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('page_featured')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('page_featured') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('page_unfeatured')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('page_unfeatured') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('page_edited')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('page_edited') . '</p>'; ?>
<?php endif; ?>
<!--Start Page-->
<div id="content">
<h1>Website Pages</h1>
<div id="content_list">
<!--Start Form-->
<?php $attributes = array('class' => 'page_form', 'onsubmit' => '
    if(checkDelete){
        if(!confirm(\'Are you sure you want to delete this page?\')){
            return false;
        }
    }
    '); ?>
<?php echo form_open('admin/page/action_direct_page',$attributes); ?>
    <div id="submit_buttons">
        <!--Submit Buttons-->
        <input type="submit" name="add" id="add" value="New" />
        <input type="submit" name="edit" id="edit" value="Edit" />
        <input type="submit" name="feature" id="feature" value="Feature" />
        <input type="submit" name="unfeature" id="unfeature" value="Unfeature" />
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
             <th width="200">
                Page Name
            </th>
             <th width="80">
                Created
            </th>
             <th>
               Featured
            </th>
            
            <th>
                Access
            </th>
             <th>
                Published
            </th>
            
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pages as $page) : ?>
        <tr>
            <td>
                <input type="checkbox" name="page_id[]" id="check_list[]" value="<?php echo $page->id; ?>" />
            </td>
            <td>
                <?php echo $page->id; ?>
            </td>
             <td>
               <a href="<?php base_url(); ?>page/edit/<?php echo $page->id;?>"> <?php echo $page->name; ?></a>
            </td>
             <td>
                <?php echo date("n-j-Y",strtotime($page->create_date)); ?>
            </td>
             <td>
                <?php if($page->is_featured == 1) : ?>
                     Yes
                <?php else : ?>
                     No
                <?php endif; ?>
            </td>
             <td>
                <?php if($page->registered_only == 1) : ?>
                     Registered
                <?php else : ?>
                     Everyone
                <?php endif; ?>
            </td>
             <td>
                  <?php if($page->is_published == 1) : ?>
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

 <?php if(empty($pages)) : ?>
            No Pages to display
        <?php endif; ?>
</div><!--content-->

<div id="sidebar">
   <?php $this->load->view('admin/includes/stats'); ?>
</div>
