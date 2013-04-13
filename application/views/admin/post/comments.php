<!--Display Messages-->
<?php if($this->session->flashdata('comment_deleted')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('comment_deleted') . '</p>'; ?>
<br />
<?php endif; ?>
<?php if($this->session->flashdata('comment_approved')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('comment_approved') . '</p>'; ?>
<br />
<?php endif; ?>
<?php if($this->session->flashdata('comment_uapproved')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('comment_unapproved') . '</p>'; ?>
<br />
<?php endif; ?>
<!--Start Pages-->
<div id="content">
<h1>Blog Comments</h1>

<div id="content_list">
<!--Start Form-->
<?php $attributes = array('class' => 'comment_form', 'onsubmit' => '
    if(checkDelete){
        if(!confirm(\'Are you sure you want to delete this comment?\')){
            return false;
        }
    }
    '); ?>
<?php echo form_open('admin/post/action_direct_comment',$attributes); ?>
    <div id="submit_buttons">
        <input type="submit" name="approve" id="approve" value="Approve" />
        <input type="submit" name="unapprove" id="approve" value="Unapprove" />
        <input type="submit" name="delete" id="delete" value="Delete" onclick="checkDelete=true"/>
    </div><!--submit buttons-->
<div class="clr"></div>
</div>
 <br />
<?php foreach ($comments as $comment) : ?>
 <div class="comment_roll">
<h3 class="comment_title">
    <input type="checkbox" name="comment_id[]" id="check_list[]" value="<?php echo $comment->id; ?>" />
    &nbsp; <?php echo $comment->title; ?></h3>
<p><?php echo $comment->body; ?></p>
<div class="comment_info">
Post: <strong><?php echo get_post_name($comment->post_id); ?></strong>
<br />
Approved: <?php if($comment->is_approved == 0) : ?>
<strong>No</strong>
<?php else : ?>
<strong>Yes</strong>
<?php endif; ?>
<br />
</div><!--comment info-->
 </div><!--comment roll-->
<?php endforeach; ?>
 </div><!--comment roll-->
<?php echo form_close(); ?>
 <?php if(empty($comments)) : ?>
            No comments to display
        <?php endif; ?>


<div id="sidebar">
  <?php $this->load->view('admin/includes/stats'); ?>
</div><!--sidebar-->



