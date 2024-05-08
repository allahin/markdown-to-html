<?php
require_once 'load/Parsedown.php';

$markdownFolder = 'md';
$htmlFolder = 'html';

$template = <<<HTML
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello World!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
    a {
        text-decoration: none;
    }
</style>
</head>
<body>
<div class="container mt-3">
%s
</div>
<script>
window.onload = function() {
    var images = document.getElementsByTagName('img');
    for (var i = 0; i < images.length; i++) {
        images[i].classList.add('img-fluid');
    }
};
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
HTML;

$markdownFiles = glob_recursive($markdownFolder . '/*.md');

$parser = new Parsedown();

foreach ($markdownFiles as $markdownFile) {
    $filepath = pathinfo($markdownFile);
    $relativePath = substr($filepath['dirname'], strlen($markdownFolder));

    $htmlSubFolder = $htmlFolder . $relativePath;
    if (!file_exists($htmlSubFolder)) {
        mkdir($htmlSubFolder, 0777, true);
    }

    $markdownContent = file_get_contents($markdownFile);

    $htmlContent = $parser->text($markdownContent);

    $htmlFile = $htmlSubFolder . '/' . $filepath['filename'] . '.html';

    $fullHtmlContent = sprintf($template, $htmlContent);

    file_put_contents($htmlFile, $fullHtmlContent);

    echo "File converted: $markdownFile -> $htmlFile\n";
}

echo "All files have been converted.\n";

function glob_recursive($pattern, $flags = 0)
{
    $files = glob($pattern, $flags);
    foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
        $files = array_merge($files, glob_recursive($dir . '/' . basename($pattern), $flags));
    }
    return $files;
}
