# PHP Blog CMS

PHP Blog CMS is simple, straightforward, file-based CMS written in PHP.

The cool thing is, it's just plain PHP, so in your layouts/pages you can do
whatever you deem fit in order to make your blog look/behave how you want it to.

## Install

```shell
$ composer install
```

If using with Devilbox, make this repo the folder under
`data/www/{yourprojectname}/htdocs`.

### Requirements

- PHP7.4+
- Apache

## Usage

In short, you make it run locally and you make sure it works, you fill out the
`content/` appropriately to have your website as you want it, and then via SFTP
or SSH or what have you, transfer the files to your host, excluding dotfiles.

## Features

- Basic metadata header parsing.  (AKA YAML Front Matter)
- Straightforward templating via "layouts".
- Basic support for an `assets/` folder, files in here won't have
  pre-processing applied to them as they're served straight by the server.

## Metadata (Front-matter)

The very common header format is used for the metadata.  Its contents are
expected to be in the YAML format.  E.g.

```
---
title: Exiting early, cognitive load
layout: blogpost
date: 2018-09-10
---
```

### `layout`

**The `layout` property should _always_ be present.**  Unless the `redirect`
property is being defined.

### `redirect`

Allows you to redirect the current page to a different URL.

Note it'll use HTTP status 301 Moved Permanently.

```
---
redirect: /blog/2018/09/10/exiting-early-cognitive-load
---
```

## Layouts

A simple layout example is:

```php
<?php
class Layout {
  public function render($metadata, $contents, $parser) {
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title><?php echo $metadata['title']; ?> -- My Blog</title>
</head>
<body>
<h1><?php echo $metadata['title']; ?></h1>
<?php echo $parser->parse_contents($contents); ?>
</body>
</html>
    <?php
  }
}
```

## Parsers

At the moment only one parser exists, the `Markdown_To_Html_Parser`.  Depending
on the file extension a different parser would be chosen.  In the end they
should all ultimately render down to HTML though, as that is what the layouts
would expect.

## License

This software is licensed under the permissive OpenBSD license.  See the
`LICENSE` file for more details.
