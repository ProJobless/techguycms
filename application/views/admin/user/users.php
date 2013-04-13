<!--Display Messages-->
<?php if($this->session->flashdata('user_added')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('user_added') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('user_deleted')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('user_deleted') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('user_activated')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('user_activated') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('user_deactivated')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('user_deactivated') . '</p>'; ?>
<?php endif; ?>
<!--Start Page-->
<div id="content">
<h1>Website Users</h1>
<div id="content_list">
<!--Start Form-->
<?php $attributes = array('class' => 'user_form', 'onsubmit' => '
    if(checkDelete){
        if(!confirm(\'Are you sure you want to delete this user?\')){
            return false;
        }
    }
    '); ?>
<?php echo form_open('admin/user/action_direct_user',$attributes); ?>
    <div id="submit_buttons">
        <input type="submit" name="add" id="add" value="New" />
        <input type="submit" name="edit" id="edit" value="Edit" />
        <input type="submit" name="activate" id="activate" value="Activate" />
        <input type="submit" name="deactivate" id="deactivate" value="Deactivate" />
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
                Full Name
            </th>
             <th width="80">
                Username
            </th>
             <th>
               Email
            </th>
             <th width="110">
               Role
            </th>
             <th>
                Activated
            </th>
            
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user) : ?>
        <tr>
            <td>
                <input type="checkbox" name="user_id[]" id="check_list[]" value="<?php echo $user->id; ?>" />
            </td>
            <td>
                <?php echo $user->id; ?>
            </td>
             <td>
               <a href="<?php base_url(); ?>user/edit/<?php echo $user->id;?>"> <?php echo $user->first_name . ' ' . $user->last_name; ?></a>
            </td>
             <td>
                <?php echo $user->username; ?>
            </td>
             <td>
                <?php echo $user->email; ?>
            </td>
             <td>
               <?php
                foreach($roles as $role){
                    if($user->role == $role->id){
                        echo $role->name;      
                    }
                }
               ?>
            </td>
             <td>
                  <?php if($user->is_activated == 1) : ?>
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
 <?php if(empty($users)) : ?>
            No users to display
        <?php endif; ?>
</div><!--content-->

<div id="sidebar">
   <?php $this->load->view('admin/includes/stats'); ?>
</div>

