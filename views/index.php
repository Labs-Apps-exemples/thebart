<!DOCTYPE html>

<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>The BART</title>

    <link rel="stylesheet" href="css/style.css">

    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
    <script type="text/javascript" src="js/scripts.js"></script>

  </head>
  <body>
    <h1>The BART</h1>
    <form id="route_form">
      <select id="route_select">

        <?php foreach ($routes as $route): ?>
            <option value="<?= $route['number'] ?>"><?= $route['number'] ?> - <?= $route['name'] ?></option>
        <?php endforeach ?>

      </select>
      <input type="submit">
    </form>
    <div id="map-canvas"></div>
    <div id="php"></div>
  </body>
</html>
