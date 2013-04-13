<table>
        <thead>
            <tr>
        <th colspan="2"><a href="<?php echo base_url(); ?>admin/users">Users</a></th>
        <tr>
        </thead>
        <tbody>
        <tr>
                <td width="190">Your Username: </td>
        <td><strong><?php echo $statistics['current_user']; ?></strong></td>
            </tr>
            <tr>
               <td> Your Role: </td>
        <td> <strong> <?php echo $statistics['current_role']; ?></strong></td>
           </tr>
            <tr>
               <td> Total Registered:  </td>
         <td> <strong><?php echo $statistics['num_users']; ?></strong></td>
            </tr>
            <tr>
               <td> Activated:  </td>
        <td> <strong> <?php echo $statistics['num_activated_users']; ?></strong></td>
            </tr>
            <tr>
               <td> Unactivated:  </td>
        <td> <strong><?php echo $statistics['num_unactivated_users']; ?></strong></td>
        </tr>
        </tbody>
        </table>
    
    <table>
        <thead>
            <tr>
        <th colspan="2"><a href="<?php echo base_url(); ?>admin/pages">Pages</a></th>
        <tr>
        </thead>
        <tbody>
        <tr>
                <td width="190">Total Pages: </td>
        <td><strong> <?php echo $statistics['num_posts']; ?></strong></td>
            </tr>
            <tr>
               <td> Published: </td>
        <td> <strong> <?php echo $statistics['num_published_posts']; ?></strong></td>
           </tr>
            <tr>
               <td> Unpublished:  </td>
         <td> <strong><?php echo $statistics['num_unpublished_posts']; ?></strong></td>
            </tr>
        </tbody>
        </table>
    
    <?php if ($activate_blog->value == 1) : ?>
    <table>
        <thead>
            <tr>
        <th colspan="2"><a href="<?php echo base_url(); ?>admin/posts">Blog Posts</a></th>
        <tr>
        </thead>
        <tbody>
        <tr>
                <td width="190">Total Posts: </td>
        <td><strong> <?php echo $statistics['num_posts']; ?></strong></td>
            </tr>
            <tr>
               <td> Published: </td>
        <td> <strong> <?php echo $statistics['num_published_posts']; ?></strong></td>
           </tr>
            <tr>
               <td> Unpublished:  </td>
         <td> <strong><?php echo $statistics['num_unpublished_posts']; ?></strong></td>
            </tr>
        </tbody>
        </table>
<?php endif; ?>

