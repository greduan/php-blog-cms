<?php
// Load Composer packages
require_once dirname(__FILE__, 2) . '/vendor/autoload.php';

require_once dirname(__FILE__) . '/includes/Url.php';

$request_url = new Url($_SERVER['REQUEST_URI']);
$file = $request_url->get_file();

$extensions = $file->get_file_extensions();

if ($extensions == ['md'] || $extensions == ['html', 'md']) {
  require_once dirname(__FILE__) . '/includes/parsers/Markdown_To_Html_Parser.php';
  $parser = new Markdown_To_Html_Parser();
}

$metadata = $file->get_metadata();

// This is expected to load a Layout class with a ->render() method which will
// be passed ($metadata: Array, $contents: String, $parser: Parser).  It is
// expected to output the whole page.
require_once $GLOBALS['content_dir'] . '/layouts/' . $metadata['layout'] . '.php';

$layout = new Layout();
$layout->render($metadata, $file->get_contents(), $parser);
