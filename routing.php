<?php
include_once "php/Router.php";
include_once "php/util.php";

$route = new Router();

$route->add("/", "index.php");
$route->add("/{project}", "project-view.php");
$route->add("/{project}/example", "example-view.php");

$route->notFound("errors/404.php");
