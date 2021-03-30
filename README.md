# PHP Blog CMS

A straightforward, file-based CMS written in PHP.

## Install

```shell
$ composer install
```

If using with Devilbox, make this repo the folder under `data/www/` and then
make a symlink:

```shell
$ ln -sv public htdocs
```

So it'd look something like:

```
data/www/my-blog
data/www/my-blog/htdocs -> ./public
```

## Features

- Basic metadata header parsing.
- Straightforward templating via "layouts".

## Metadata

The very common header format is used for the metadata.  Its contents are
expected to be in the YAML format.  E.g.

```
---
title: Exiting early, cognitive load
layout: blogpost
date: 2018-09-10
---
```

**The `layout` property should _always_ be present.**

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
<?php echo '<h1>' . $metadata['title'] . '</h1>'; ?>
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
