<?php
define(REQUEST_URI,$_SERVER['REQUEST_URI']);

include ('functions.php');
include ('IndexController.php');

new IndexController();