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
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $projectName; ?> | CodeByMarvin</title>
    <base href='/'>

    <link rel="stylesheet" href="style/css/highlight.min.css">
    <link rel="stylesheet" href="style/css/global.min.css">
    <link rel="stylesheet" href="style/css/project-view.min.css">

    <script src="js/highlight.min.js"></script>
    <script src="js/highlight-lines.min.js"></script>
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

            <div class="frame">
                <a href="/<?php echo $project; ?>/example" class="button fullscreen">Vollbild</a>
                <iframe src="<?php echo $frame; ?>" title="Example"></iframe>
            </div>

            <h2>Erklärung</h2>
            <p>
                <?php echo file_get_contents($content); ?>
            </p>

            <h2>Code</h2>
            <div class="code__grid">
                <div class="code__container">
                    <?php if (!is_null($markup)) { ?>
                        <pre
                            class="code markup"><code><?php echo htmlspecialchars(file_get_contents($markup)); ?></code></pre>
                    <?php } else { ?>
                        <p>Kein HTML benötigt</p>
                    <?php } ?>
                </div>
                <div class="code__container">
                    <?php if (!is_null($js)) { ?>
                        <pre class="code js"><code><?php echo file_get_contents($js); ?></code></pre>
                    <?php } else { ?>
                        <p>Kein JavaScript benötigt</p>
                    <?php } ?>
                </div>
                <div class="code__container">
                    <?php if (!is_null($scss)) { ?>
                        <pre class="code scss"><code><?php echo file_get_contents($scss); ?></code></pre>
                    <?php } else { ?>
                        <p>Kein Styling benötigt</p>
                    <?php } ?>
                </div>
                <div class="code__container">
                    <?php if (!is_null($css)) { ?>
                        <pre class="code css"><code><?php echo file_get_contents($css); ?></code></pre>
                    <?php } else { ?>
                        <p>Kein Styling benötigt</p>
                    <?php } ?>
                </div>
            </div>

        <?php } ?>

    <?php } else { ?>

        <h1>Projekt nicht gefunden</h1>
        <p>
            Unter dem Link <strong><?php echo $projectName; ?></strong> konnte kein Projekt gefunden werden.
        </p>

    <?php } ?>
</main>

<script>
    hljs.highlightAll();
    hljs.initLineNumbersOnLoad();

    document.querySelectorAll('.code__container').forEach((block) => {
        if (block.querySelector('code')) {
            const copyButton = document.createElement('button');
            copyButton.className = 'copy-button';
            copyButton.innerHTML = 'Kopieren';

            copyButton.addEventListener('click', () => {
                const code = block.querySelector('code');

                // copy with fallback
                try {
                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(code.innerText);
                        console.log('copied by navigator.clipboard');
                    } else {
                        const textArea = document.createElement('textarea');
                        textArea.value = code.innerText;
                        document.body.appendChild(textArea);
                        textArea.select();
                        document.execCommand('copy');
                        document.body.removeChild(textArea);

                        console.log('copied by document.execCommand');
                    }

                    copyButton.innerHTML = 'Kopiert!';

                    setTimeout(() => {
                        copyButton.innerHTML = 'Kopieren';
                    }, 2000);
                } catch (e) {
                    console.log('copy failed');
                    copyButton.innerHTML = 'Fehler';

                    setTimeout(() => {
                        copyButton.innerHTML = 'Kopieren';
                    }, 2000);
                }
            });

            block.appendChild(copyButton);
        }
    });
</script>

</body>
</html>
