<?php
require_once dirname(__FILE__) . '/File.php';

class Url {
  private $parsed_url;
  private $file_path;
  private $file;

  public function __construct($uri) {
    $this->parsed_url = parse_url($uri);
  }

  private function get_file_path() {
    // Break early if we already know the answer.
    if (isset($this->file_path)) {
      return $this->file_path;
    }

    $uri = $this->parsed_url['path'];

    if (is_dir($GLOBALS['content_dir'] . $uri)) {
      $uri = $uri . (substr($uri, -1) === '/' ? '' : '/') . 'index';
    }

    $uri = pathinfo($uri);
    $uri = $uri['dirname'] . (substr($uri['dirname'], -1) === '/' ? '' : '/') . $uri['filename'];
    $file_extensions = ['', '.php', '.html', '.md'];

    foreach ($file_extensions as $extension) {
      if (
        file_exists($GLOBALS['content_dir'] . $uri . $extension) &&
        !is_dir($GLOBALS['content_dir'] . $uri . $extension)
      ) {
        $file_path = $uri . $extension;
        $this->file_path = $file_path;
        return $file_path;
      }
    }

    // If after running through the extensions we don't find a file, then we
    // return a 404 error.
    // TODO: Handle 404 better, e.g. including 404 page
    http_response_code(404);
    echo '<h1>Not Found</h1>';
    die();
  }

  public function get_file(): File {
    if (isset($this->file)) {
      return $this->file;
    } else {
      $this->file = new File($this->get_file_path());
      return $this->file;
    }
  }
}
