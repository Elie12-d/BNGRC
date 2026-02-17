<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Saisir un Besoin — BNGRC</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
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
    <div class="card border-0 shadow-sm rounded-4">

      <div class="card-header bg-primary text-white rounded-top-4 py-3 px-4">
        <h5 class="mb-0 fw-bold">
          <i class="fa-solid fa-plus me-2"></i>
          Saisir un besoin par Ville
        </h5>
      </div>

      <div class="card-body p-4">
        <form action="/besoin/save" method="POST">
          <div class="row g-4">

            <!-- Ville -->
            <div class="col-md-6">
              <label class="form-label fw-semibold text-secondary">
                <i class="fa-solid fa-city me-1 text-primary"></i> Ville
                <span class="text-danger">*</span>
              </label>
              <select name="id_ville" class="form-select form-select-lg rounded-3 border-2" required>
                <option value="">— Sélectionner une ville —</option>
                <?php foreach($villes as $v): ?>
                  <option value="<?= $v['id'] ?>"><?= $v['nom'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>

          <!-- Nature du besoin -->
          <div class="form-group">
            <label class="form-label">
              <i class="fa-solid fa-box"></i> Type / Nature du besoin
              <span class="required">*</span>
            </label>
            <select name="nature" id="nature_select" class="form-select" required>
              <option value="">— Sélectionner la nature —</option>
              <option value="en_nature">En nature</option>
              <option value="en_materiaux">En matériaux</option>
              <option value="en_argent">En argent</option>
            </select>
          </div>

          <!-- Champ dépendant de la nature -->
          <div class="form-group" id="field_en_nature" style="display:none;">
            <label class="form-label">
              <i class="fa-solid fa-seedling"></i> Produit (nature)
              <span class="required">*</span>
            </label>
            <?php if (!empty($products)): ?>
              <select name="nom" id="nom_en_nature" class="form-select">
                <option value="">— Sélectionner un produit (ex: Riz, Huile) —</option>
                <?php foreach ($products as $p):
                  // crude heuristic: treat items that look like food as "nature" by default
                  $lower = mb_strtolower($p, 'UTF-8');
                  $is_nature = preg_match('/riz|huile|sucre|lait|mais|farine|biscuit|savon|eau|moustiquaire|vêtements|pull|couverture|medicament|médicament/', $lower);
                  if ($is_nature): ?>
                    <option value="<?= htmlspecialchars($p) ?>"><?= htmlspecialchars($p) ?></option>
                <?php endif; endforeach; ?>
              </select>
            <?php else: ?>
              <input type="text" name="nom" id="nom_en_nature" class="form-input"
                     placeholder="Ex: Riz, Huile" />
            <?php endif; ?>
          </div>

          <div class="form-group" id="field_en_materiaux" style="display:none;">
            <label class="form-label">
              <i class="fa-solid fa-hammer"></i> Matériel / Matériaux
              <span class="required">*</span>
            </label>
            <?php if (!empty($products)): ?>
              <select name="nom" id="nom_en_materiaux" class="form-select">
                <option value="">— Sélectionner un matériel (ex: Tôle, Clou) —</option>
                <?php foreach ($products as $p):
                  $lower = mb_strtolower($p, 'UTF-8');
                  $is_mat = preg_match('/t[oô]le|clou|b[aâ]che|ciment|clou|tôle|clou|tube|plaque/', $lower);
                  if ($is_mat): ?>
                    <option value="<?= htmlspecialchars($p) ?>"><?= htmlspecialchars($p) ?></option>
                <?php endif; endforeach; ?>
              </select>
            <?php else: ?>
              <input type="text" name="nom" id="nom_en_materiaux" class="form-input"
                     placeholder="Ex: Tôle, Clou" />
            <?php endif; ?>
          </div>

          <div class="form-group" id="field_en_argent" style="display:none;">
            <label class="form-label">
              <i class="fa-solid fa-money-bill-wave"></i> Montant demandé (Ar)
              <span class="required">*</span>
            </label>
            <input type="number" step="0.01" name="prix_unitaire" id="montant_argent" class="form-input"
                   placeholder="Ex: 150000" />
            <small class="form-hint">Pour une demande en argent, indiquez le montant total (Ar). La quantité sera enregistrée comme 1.</small>
            <!-- hidden field to ensure nom is set to 'Argent' on submit -->
            <input type="hidden" name="nom" id="nom_argent" value="Argent" />
          </div>

            <!-- Quantité -->
            <div class="col-md-6">
              <label class="form-label fw-semibold text-secondary">
                <i class="fa-solid fa-scale-balanced me-1 text-primary"></i> Quantité
                <span class="text-danger">*</span>
              </label>
              <input type="number" name="quantite" class="form-control form-control-lg rounded-3 border-2"
                     min="1" required placeholder="Ex: 500"/>
            </div>

            <!-- Prix Unitaire -->
            <div class="col-md-6">
              <label class="form-label fw-semibold text-secondary">
                <i class="fa-solid fa-coins me-1 text-primary"></i> Prix Unitaire (Ar)
                <span class="text-danger">*</span>
              </label>
              <input type="number" step="0.01" name="prix_unitaire"
                     class="form-control form-control-lg rounded-3 border-2"
                     required placeholder="Ex: 3000"/>
              <div class="form-text text-muted">
                <i class="fa-solid fa-circle-info me-1"></i>
                Le prix unitaire ne changera pas une fois enregistré.
              </div>
            </div>

          </div><!-- /row -->

          <hr class="my-4 text-muted opacity-25"/>

          <div class="d-flex justify-content-end gap-2">
            <a href="/besoins" class="btn btn-outline-secondary btn-lg rounded-pill px-4">
              <i class="fa-solid fa-arrow-left me-2"></i> Annuler
            </a>
            <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4 shadow-sm">
              <i class="fa-solid fa-floppy-disk me-2"></i> Enregistrer le besoin
            </button>
          </div>

        </form>
      </div>
    </div>

  </div><!-- /content -->

  <footer class="footer">
    BNGRC — Bureau National de Gestion des Risques et des Catastrophes &copy; <?= date('Y') ?>
  </footer>

</div><!-- /main -->

<script src="/js/app.js"></script>
<script>
  (function(){
    const nature = document.getElementById('nature_select');
    if (!nature) return;

    const fieldNature = document.getElementById('field_en_nature');
    const fieldMat = document.getElementById('field_en_materiaux');
    const fieldArg = document.getElementById('field_en_argent');

    const nomNature = document.getElementById('nom_en_nature');
    const nomMat = document.getElementById('nom_en_materiaux');
    const montantArg = document.getElementById('montant_argent');
    const nomArgentHidden = document.getElementById('nom_argent');
    const quantiteInput = document.querySelector('input[name="quantite"]');

    function resetFields(){
      // hide all
      [fieldNature, fieldMat, fieldArg].forEach(f => { if (f) f.style.display = 'none'; });
      // remove required attrs
      if (nomNature) nomNature.required = false;
      if (nomMat) nomMat.required = false;
      if (montantArg) montantArg.required = false;
      // restore nom hidden value to empty except argent
      if (nomArgentHidden) nomArgentHidden.disabled = true;
    }

    function onChange(){
      resetFields();
      const v = nature.value;
      if (v === 'en_nature'){
        if (fieldNature) fieldNature.style.display = '';
        if (nomNature) nomNature.required = true;
        if (quantiteInput) quantiteInput.disabled = false;
      } else if (v === 'en_materiaux'){
        if (fieldMat) fieldMat.style.display = '';
        if (nomMat) nomMat.required = true;
        if (quantiteInput) quantiteInput.disabled = false;
      } else if (v === 'en_argent'){
        if (fieldArg) fieldArg.style.display = '';
        if (montantArg) montantArg.required = true;
        if (nomArgentHidden) { nomArgentHidden.disabled = false; }
        // for argent, set quantity to 1 unless user wants otherwise
        if (quantiteInput){ quantiteInput.value = 1; }
      } else {
        if (quantiteInput){ quantiteInput.readOnly = false; }
      }
    }

    nature.addEventListener('change', onChange);
    // initialize on load
    onChange();
  })();
</script>
</body>
</html>
<script src="<?= BASE_URL ?>/assets/js/app.js"></script>
</body>
</html>