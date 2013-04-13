<!--Display Messages-->
<?php if($this->session->flashdata('form_routes_writable')) : ?> 
<?php echo '<p class="error">' .$this->session->flashdata('form_routes_writable') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('form_added')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('form_added') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('form_deleted')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('form_deleted') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('form_published')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('form_published') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('form_unpublished')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('form_unpublished') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('form_edited')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('form_edited') . '</p>'; ?>
<?php endif; ?>
<!--Start Page-->
<div id="content">
<h1>Website Forms</h1>
<div id="content_list">
<!--Start Form-->
<?php $attributes = array('class' => 'form_form', 'onsubmit' => '
    if(checkDelete){
        if(!confirm(\'Are you sure you want to delete this form?\')){
            return false;
        }
    }
    '); ?>
<?php echo form_open('admin/form/action_direct_form',$attributes); ?>
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
             <th width="200">
                Form Name
            </th>
             <th width="80">
                Type
            </th>           
             <th>
                Published
            </th>
             <th>
                Form Fields
            </th>
            
        </tr>
    </thead>
    <tbody>
        <?php foreach ($forms as $form) : ?>
        <tr>
            <td>
                <input type="checkbox" name="form_id[]" id="check_list[]" value="<?php echo $form->id; ?>" />
            </td>
            <td>
                <?php echo $form->id; ?>
            </td>
             <td>
               <a href="<?php base_url(); ?>form/edit/<?php echo $form->id;?>"> <?php echo ucwords($form->name); ?></a>
            </td>
             <td>
                <?php echo $form->type; ?>
            </td>
             <td>
                 <?php if($form->is_published == 1) : ?>
                     Yes
                <?php else : ?>
                     No
                <?php endif; ?>
                 
            </td>
             <td>
                 <a style="color:red;text-decoration: underline;" href="<?php echo base_url(); ?>admin/form/fields/<?php echo $form->id; ?>">Manage Form Fields</a>
                  
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php echo form_close(); ?>

 <?php if(empty($forms)) : ?>
            No Forms to display
        <?php endif; ?>
</div><!--content-->

<div id="sidebar">
   <?php $this->load->view('admin/includes/stats'); ?>
</div>
