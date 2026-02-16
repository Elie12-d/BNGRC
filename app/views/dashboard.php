<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard BNGRC</title>
</head>
<body>
    <h1>Tableau de bord - Suivi des distributions</h1>
    
    <!-- Statistiques simples -->
    <table width="100%" cellpadding="10" cellspacing="0" border="1">
        <tr>
            <th>Total Villes</th>
            <th>Total Besoins</th>
        </tr>
        <tr>
            <td><?= count($villes) ?></td>
            <td><?= count($besoins) ?></td>
        </tr>
    </table>

    <h2>Détail des besoins par ville</h2>
    
    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <thead>
            <tr bgcolor="#f2f2f2">
                <th>Ville</th>
                <th>Produit</th>
                <th>Besoin</th>
                <th>Attribué</th>
                <th>Reste</th>
                <th>Prix Unitaire (Ar)</th>
                <th>Valeur Totale (Ar)</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($villes as $ville): ?>
                <?php 
                // Filtrer les besoins de cette ville
                $besoinsVille = array_filter($besoins, function($b) use ($ville) {
                    return $b['id_ville'] == $ville['id'];
                });
                
                if (count($besoinsVille) > 0):
                    $premierBesoin = true;
                    foreach ($besoinsVille as $besoin):
                ?>
                <tr>
                    <?php if ($premierBesoin): ?>
                        <td rowspan="<?= count($besoinsVille) ?>" valign="top">
                            <strong><?= htmlspecialchars($ville['nom']) ?></strong>
                        </td>
                        <?php $premierBesoin = false; ?>
                    <?php endif; ?>
                    
                    <td><?= htmlspecialchars($besoin['nom']) ?></td>
                    <td align="center"><?= number_format($besoin['quantite'], 0, ',', ' ') ?></td>
                    <td align="center"><?= number_format($besoin['attribue'], 0, ',', ' ') ?></td>
                    <td align="center"><?= number_format($besoin['reste'], 0, ',', ' ') ?></td>
                    <td align="right"><?= number_format($besoin['prix_unitaire'], 0, ',', ' ') ?></td>
                    <td align="right"><?= number_format($besoin['quantite'] * $besoin['prix_unitaire'], 0, ',', ' ') ?></td>
                    <td align="center">
                        <!-- Statut sans couleur, juste du texte -->
                        <?php 
                        if ($besoin['attribue'] == 0) {
                            echo "❌ NON TRAITÉ";
                        } elseif ($besoin['attribue'] >= $besoin['quantite']) {
                            echo "✅ COMPLÉTÉ";
                        } else {
                            echo "⚠️ PARTIEL (" . round(($besoin['attribue'] / $besoin['quantite']) * 100) . "%)";
                        }
                        ?>
                    </td>
                </tr>
                <?php 
                    endforeach;
                else:
                ?>
                <!-- Ville sans besoin -->
                <tr>
                    <td><strong><?= htmlspecialchars($ville['nom']) ?></strong></td>
                    <td colspan="7" align="center"><i>Aucun besoin enregistré</i></td>
                </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>