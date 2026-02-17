<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard — BNGRC</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css"/>
</head>
<body>

<!-- ════════ SIDEBAR ════════ -->
<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-icon">🛡️</div>
    <div>
      <div class="logo-text">BNGRC</div>
      <div class="logo-sub">Suivi des Dons</div>
    </div>
  </div>

  <div class="sidebar-section">Navigation</div>
  <a href="<?= BASE_URL ?>/dashboard" class="nav-item active"><i class="fa-solid fa-gauge-high"></i> Tableau de Bord</a>
  <a href="<?= BASE_URL ?>/villes"    class="nav-item"><i class="fa-solid fa-city"></i> Villes & Régions</a>
  <a href="<?= BASE_URL ?>/besoins"   class="nav-item"><i class="fa-solid fa-list-check"></i> Besoins</a>
  <a href="<?= BASE_URL ?>/dons"      class="nav-item"><i class="fa-solid fa-hand-holding-heart"></i> Dons</a>
  <a href="<?= BASE_URL ?>/dispatch"  class="nav-item"><i class="fa-solid fa-wand-magic-sparkles"></i> Formulaire d'achat</a>

  <div class="sidebar-section">Administration</div>
  <a href="/produits"  class="nav-item"><i class="fa-solid fa-tags"></i> Catalogue Produits</a>

  <div class="sidebar-footer">BNGRC Madagascar &copy; <?= date('Y') ?></div>
</aside>

