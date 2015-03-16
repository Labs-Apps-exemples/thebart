<!DOCTYPE html>

<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>The BART</title>

    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">

    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
    <script type="text/javascript" src="js/scripts.js"></script>

  </head>
  <body>
    <header class="header" role="banner">

      <h1 class="site-title"><a href="/">The BART</a></h1>
      <form id="route_form">
        <select id="route_select">

          <?php foreach ($routes as $route): ?>
              <option value="<?= $route['number'] ?>"><?= $route['number'] ?> - <?= $route['name'] ?></option>
          <?php endforeach ?>

        </select>
        <input type="submit" value="Submit">
      </form>

    </header>

    <div id="map-canvas">
    </div><!-- #map-canvas -->

    <footer class="footer">
      <p><a href="http://www.bart.gov/schedules/developers/api">Powered by BART API</a></p>
      <p>This is a fictive website built as an exercise for the <a href="http://cs75.tv">Computer Science E-75</a> course.</p>
      <p>More info at <a href="https://github.com/nelsonreitz/project2">github.com/nelsonreitz/project2</a>.</p>
      <p>&copy; Nelson Reitz - 2015</p>
    </footer>
  </body>
</html>
