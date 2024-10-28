<?php $target = '/home/deemaslifestyle/sbfashionhouse.com/storage/app/public/';

$shortcut = '/home/deemaslifestyle/sbfashionhouse.com/public/storage';
var_dump(symlink($target, $shortcut));
exit;
?>

