<?php
class Layout {
  public function render($metadata, $contents, $parser) {
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title><?php echo $metadata['title']; ?> -- Eduardo Lavaque's Blog</title>
</head>
<body>
<h1><?php echo $metadata['title']; ?></h1>
<?php echo $parser->parse_contents($contents); ?>
</body>
</html>
    <?php
  }
}
