<?php
$string = "some/path/here some\\other\\path";
$ds = DIRECTORY_SEPARATOR;
$result = str_replace(array("/","\\"),$ds,$string);
echo $result;

if(file_exists("controllers"));