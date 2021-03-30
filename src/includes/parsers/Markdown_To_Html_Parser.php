<?php
class Markdown_To_Html_Parser {
  private $parsedown;

  public function __construct() {
    $this->parsedown = new Parsedown();
  }

  public function parse_contents($contents): string {
    return $this->parsedown->text($contents);
  }
}
