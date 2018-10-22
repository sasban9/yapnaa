<?php
global $porto_settings;

// For Favicon
if ($porto_settings['favicon']): ?>
    <link rel="shortcut icon" href="<?php echo esc_url(str_replace( array( 'http:', 'https:' ), '', $porto_settings['favicon']['url'])); ?>" type="image/x-icon" />
<?php endif;

// For iPhone
if ($porto_settings['icon-iphone']): ?>
    <link rel="apple-touch-icon" href="<?php echo esc_url(str_replace( array( 'http:', 'https:' ), '', $porto_settings['icon-iphone']['url'])); ?>">
<?php endif;

// For iPhone Retina
if ($porto_settings['icon-iphone-retina']): ?>
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo esc_url(str_replace( array( 'http:', 'https:' ), '', $porto_settings['icon-iphone-retina']['url'])); ?>">
<?php endif;

// For iPad
if ($porto_settings['icon-ipad']): ?>
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo esc_url(str_replace( array( 'http:', 'https:' ), '', $porto_settings['icon-ipad']['url'])); ?>">
<?php endif;

// For iPad Retina
if($porto_settings['icon-ipad-retina']): ?>
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo esc_url(str_replace( array( 'http:', 'https:' ), '', $porto_settings['icon-ipad-retina']['url'])); ?>">
<?php endif; ?>

<?php wp_head(); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/custum.css">

<?php
if (isset($porto_settings['js-code-head']) && $porto_settings['js-code-head']) { ?>
    <script type="text/javascript">
        <?php echo $porto_settings['js-code-head']; ?>
    </script>
<?php }
?>




<!-- Google Analytics: Change UA-XXXXX-X to be your site's ID. Go to http://www.google.com/analytics/ for more information.-->
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-12345678-1', 'auto');
ga('send', 'pageview');
</script>


