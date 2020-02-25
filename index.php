<?php
require_once("config.php");

$felipe = new Usuario();

$felipe->loadById(1);

echo $felipe;

?>