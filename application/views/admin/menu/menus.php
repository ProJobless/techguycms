<!--Display Messages-->
<?php if($this->session->flashdata('menu_added')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('menu_added') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('menu_not_added')) : ?>
<?php echo '<p class="error">' .$this->session->flashdata('menu_not_added') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('menu_deleted')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('menu_deleted') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('menu_published')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('menu_published') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('menu_unpublished')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('menu_unpublished') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('menu_global')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('menu_global') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('menu_remove_global')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('menu_remove_global') . '</p>'; ?>
<?php endif; ?>

<!--Start Page-->
<div id="content">
<h1>Website Menus</h1>
<div id="content_list">
<!--Start Form-->
<?php $attributes = array('class' => 'menu_form', 'onsubmit' => '
    if(checkDelete){
        if(!confirm(\'Are you sure you want to delete this menu?\')){
            return false;
        }
    }
    '); ?>
<?php echo form_open('admin/menu/action_direct_menu',$attributes); ?>
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
             <th width="300">
                Menu Name
            </th>
             <th>
                Position
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
        <?php foreach ($menus as $menu) : ?>
        <tr>
            <td>
                <input type="checkbox" name="menu_id[]" id="check_list[]" value="<?php echo $menu->id; ?>" />
            </td>
            <td>
                <?php echo $menu->id; ?>
            </td>
             <td>
               <a href="<?php base_url(); ?>menu/edit_menu/<?php echo $menu->id;?>"> <?php echo $menu->name; ?></a>
            </td>
            <td>
                <?php echo $menu->module_position; ?>
            </td>     
             <td>
                <?php if($menu->registered_only == 1) : ?>
                     Registered
                <?php else : ?>
                     Everyone
                <?php endif; ?>
            </td>
             <td>
                  <?php if($menu->is_published == 1) : ?>
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

 <?php if(empty($menus)) : ?>
            No Menus to display
        <?php endif; ?>
</div><!--content-->

<div id="sidebar">
   <?php $this->load->view('admin/includes/stats'); ?>
</div>
