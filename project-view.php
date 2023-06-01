<?php
if (!isset($params['project'])) {
    header("Location: /");
    exit;
}

$project = strtolower($params['project']);
$projectName = ucwords(str_replace("-", " ", $project));
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
            $frame = null;
            switch ($project) {
                case "popups":
                    $frame = "/projects/popups/example.html";
                    break;
                default:
                    break;
            }

            if (!is_null($frame)) { ?>

                <h1>Projekt: <?php echo $projectName; ?></h1>
                <iframe src='<?php echo $frame; ?>'></iframe>

            <?php } else { ?>

                <h1>Projekt nicht gefunden</h1>
                <p>
                    Unter dem Link <strong><?php echo $projectName; ?></strong> konnte kein Projekt gefunden werden.
                </p>

            <?php } ?>
        </main>

    </body>
</html>
