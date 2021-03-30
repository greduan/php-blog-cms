<?php
class Layout {
  private function get_blog_posts() {
    $offset = strlen(dirname(__FILE__, 2));
    $posts = glob(dirname(__FILE__, 2) . '/blog/*/*/*/*.md');
    $files = array_map(function ($full_post_path) use ($offset) {
      $post_uri = substr($full_post_path, $offset);
      $file = new File($post_uri);
      $metadata = $file->get_metadata();
      $path_parts = pathinfo($post_uri);
      $metadata['_uri'] = $path_parts['dirname'] . '/' . $path_parts['filename'];
      return $metadata;
    }, $posts);
    return $files;
  }

  public function render($metadata) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="utf-8" />
      <title><?php echo $metadata['title']; ?> -- Eduardo Lavaque's Blog</title>
    </head>
    <body>
    <h1><?php echo $metadata['title']; ?></h1>
    <ul>
      <?php foreach ($this->get_blog_posts() as $post) { ?>
        <li>
          <a href="<?php echo $post['_uri']; ?>"><?php echo $post['title']; ?></a></li>
      <?php } ?>
    </ul>
    </body>
    </html>
    <?php
  }
}
