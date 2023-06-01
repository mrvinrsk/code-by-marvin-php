<?php
if (!isset($params['project'])) {
    header("Location: /");
    exit;
}

// show all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$project = strtolower($params['project']);
$projectName = ucwords(str_replace("-", " ", $project));

include_once "php/util.php";

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

$url = $protocol . $_SERVER['HTTP_HOST'];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $projectName; ?> | CodeByMarvin</title>
    <base href='/'>

    <link rel="stylesheet" href="style/css/global.min.css">

    <style>
        .back__to__main {
            position: fixed;
            top: 1rem;
            left: 1rem;
        }
    </style>
</head>
<body>

<button class="button back__to__main">Zurück</button>

<?php
$frame = doesExist($url . "/projects/$project/example.html") ? $url . "/projects/$project/example.html" : null;
$frame = $_SERVER['DOCUMENT_ROOT'] . str_replace($url, "", $frame);

if (doesExist($url . "/projects/$project")) { ?>

    <?php require_once $frame; ?>

<?php } else { ?>

    <main>
        <h1>Projekt nicht gefunden</h1>
        <p>
            Unter dem Link <strong><?php echo $projectName; ?></strong> konnte kein Projekt gefunden werden.
        </p>
    </main>

<?php } ?>

<script>
    document.querySelector(".back__to__main").addEventListener("click", function (e) {
        e.preventDefault();
        window.location.href = window.location.href.replace("/example", "");
    });
</script>

</body>
</html>
