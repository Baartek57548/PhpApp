<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></title>
    </head>

    <body>
        <h1>Hello World App</h1>
        <p>Wybierz element z menu:</p>
        <ul>
            <li><a href="/?page=homepage">Strona glowna</a></li>
            <li><a href="/?page=about">O nas</a></li>
            <li><a href="/?page=articles">Artykuly</a></li>
            <li><a href="/?page=dashboard">Dashboard</a></li>
        </ul>
        <div>
            <?php echo $content; ?>
        </div>
    </body>
</html>

