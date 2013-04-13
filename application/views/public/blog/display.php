<!--Messages-->
<?php if($this->session->flashdata('comment_added')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('comment_added') . '</p>'; ?>
<br />
<?php endif; ?>

<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "ur-9f716155-7283-3a8f-6a5a-244510a7f7f1"});</script>
<div class="post_share">
<span class='st_sharethis_large' displayText='ShareThis'></span>
<span class='st_facebook_large' displayText='Facebook'></span>
<span class='st_twitter_large' displayText='Tweet'></span>
<span class='st_linkedin_large' displayText='LinkedIn'></span>
<span class='st_email_large' displayText='Email'></span>
</div>
<h1 class="post_display_title"><?php echo $post->title; ?></h1>
<div class="sub_line">
Posted on: <?php echo date("F j, Y",strtotime($post->create_date)); ?>
 by 
<strong><?php echo $author->first_name . " " . $author->last_name; ?></strong>
</div>
<?php echo $post->body; ?>
<div id="post_meta">
<strong>Tags:</strong> <?php echo $post->tags; ?><br />
<strong>Published in:</strong> 
    <?php if(isset($category->name)) : ?>
        <?php echo $category->name; ?>
    <?php else : ?>
        <?php echo $category; ?>
    <?php endif; ?>
</div>
<?php echo validation_errors('<p class="error">'); ?>
<?php $this->load->view('public/blog/comments'); ?>

