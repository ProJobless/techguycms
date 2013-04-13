<!--Display Messages-->
<?php if($this->session->flashdata('field_added')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('field_added') . '</p>'; ?>
<?php endif; ?>

<?php if($this->session->flashdata('field_deleted')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('field_deleted') . '</p>'; ?>
<?php endif; ?>

<?php if($this->session->flashdata('field_published')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('field_published') . '</p>'; ?>
<?php endif; ?>

<?php if($this->session->flashdata('field_unpublished')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('field_unpublished') . '</p>'; ?>
<?php endif; ?>

<?php if($this->session->flashdata('field_edited')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('field_edited') . '</p>'; ?>
<?php endif; ?>
<!--Start Page-->
<div id="content">
<h1><?php echo $form->name; ?> Form Fields</h1>
<div id="content_list">
<!--Start Form-->
<?php $attributes = array('class' => 'form_form', 'onsubmit' => '
    if(checkDelete){
        if(!confirm(\'Are you sure you want to delete this form?\')){
            return false;
        }
    }
    '); ?>
<?php echo form_open('admin/form/action_direct_fields/'.$form->id,$attributes); ?>
    <?php form_hidden('form_id',$form->id); ?>
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
           
             <th width="200">
                Field Label
            </th>
         
             <th width="80">
                Type
            </th>      
                <th>
                Published
            </th>
             <th>
                Order
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($fields as $field) : ?>
        <tr>
            <td>
                <input type="checkbox" name="field_id[]" id="check_list[]" value="<?php echo $field->id; ?>" />
            </td>
            <td>
                 <?php echo $field->id; ?>
            </td>
            <td>
                <a href="<?php echo base_url(); ?>admin/form/edit_field/<?php echo $form->id; ?>/<?php echo $field->id; ?>"><?php echo $field->label; ?></a>
            </td>
            
             <td>
               <?php echo $field->type; ?>
            </td>
             <td>
               <?php if($field->is_published == 1) : ?>
                     Yes
                <?php else : ?>
                     No
                <?php endif; ?>
            </td>
             <td>
  <?php echo $field->order; ?>            
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
