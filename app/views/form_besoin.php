
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
        if (quantiteInput){ quantiteInput.value = 1; quantiteInput.readOnly = true; }
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