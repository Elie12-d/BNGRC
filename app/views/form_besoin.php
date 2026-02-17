
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

<script src="<?= BASE_URL ?>/assets/js/app.js"></script>