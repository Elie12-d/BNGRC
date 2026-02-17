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

<script src="<?= BASE_URL ?>/assets/js/app.js"></script>