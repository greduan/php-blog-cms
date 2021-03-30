<?php
class File {
  private $path;
  private $parsed_path;
  private $raw_file;

  public function __construct($path) {
    $this->path = $path;
    $this->parsed_path = pathinfo($path);
  }

  private function get_raw_file(): string {
    if (isset($this->raw_file)) {
      $raw_file = $this->raw_file;
    } else {
      $raw_file = file_get_contents($GLOBALS['content_dir'] . $this->path);
      $this->raw_file = $raw_file;
    }

    return $raw_file;
  }

  public function get_metadata(): array {
    $raw_file = $this->get_raw_file();
    preg_match('/---([\S\s]*)---/', $raw_file, $raw_metadata);
    $raw_metadata = $raw_metadata[1];
    return yaml_parse($raw_metadata);
  }

  public function get_contents(): string {
    $raw_file = $this->get_raw_file();
    preg_match('/---[\S\s]*---([\S\s]*)/', $raw_file, $raw_contents);
    $raw_contents = $raw_contents[1];
    return trim($raw_contents);
  }

  public function get_file_extensions(): array {
    preg_match('/\..*/', $this->path, $file_extensions);
    $file_extensions = explode('.', $file_extensions[0]);
    // From something like ['', 'html', 'md'] remove the first empty string
    array_shift($file_extensions);
    return $file_extensions;
  }
}
