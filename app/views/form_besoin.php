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
  <style>
    /* Conteneur central élargi */
    .content {
      max-width: 95%;
      width: 80%;
      margin: 0 auto;
    }
  </style>
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
  <a href="/villes" class="nav-item"><i class="fa-solid fa-city"></i> Villes & Régions</a>
  <a href="/besoins" class="nav-item active"><i class="fa-solid fa-list-check"></i> Besoins</a>
  <a href="/dons" class="nav-item"><i class="fa-solid fa-hand-holding-heart"></i> Dons</a>
  <a href="/dispatch" class="nav-item"><i class="fa-solid fa-wand-magic-sparkles"></i> Simulation Dispatch</a>

  <div class="sidebar-section">Administration</div>
  <a href="/produits" class="nav-item"><i class="fa-solid fa-tags"></i> Catalogue Produits</a>

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
            <div class="col-md-6">
              <label class="form-label fw-semibold text-secondary">
                <i class="fa-solid fa-box"></i> Type / Nature du besoin
                <span class="text-danger">*</span>
              </label>
              <select name="nature" id="nature_select" class="form-select form-select-lg rounded-3 border-2" required>
                <option value="">— Sélectionner la nature —</option>
                <option value="en_nature">En nature</option>
                <option value="en_materiaux">En matériaux</option>
                <option value="en_argent">En argent</option>
              </select>
            </div>

            <!-- Champ dépendant EN NATURE -->
            <div class="form-group mt-3" id="field_en_nature" style="display:none;">
              <label class="form-label"><i class="fa-solid fa-seedling"></i> Produit (nature)</label>
              <select id="nom_en_nature_select" class="form-select mb-2">
                <option value="">— Sélectionner un produit —</option>
                <?php foreach ($products as $p): ?>
                  <option value="<?= htmlspecialchars($p) ?>"><?= htmlspecialchars($p) ?></option>
                <?php endforeach; ?>
              </select>
              <input type="text" id="nom_en_nature_free" class="form-control" placeholder="Ou saisir un produit personnalisé (ex: Riz local)" />
              <input type="hidden" name="nom" id="nom_en_nature_final" />
            </div>

            <!-- Champ dépendant EN MATERIAUX -->
            <div class="form-group mt-3" id="field_en_materiaux" style="display:none;">
              <label class="form-label"><i class="fa-solid fa-hammer"></i> Matériel / Matériaux</label>
              <select id="nom_en_materiaux_select" class="form-select mb-2">
                <option value="">— Sélectionner un matériel —</option>
                <?php foreach ($products as $p): ?>
                  <option value="<?= htmlspecialchars($p) ?>"><?= htmlspecialchars($p) ?></option>
                <?php endforeach; ?>
              </select>
              <input type="text" id="nom_en_materiaux_free" class="form-control" placeholder="Ou saisir un matériel personnalisé (ex: Tôle galvanisée)" />
              <input type="hidden" name="nom" id="nom_en_materiaux_final" />
            </div>

            <!-- Champ EN ARGENT -->
            <div class="form-group mt-3" id="field_en_argent" style="display:none;">
              <label class="form-label"><i class="fa-solid fa-money-bill-wave"></i> Montant demandé (Ar)</label>
              <input type="number" step="0.01" name="prix_unitaire" id="montant_argent" class="form-control" placeholder="Ex: 150000" />
              <small class="form-text text-muted">Pour une demande en argent, indiquez le montant total (Ar). La quantité sera enregistrée comme 1.</small>
              <input type="hidden" name="nom" id="nom_argent" value="Argent" />
            </div>

            <!-- Quantité -->
            <div class="col-md-6">
              <label class="form-label fw-semibold text-secondary">
                <i class="fa-solid fa-scale-balanced me-1 text-primary"></i> Quantité
                <span class="text-danger">*</span>
              </label>
              <input type="number" name="quantite" class="form-control form-control-lg rounded-3 border-2" min="1" required placeholder="Ex: 500"/>
            </div>

            <!-- Prix Unitaire -->
            <div class="col-md-6">
              <label class="form-label fw-semibold text-secondary">
                <i class="fa-solid fa-coins me-1 text-primary"></i> Prix Unitaire (Ar)
                <span class="text-danger">*</span>
              </label>
              <input type="number" step="0.01" name="prix_unitaire" class="form-control form-control-lg rounded-3 border-2" required placeholder="Ex: 3000"/>
              <div class="form-text text-muted">
                <i class="fa-solid fa-circle-info me-1"></i> Le prix unitaire ne changera pas une fois enregistré.
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

<!-- JS pour synchroniser select / saisie libre -->
<script>
(function(){
  const nature = document.getElementById('nature_select');

  const fieldNature = document.getElementById('field_en_nature');
  const fieldMat = document.getElementById('field_en_materiaux');
  const fieldArg = document.getElementById('field_en_argent');

  const quantiteInput = document.querySelector('input[name="quantite"]');

  const natureSelect = document.getElementById('nom_en_nature_select');
  const natureFree = document.getElementById('nom_en_nature_free');
  const natureFinal = document.getElementById('nom_en_nature_final');

  const matSelect = document.getElementById('nom_en_materiaux_select');
  const matFree = document.getElementById('nom_en_materiaux_free');
  const matFinal = document.getElementById('nom_en_materiaux_final');

  function resetFields(){
    [fieldNature, fieldMat, fieldArg].forEach(f => { if(f) f.style.display='none'; });
    if(natureFinal) natureFinal.value = '';
    if(matFinal) matFinal.value = '';
  }

  function syncNature(){ if(natureFinal) natureFinal.value = natureFree.value || natureSelect.value; }
  function syncMat(){ if(matFinal) matFinal.value = matFree.value || matSelect.value; }

  function onChange(){
    resetFields();
    const v = nature.value;
    if(v==='en_nature'){ fieldNature.style.display=''; if(quantiteInput) quantiteInput.disabled=false; }
    if(v==='en_materiaux'){ fieldMat.style.display=''; if(quantiteInput) quantiteInput.disabled=false; }
    if(v==='en_argent'){ fieldArg.style.display=''; if(quantiteInput){ quantiteInput.value=1; quantiteInput.disabled=true; } }
  }

  if(natureSelect) natureSelect.addEventListener('change', syncNature);
  if(natureFree) natureFree.addEventListener('input', syncNature);
  if(matSelect) matSelect.addEventListener('change', syncMat);
  if(matFree) matFree.addEventListener('input', syncMat);
  if(nature) nature.addEventListener('change', onChange);

  onChange();
})();
</script>

<script src="<?= BASE_URL ?>/assets/js/app.js"></script>
<!-- <script src="<?= BASE_URL ?>/assets/js/form_besoin.js"></script> -->
</body>
</html>
