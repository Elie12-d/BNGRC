<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>

<body>
    <h1>Dashboard</h1>
    <table>
        <thead>
            <tr>
                <th>Ville</th>
                <th>Produit</th>
                <th>Type</th>
                <th>Besoin</th>
                <th>Attribué</th>
                <th>Reste</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($details as $detail): ?>
                <tr>
                    <td><?= $detail['ville'] ?></td>
                    <td><?= $detail['produit'] ?></td>
                    <td><?= $detail['type'] ?></td>
                    <td><?= $detail['besoin_qte'] ?> <?= $detail['unite'] ?></td>
                    <td><?= $detail['attribue_qte'] ?> <?= $detail['unite'] ?></td>
                    <td><?= $detail['reste_qte'] ?> <?= $detail['unite'] ?></td>
                    <td>
                        <span class="badge badge-<?= $detail['statut_class'] ?>">
                            <?= $detail['statut_label'] ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>