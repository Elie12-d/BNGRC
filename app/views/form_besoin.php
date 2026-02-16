<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Saisir un Besoin — BNGRC</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="/css/style.css"/>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-icon">🛡️</div>
    <div>
      <div class="logo-text">BNGRC</div>
      <div class="logo-sub">Suivi des Dons</div>
    </div>
  </div>

  <div class="sidebar-section">Navigation</div>
  <a href="/dashboard" class="nav-item"><i class="fa-solid fa-gauge-high"></i> Tableau de Bord</a>
  <a href="/villes"    class="nav-item"><i class="fa-solid fa-city"></i> Villes & Régions</a>
  <a href="/besoins"   class="nav-item active"><i class="fa-solid fa-list-check"></i> Besoins</a>
  <a href="/dons"      class="nav-item"><i class="fa-solid fa-hand-holding-heart"></i> Dons</a>
  <a href="/dispatch"  class="nav-item"><i class="fa-solid fa-wand-magic-sparkles"></i> Simulation Dispatch</a>

  <div class="sidebar-section">Administration</div>
  <a href="/produits"  class="nav-item"><i class="fa-solid fa-tags"></i> Catalogue Produits</a>

  <div class="sidebar-footer">BNGRC Madagascar &copy; <?= date('Y') ?></div>
</aside>

<!-- MAIN -->
<div class="main">

  <header class="topbar">
    <div class="topbar-title">Tableau de <span>Bord</span></div>
    <div class="topbar-actions">
      <a href="/dashboard" class="btn btn-outline"><i class="fa-solid fa-rotate"></i> Actualiser</a>
      <a href="/dispatch"  class="btn btn-primary"><i class="fa-solid fa-wand-magic-sparkles"></i> Dispatch</a>
      <div class="avatar">A</div>
    </div>
  </header>

  <div class="content">

    <!-- BREADCRUMB -->
    <div class="breadcrumb">
      <i class="fa-solid fa-house"></i>
      <span class="sep">/</span>
      <a href="/besoins">Besoins</a>
      <span class="sep">/</span>
      <span class="current">Saisir un besoin</span>
    </div>

    <!-- FORM CARD -->
    <div class="form-card">

      <div class="form-header">
        <i class="fa-solid fa-plus"></i>
        Saisir un besoin par Ville
      </div>

      <form action="/besoin/save" method="POST">
        <div class="form-grid">

          <!-- Ville -->
          <div class="form-group">
            <label class="form-label">
              <i class="fa-solid fa-city"></i> Ville
              <span class="required">*</span>
            </label>
            <select name="id_ville" class="form-select" required>
              <option value="">— Sélectionner une ville —</option>
              <?php foreach($villes as $v): ?>
                <option value="<?= $v['id'] ?>"><?= $v['nom'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Nature du besoin -->
          <div class="form-group">
            <label class="form-label">
              <i class="fa-solid fa-box"></i> Nature du besoin
              <span class="required">*</span>
            </label>
            <?php if (!empty($products)): ?>
              <select name="nom" class="form-select" required>
                <option value="">— Sélectionner un produit —</option>
                <?php foreach ($products as $p): ?>
                  <option value="<?= htmlspecialchars($p) ?>"><?= htmlspecialchars($p) ?></option>
                <?php endforeach; ?>
              </select>
            <?php else: ?>
              <input type="text" name="nom" class="form-input" required
                     placeholder="Ex: Riz, Tôle, Ciment"/>
            <?php endif; ?>
          </div>

          <!-- Quantité -->
          <div class="form-group">
            <label class="form-label">
              <i class="fa-solid fa-scale-balanced"></i> Quantité
              <span class="required">*</span>
            </label>
            <input type="number" name="quantite" class="form-input"
                   min="1" required placeholder="Ex: 500"/>
          </div>

          <!-- Prix Unitaire -->
          <div class="form-group">
            <label class="form-label">
              <i class="fa-solid fa-coins"></i> Prix Unitaire (Ar)
              <span class="required">*</span>
            </label>
            <input type="number" step="0.01" name="prix_unitaire" class="form-input"
                   required placeholder="Ex: 3000"/>
            <small class="form-hint">Le prix unitaire ne changera pas une fois enregistré.</small>
          </div>

        </div><!-- /form-grid -->

        <div class="form-actions">
          <a href="/besoins" class="btn btn-outline">
            <i class="fa-solid fa-arrow-left"></i> Annuler
          </a>
          <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-floppy-disk"></i> Enregistrer le besoin
          </button>
        </div>

      </form>
    </div><!-- /form-card -->

  </div><!-- /content -->

  <footer class="footer">
    BNGRC — Bureau National de Gestion des Risques et des Catastrophes &copy; <?= date('Y') ?>
  </footer>

</div><!-- /main -->

<script src="/js/app.js"></script>
</body>
</html>