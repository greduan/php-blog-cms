<?php
function render_page($metadata) {
  ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="utf-8" />
      <title><?php echo $metadata['title']; ?> -- Eduardo Lavaque's Blog</title>
    </head>
    <body>
    <?php echo '<h1>' . $metadata['title'] . '</h1>'; ?>
    <?php render_content(); ?>
    </body>
    </html>
  <?php
}
?>
