<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Saisir un Don — BNGRC</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css"/>
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
  <a href="/besoins"   class="nav-item"><i class="fa-solid fa-list-check"></i> Besoins</a>
  <a href="/dons"      class="nav-item active"><i class="fa-solid fa-hand-holding-heart"></i> Dons</a>
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
      <a href="/dons">Dons</a>
      <span class="sep">/</span>
      <span class="current">Saisir un don</span>
    </div>

    <!-- FORM CARD -->
    <div class="form-card">

      <div class="form-header">
        <i class="fa-solid fa-hand-holding-heart"></i>
        Saisir un Don reçu
      </div>

      <form action="/don/save" method="POST">
        <div class="form-grid">

          <!-- Type de don -->
          <div class="form-group">
            <label class="form-label">
              <i class="fa-solid fa-box"></i> Type de don
              <span class="required">*</span>
            </label>
            <?php if (!empty($products)): ?>
              <select name="nom" class="form-select" required>
                <option value="">— Sélectionner un type —</option>
                <?php foreach ($products as $p): ?>
                  <option value="<?= htmlspecialchars($p) ?>"><?= htmlspecialchars($p) ?></option>
                <?php endforeach; ?>
              </select>
            <?php else: ?>
              <input type="text" name="nom" class="form-input" required
                     placeholder="Ex: Riz (kg)"/>
              <small class="form-hint">Doit correspondre exactement au nom du besoin.</small>
            <?php endif; ?>
          </div>

          <!-- Date de réception -->
          <div class="form-group">
            <label class="form-label">
              <i class="fa-solid fa-calendar-day"></i> Date de réception
              <span class="required">*</span>
            </label>
            <input type="date" name="date_don" class="form-input"
                   value="<?= date('Y-m-d') ?>" required/>
          </div>

          <!-- Quantité / Montant (pleine largeur) -->
          <div class="form-group form-group-full">
            <label class="form-label">
              <i class="fa-solid fa-scale-balanced"></i> Quantité / Montant
              <span class="required">*</span>
            </label>
            <input type="number" name="quantite" class="form-input"
                   min="1" required placeholder="Ex: 200"/>
          </div>

        </div><!-- /form-grid -->

        <div class="form-actions">
          <a href="/dons" class="btn btn-outline">
            <i class="fa-solid fa-arrow-left"></i> Annuler
          </a>
          <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-floppy-disk"></i> Enregistrer le don et dispatcher
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