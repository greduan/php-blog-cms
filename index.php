<?php
// Load Composer packages
require_once(dirname(__FILE__) . '/vendor/autoload.php');

$url = parse_url($_SERVER['REQUEST_URI'])['path'];

// Find out if there's an alias and use it if there is
$url_aliases = file_get_contents(dirname(__FILE__) . '/content/url_aliases.json');
$url_aliases = json_decode($url_aliases, true);
if (isset($url_aliases[$url])) {
  $url = $url_aliases[$url];
} else {
  //
}

$url_file_contents = file_get_contents(dirname(__FILE__) . '/content' . $url);

$content_start_index = strpos($url_file_contents, "---\n\n") + 5;
$raw_metadata = substr($url_file_contents, 0, $content_start_index);
$content = substr($url_file_contents, $content_start_index);

preg_match('/(layout):\s?(.+)\n/', $raw_metadata, $file_layout);
$file_layout = $file_layout[2];

function parse_metadata($metadata) {
  $metadata_properties = [];
  $lines = explode("\n", $metadata);
  foreach ($lines as $line) {
    $line = trim($line);
    if ($line === '---' || $line === '') {
      continue;
    }
    $split_line = preg_split('/(?<!\\\\):/', $line);
    $metadata_properties[trim($split_line[0])] = trim($split_line[1]);
  }
  return $metadata_properties;
}

$parsed_metadata = parse_metadata($raw_metadata);

$parsed_path = pathinfo($url);

if ($parsed_path['extension'] === 'md') {
  function render_content() {
    global $content;
    $Parsedown = new Parsedown();
    $html = $Parsedown->text($content);
    echo $html;
  }
}

require_once dirname(__FILE__) . '/content/layouts/' . $file_layout . '.php';

render_page($parsed_metadata);
