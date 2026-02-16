<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recapitulation</title>
</head>
<body>
    <h3>Besoins totaux : <?= $total ?></h3>
    <h3>Besoins satisfais : <?= $total_satisfait ?></h3>
    <h3>Besoins restantes : <?= $total - $total_satisfait ?></h3>
</body>
</html>