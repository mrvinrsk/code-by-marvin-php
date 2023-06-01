<?php
if (!isset($params['project'])) {
    header("Location: /");
    exit;
}

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
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title><?php echo $projectName; ?> | CodeByMarvin</title>
        <base href='/'>

        <link rel="stylesheet" href="style/css/global.min.css">
        <link rel="stylesheet" href="style/css/project-view.min.css">
    </head>
    <body>

        <main>
            <?php
            $frame = doesExist($url . "/projects/$project/example.html") ? $url . "/projects/$project/example.html" : null;
            $shortDescription = doesExist($url . "/projects/$project/description.html") ? $url . "/projects/$project/description.html" : null;
            $content = doesExist($url . "/projects/$project/content.html") ? $url . "/projects/$project/content.html" : null;
            $js = doesExist($url . "/projects/$project/needed.js") ? $url . "/projects/$project/needed.js" : null;
            $scss = doesExist($url . "/projects/$project/needed.scss") ? $url . "/projects/$project/needed.scss" : null;
            $css = doesExist($url . "/projects/$project/needed.css") ? $url . "/projects/$project/needed.css" : null;
            $markup = doesExist($url . "/projects/$project/needed.html") ? $url . "/projects/$project/needed.html" : null;

            if (doesExist($url . "/projects/$project")) { ?>

                <h1>Projekt: <?php echo $projectName; ?></h1>
                <p class='description'>
                    <?php if (!is_null($shortDescription)) { ?>
                        <?php echo file_get_contents($shortDescription); ?>
                    <?php } else { ?>
                        <em>Für dieses Projekt gibt es keine Zusammenfassung.</em>
                    <?php } ?>
                </p>

                <?php if (!is_null($frame)) { ?>
                    <h2>Beispiel</h2>
                    <iframe src="<?php echo $frame; ?>"></iframe>
                <?php } ?>

            <?php } else { ?>

                <h1>Projekt nicht gefunden</h1>
                <p>
                    Unter dem Link <strong><?php echo $projectName; ?></strong> konnte kein Projekt gefunden werden.
                </p>

            <?php } ?>
        </main>

    </body>
</html>
