<!doctype html>

<html lang="es">
<head>
  <meta charset="utf-8">

  <title><?= COMPANY_NAME ?></title>
  <meta name="description" content="<?= COMPANY_NAME ?>">
  <meta name="author" content="<?= COMPANY_NAME ?>">

</head>

<body>
    <h1><a href="http://127.0.0.1"><?= COMPANY_NAME ?></a></h1>
    <main role="main" class="container">
        <div>
            <form action="/Companies/showPaths" id="citiesform" method="post">
                <label for="origins">Elija un origen:</label>
                <select id="origins" name="origin" form="citiesform">
                    <?php foreach ($cities as $index => $name) : ?>
                        <option value="<?= $index ?>"><?= $name ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="destinations">Elija un destino:</label>
                <select id="destinations" name="destination" form="citiesform">
                    <option value="-1">TODOS</option>
                    <?php foreach ($cities as $index => $name) : ?>
                        <option value="<?= $index ?>"><?= $name ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="submit">
            </form>
            <?php echo $content_for_layout; ?>
        </div>
    </main>
</body>
</html>