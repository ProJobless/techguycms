<h3 class="comments_heading">Comments</h3>
<div id="bottom"></div>
<?php if(!empty($blog_comments)) : ?>
<?php foreach($blog_comments as $comment) : ?>
<div class="comment">
<div class="comment_left">
<img src="<?php echo base_url(); ?>assets/images/blog/blog_avatar.png" alt="User" width="50" /><br />
Posted By: <br />
 <?php if($comment->website) : ?>
   <a href="<?php echo prep_url($comment->website); ?>" target="_blank"> <?php echo $comment->author_name; ?></a>
   <?php else : ?>
   <?php echo $comment->author_name; ?>
   <?php endif; ?>
</div>
<div class="comment_right">
<h5><?php echo $comment->title; ?></h5>
<p><?php echo $comment->body; ?></p>
</div>
</div><!--comment-->
<div class="clr"></div>
<?php endforeach; ?>
<?php else : ?>
    No Comments
<?php endif; ?>
<br />
<br />
<h3>Add A Comment</h3>
<?php if($this->session->flashdata('comment_form')) : ?>
<?php echo '<p class="error">' .$this->session->flashdata('comment_form') . '</p>'; //Login failed ?>
<?php endif; ?>
<?php $attributes = array('id' => 'comment_form'); ?>
<?php echo form_open("blog/comment_form_process/$post->id",$attributes); ?>
<div id="message"> </div>
<p>
<label for="title">Title:</label>
<?php echo form_input('title')?><br />
</p>
<p>
<label for="name">Name:</label>
<?php echo form_input('name')?><br />
</p>
<p>
<label for="website">Website:</label>
<?php echo form_input('website')?><br />
</p>
<p>
Comment:<br />
<?php echo form_textarea('comment')?><br />
</p>
<p>
<?php echo form_submit('submit','Submit Comment')?>
</p>
<?php echo form_close()?>