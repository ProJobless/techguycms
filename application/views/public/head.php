<head>
<meta name="description" content="
<?php if(!empty($page_meta->meta_description)) : ?>
    <?php echo $page_meta->meta_description; ?>
<?php else : ?>
    <?php echo $meta_description->value; ?>
<?php endif; ?>" /> 
<meta name="keywords" content="
<?php if(!empty($page_meta->meta_keywords)) : ?>
    <?php echo $page_meta->meta_keywords; ?>
<?php else : ?>
    <?php echo $meta_keywords->value; ?>
<?php endif; ?>" /> 
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/site.js"></script>
<title>
<?php if(!empty($page_meta->page_title)) : ?>
    <?php echo $page_meta->page_title; ?>
<?php else : ?>
    <?php if($page_title->value == "") : ?>
        <?php echo $website_name->value; ?> | <?php echo ucwords(str_replace('-',' ',$this->uri->segment(1))); ?>
    <?php else : ?>
        <?php echo $page_title->value; ?>
    <?php endif; ?>
<?php endif; ?>
</title>
  <?php echo $google_analytics->value; //Google Analytics Code ?>
<script type="application/javascript">
$(document).ready(function() {
$('#submit').click(function() {
var form_data = {
username : $('.username').val(),
password : $('.password').val(),
ajax : '1'
};
$.ajax({
url: "<?php echo site_url('login/ajax_check'); ?>",
type: 'POST',
async : false,
data: form_data,
success: function(msg) {
$('#message').html(msg);
}
});
return false;
});
});
</script>
</head>