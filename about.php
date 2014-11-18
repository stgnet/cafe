<?php
use \Michelf\Markdown;
require 'vendor/autoload.php';

require 'head.php';

echo '<div class="container">';

echo Markdown::defaultTransform(file_get_contents('README.md'));

echo '</div>';

require 'foot.php';

