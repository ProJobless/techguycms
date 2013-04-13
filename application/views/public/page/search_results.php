 <?php if ($search_num_rows) : ?>
<?php if ($search_num_rows == 1) : ?>
<h3> You have <?php echo $search_num_rows; ?> result</h3>
<?php else : ?>
<h3>You have <?php echo $search_num_rows; ?> results</h3>
<?php endif; ?>
<ul>
<?php foreach($search_results as $page_part) : ?>
    <li><strong><a href="<?php echo base_url(); ?>page/display/<?php echo $page_part->id; ?>"><?php echo $page_part->name; ?></a></strong><br />
    <?php echo substr($page_part->body,0,150); ?></li>
<?php endforeach; ?>
    </ul>
<?php else : ?>
<p>Sorry, no results matched</p>
<?php endif; ?>