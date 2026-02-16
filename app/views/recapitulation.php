<?php

use Tracy\Bar;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recapitulation</title>
</head>
<body>
    <button id="refresh-button">Actualiser</button>
    <h3>Besoins totaux : <?= $total ?></h3>
    <h3>Besoins satisfais : <?= $total_satisfait ?></h3>
    <h3>Besoins restantes : <?= $total - $total_satisfait ?></h3>
    <script src="<?= BASE_URL ?>/assets/js/actualiser.js"></script>
</body>
</html>