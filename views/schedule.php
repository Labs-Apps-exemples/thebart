<h2><?= $station->name ?></h2>
<table>

  <thead>
    <tr>
      <th>Destination</th>
      <th>ETD</th>
    </tr>
  </thead>

  <tbody>

    <?php foreach ($station->etd as $etd): ?>
        <?php foreach ($etd->estimate as $estimate): ?>

          <tr>
            <th><?= $etd->destination ?></th>
            <th><?= $estimate->minutes ?><?= ($estimate->minutes == 'Leaving') ? '' : 'min' ?></th>
          </tr>

        <?php endforeach ?>
    <?php endforeach ?>

  </tbody>

</table>
