<script>
    $(document).ready(function(){
       var dd = $('dd');
       dd.filter(':nth-child(n+4)').addClass('hide');
       
       $('dl').on('click', 'dt', function(){
           $(this)
                .next()
                .slideDown(800)
                .siblings('dd')
                .slideUp(800);
       });
    });
</script>

<div id="help_info">
<h1>Help & Info</h1>
<p>Techguy CMS Version: <strong>1.0.4</strong></p>
<dl>
	<dt>Dashboard</dt>
	<dd>
          <?php
            $this->load->view('admin/help/dashboard')
          ?>
        </dd>
        <dt>Pages</dt>
	<dd>
          <?php
            $this->load->view('admin/help/pages')
          ?>
        </dd>
	<dt>Blog/Posts</dt>
	<dd>
          <?php
            $this->load->view('admin/help/blog')
          ?>
        </dd>
	<dt>Users</dt>
	<dd>
          <?php
            $this->load->view('admin/help/users')
          ?>
        </dd>
	<dt>Modules</dt>
	<dd>
          <?php
            $this->load->view('admin/help/modules')
          ?>
        </dd>
	<dt>Settings</dt>
	<dd>
          <?php
            $this->load->view('admin/help/settings')
          ?>
        </dd>
        <dt>Permissions</dt>
	<dd>
          <?php
            $this->load->view('admin/help/troubleshoot')
          ?>
        </dd>
        
</dl>


</div>