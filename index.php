<?php
include_once "php/util.php";

$root = $_SERVER['DOCUMENT_ROOT'];
$parentDir = $root . '/projects';
$dirs = getDirs($parentDir);
?>


<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Home | CodeByMarvin</title>

        <link rel="stylesheet" href="style/css/global.min.css">
        <link rel="stylesheet" href="style/css/index.min.css">
    </head>
    <body>

        <main>
            <h1>Alle Projekte</h1>

            <ul class='projects'>
                <?php foreach ($dirs as $dir) {
                    $projectName = ucfirst(basename($dir));
                    $safeName = safeName($projectName);
                    ?>
                    <li class='project' data-project='<?php echo removeDocumentRootFromPath($dir) ?>'>
                        <a href='/<?php echo $safeName; ?>'>
                            <strong><?php echo $projectName; ?></strong>
                            <p class='description'></p>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </main>

        <script>
            document.querySelectorAll('.project').forEach(project => {
                const projectName = project.dataset.project;
                const description = project.querySelector('.description');
                const url = `${projectName}/description.html`;

                fetch(url)
                    .then(response => response.text())
                    .then(text => {
                        description.innerHTML = text;
                    })
                    .catch(error => {
                        console.error(error);
                        description.innerHTML = '<em>Für dieses Projekt gibt es keine Zusammenfassung.</em>';
                    });
            });
        </script>

    </body>
</html>
