<h1>Blog</h1>
<?php if(empty($latest_posts)) : ?>
    No posts to display
<?php endif; ?>
<?php foreach ($latest_posts as $post) : ?>
<?php 
     //Clean post link
    $link = strtolower(str_replace(' ','-',$post->title)); 
    $link = str_replace(',','',$link);
    $link = str_replace('.','',$link);
    $clean_link = base_url() . $link;
?>

    <h1 class="post_title">
        <a href="<?php echo $clean_link; ?>"><?php echo $post->title; ?></a></h1>
   <div class="sub_line">
Posted on: <?php echo date("F j, Y",strtotime($post->create_date)); ?>
 by 
<strong>
    <?php echo get_author_name($post->author_id); ?>
    <?php //echo $author->first_name . " " . $author->last_name; ?>
</strong>
</div>
<?php if($post->main_image != "") : ?>
    <img src="<?php echo base_url(); ?>assets/images/blog/<?php echo $post->main_image; ?>" 
     alt="<?php echo $post->title; ?>" 
     width="<?php echo $main_image_width; ?>"
     id="blog_main_image"
    />
<?php endif; ?>
<div style="overflow:auto;">
   <?php echo trunc_latest_blog($post->body, 300); ?>
    <br />
     <a class="readmore" href="<?php echo $clean_link; ?>">Read More</a>
     <div style="clear:both"></div>
</div>
<?php endforeach; ?>
 
