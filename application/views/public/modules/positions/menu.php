<div class="mainmenu">
    <ul id="menu" class="dropdown">
    <?php foreach($main_menu as $item) : ?>
        <li><a href="<?php echo base_url(); ?><?php echo $item->alias; ?>"><?php echo $item->anchor; ?></a>
            <ul class="sub_menu">
        <?php foreach($main_menu_child as $child_item) : ?>
            <?php if($child_item->parent_id == $item->item_id) : ?>
                <li><a href="<?php echo base_url(); ?><?php echo $child_item->alias; ?>"><?php echo $child_item->anchor; ?></a></li>
            <?php endif; ?>
     <?php endforeach; ?>        
    </ul>
</li>
<?php endforeach; ?>
</ul>	
</div>