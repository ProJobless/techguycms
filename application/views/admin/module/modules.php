<!--Display Messages-->
<?php if($this->session->flashdata('mod_added')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('mod_added') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('mod_deleted')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('mod_deleted') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('mod_published')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('mod_published') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('mod_unpublished')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('mod_unpublished') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('mod_global')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('mod_global') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('mod_remove_global')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('mod_remove_global') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('mod_edited')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('mod_edited') . '</p>'; ?>
<?php endif; ?>
<!--Start Page-->
<div id="content">
<h1>Modules</h1>
<div id="content_list">
<!--Start Form-->
<?php $attributes = array('class' => 'module_form', 'onsubmit' => '
    if(checkDelete){
        if(!confirm(\'Are you sure you want to delete this module?\')){
            return false;
        }
    }
    '); ?>
<?php echo form_open('admin/module/action_direct_module',$attributes); ?>
    <div id="submit_buttons">
        <!--Submit Buttons-->
        <input type="submit" name="add" id="add" value="New" />
        <input type="submit" name="edit" id="edit" value="Edit" />
        <input type="submit" name="make_global" id="make_global" value="Make Global" />
        <input type="submit" name="remove_global" id="remove_global" value="Remove Global" />
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
                Module Name
            </th>
             <th width="80">
                Position
            </th>
             <th>
               Order
            </th>
             <th>
               Editable
            </th>
            <th>
               Global
            </th>
             <th>
               Published
            </th>
            
        </tr>
    </thead>
    <tbody>
        <?php foreach ($modules as $module) : ?>
        <tr>
            <td>
                <input type="checkbox" name="mod_id[]" id="check_list[]" value="<?php echo $module->id; ?>" />
            </td>
            <td>
                <?php echo $module->id; ?>
            </td>
             <td>
              
                    <a href="<?php base_url(); ?>module/edit/<?php echo $module->id;?>"> <?php echo $module->name; ?></a>
               
                 
            </td>
             <td>
                <?php echo $module->module_position; ?>
            </td>
             <td>
                <?php echo $module->order; ?>
            </td>
             <td>
                 <?php if($module->is_editable == 1) : ?>
                     Yes
                <?php else : ?>
                     No
                <?php endif; ?>
            </td>
            <td>
                 <?php if($module->is_global == 1) : ?>
                     Yes
                <?php else : ?>
                     No
                <?php endif; ?>
            </td>
             <td>
                 <?php if($module->is_published == 1) : ?>
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
 <?php if(empty($modules)) : ?>
            No modules to display
        <?php endif; ?>
</div><!--content-->

<div id="sidebar">
    <?php $this->load->view('admin/includes/stats'); ?>
</div>