<!-- ════════ MAIN ════════ -->
<div class="main">

        <header class="topbar">
            <div class="topbar-title">Tableau de <span>Bord</span></div>
            <div class="topbar-actions">
                <a href="<?= BASE_URL ?>/Dashboard" class="btn btn-outline"><i class="fa-solid fa-rotate"></i> Actualiser</a>
                <a href="<?= BASE_URL ?>/dispatch/auto-proportional" class="btn btn-primary"><i class="fa-solid fa-wand-magic-sparkles"></i> Dispatch</a>
                <a href="<?= BASE_URL ?>/reset" class="btn btn-outline"><i class="fa-solid fa-rotate"></i> Reset</a>
                <div class="avatar">A</div>
            </div>
        </header>

  <div class="content">

    <!-- BREADCRUMB -->
    <div class="breadcrumb">
      <i class="fa-solid fa-house"></i>
      <span class="sep">/</span>
      <span class="current">Tableau de Bord</span>
    </div>

    <!-- ════ STATISTIQUES ════ -->
    <div class="stats-grid">
      <div class="stat-card blue">
        <div class="stat-label">Total Villes</div>
        <div class="stat-value"><?= count($villes) ?></div>
        <div class="stat-sub">Villes enregistrées</div>
        <i class="fa-solid fa-city stat-icon"></i>
      </div>
      <div class="stat-card green">
        <div class="stat-label">Total Besoins</div>
        <div class="stat-value"><?= count($besoins) ?></div>
        <div class="stat-sub">Lignes de besoins</div>
        <i class="fa-solid fa-list-check stat-icon"></i>
      </div>
    </div>

    <!-- ════ TABLEAU DÉTAIL ════ -->
    <div class="section-header">
      <div class="section-title">
        <i class="fa-solid fa-table-list"></i> Détail des besoins par ville
      </div>
      <div class="filter-bar">
        <input id="searchInput" class="filter-input" type="text" placeholder="🔍 Rechercher un produit…"/>
        <select id="statusFilter" class="filter-select">
          <option value="">Tous les statuts</option>
          <option value="complete">✅ Complété</option>
          <option value="partiel">⚠ Partiel</option>
          <option value="nontraite">❌ Non traité</option>
        </select>
      </div>
    </div>

    <div class="detail-table-wrap">
      <table id="detailTable">
        <thead>
          <tr>
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
      // Filtrer et regrouper les besoins de cette ville par produit (éviter doublons)
      $raw = array_filter($besoins, function($b) use ($ville) {
        return $b['id_ville'] == $ville['id'];
      });

      // Regroupement par nom de produit (clé normalisée)
      $grouped = [];
      foreach ($raw as $b) {
        $key = strtolower(trim($b['nom']));
        if ($key === '') continue;
        $qty = isset($b['quantite']) ? (int)$b['quantite'] : 0;
        $attrib = isset($b['attribue']) ? (int)$b['attribue'] : 0;
        $pu = isset($b['prix_unitaire']) ? (float)$b['prix_unitaire'] : 0.0;

        if (!isset($grouped[$key])) {
          $grouped[$key] = [
            'nom' => $b['nom'],
            'quantite' => $qty,
            'attribue' => $attrib,
            'prix_unitaire' => $pu,
            'total_value' => $pu * $qty,
          ];
        } else {
          // sommer quantités et attributions, mettre à jour valeur totale pour recalculer PU
          $grouped[$key]['quantite'] += $qty;
          $grouped[$key]['attribue'] += $attrib;
          $grouped[$key]['total_value'] += ($pu * $qty);
          // prix unitaire pondéré
          $gqty = $grouped[$key]['quantite'];
          $grouped[$key]['prix_unitaire'] = $gqty > 0 ? ($grouped[$key]['total_value'] / $gqty) : $pu;
        }
      }

      $besoinsVille = array_values($grouped);
      // Calculer le "reste" pour chaque produit regroupé (quantité à couvrir)
      foreach ($besoinsVille as &$g) {
        $g['attribue'] = isset($g['attribue']) ? (int)$g['attribue'] : 0;
        $g['quantite'] = isset($g['quantite']) ? (int)$g['quantite'] : 0;
        $g['reste'] = max(0, $g['quantite'] - $g['attribue']);
        $g['prix_unitaire'] = isset($g['prix_unitaire']) ? (float)$g['prix_unitaire'] : 0.0;
      }
      unset($g);

      if (count($besoinsVille) > 0):
        $premierBesoin = true;
        foreach ($besoinsVille as $besoin):

                  if ($besoin['attribue'] == 0) {
                      $statutKey   = 'nontraite';
                      $statutBadge = '<span class="badge badge-red"><i class="fa-solid fa-circle-xmark"></i>NON TRAITÉ</span>';
                      $numCls      = 'num-red';
                  } elseif ($besoin['attribue'] >= $besoin['quantite']) {
                      $statutKey   = 'complete';
                      $statutBadge = '<span class="badge badge-green"><i class="fa-solid fa-circle-check"></i>COMPLÉTÉ</span>';
                      $numCls      = 'num-green';
                  } else {
                      $statutKey   = 'partiel';
                      $pct         = round(($besoin['attribue'] / $besoin['quantite']) * 100);
                      $statutBadge = '<span class="badge badge-yellow"><i class="fa-solid fa-triangle-exclamation"></i>PARTIEL (' . $pct . '%)</span>';
                      $numCls      = 'num-yellow';
                  }
            ?>
            <tr class="item-row"
                data-ville="<?= $ville['id'] ?>"
                data-produit="<?= htmlspecialchars(strtolower($besoin['nom'])) ?>"
                data-statut="<?= $statutKey ?>">

              <?php if ($premierBesoin): ?>
              <td rowspan="<?= count($besoinsVille) ?>" valign="top">
                <strong><?= htmlspecialchars($ville['nom']) ?></strong>
              </td>
              <?php $premierBesoin = false; ?>
              <?php endif; ?>

              <td><strong><?= htmlspecialchars($besoin['nom']) ?></strong></td>
              <td class="num"><?= number_format($besoin['quantite'], 0, ',', ' ') ?></td>
              <td class="num <?= $numCls ?>"><?= number_format($besoin['attribue'], 0, ',', ' ') ?></td>
              <td class="num <?= $besoin['reste'] > 0 ? $numCls : 'num-muted' ?>"><?= number_format($besoin['reste'], 0, ',', ' ') ?></td>
              <td class="num"><?= number_format($besoin['prix_unitaire'], 0, ',', ' ') ?></td>
              <td class="num"><?= number_format($besoin['quantite'] * $besoin['prix_unitaire'], 0, ',', ' ') ?></td>
              <td><?= $statutBadge ?></td>
            </tr>
            <?php
                endforeach;
            else:
            ?>
            <tr class="item-row" data-ville="<?= $ville['id'] ?>" data-produit="" data-statut="">
              <td><strong><?= htmlspecialchars($ville['nom']) ?></strong></td>
              <td colspan="7" class="empty-row">
                <i class="fa-solid fa-circle-info"></i> Aucun besoin enregistré
              </td>
            </tr>
            <?php endif; ?>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  </div><!-- /content -->

  <footer class="footer">
    BNGRC — Bureau National de Gestion des Risques et des Catastrophes &copy; <?= date('Y') ?>
  </footer>

</div><!-- /main -->

<script src="<?= BASE_URL ?>/assets/js/app.js"></script>
</body>
</html>