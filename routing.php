<?php
include_once "php/Router.php";
$route = new Router();

$route->add("/", "index.php");
$route->add("/{project}", "project-view.php");

$route->notFound("errors/404.php");
