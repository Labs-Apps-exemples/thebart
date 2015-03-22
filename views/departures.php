<div class="infowindow">
  <div class="infowindow-header">
    <h2><?= $station->name ?></h2>
    <p>Next departures</p>
  </div><!-- .infowindow-header -->

  <?php if (empty($departures)): ?>

      <p>No departures scheduled in the next minutes.</p>

  <?php else: ?>

      <table>

        <thead>
          <tr>
            <th class="destination">Destination</th>
            <th class="minutes">Time</th>
          </tr>
        </thead>
        <tbody>

          <?php foreach ($departures as $departure): ?>

                <tr>
                  <th class="destination"><?= $departure['destination'] ?></th>
                  <th class="minutes"><?= $departure['minutes'] ?><?= ($departure['minutes'] == 'Leaving') ? '' : ' min' ?></th>
                </tr>

          <?php endforeach ?>

        </tbody>

      </table>

  <?php endif ?>

</div><!-- .infowindow -->
