<h2><?= $station->name ?></h2>

<?php if (empty($departures)): ?>

    <p>No departures scheduled in the next hour.</p>

<?php else: ?>

    <p>Next departures:</p>
    <table>

      <thead>
        <tr>
          <th>Destination:</th>
          <th>Time:</th>
        </tr>
      </thead>

      <tbody>

        <?php foreach ($departures as $departure): ?>

              <tr>
                <th><?= $departure['destination'] ?></th>
                <th><?= $departure['minutes'] ?><?= ($departure['minutes'] == 'Leaving') ? '' : ' min' ?></th>
              </tr>

        <?php endforeach ?>

      </tbody>

    </table>

<?php endif ?>
