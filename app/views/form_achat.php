<div class="main">

  <header class="topbar">
    <div class="topbar-title">Simulation <span>Achat</span></div>
    <div class="topbar-actions">
      <a href="/achats" class="btn btn-outline"><i class="fa-solid fa-rotate"></i> Actualiser</a>
      <a href="/dispatch" class="btn btn-primary"><i class="fa-solid fa-wand-magic-sparkles"></i> Dispatch</a>
      <div class="avatar">A</div>
    </div>
  </header>

  <div class="content" style="max-width: 1400px;">

    <!-- BREADCRUMB -->
    <div class="breadcrumb">
      <i class="fa-solid fa-house"></i>
      <span class="sep">/</span>
      <a href="/achats">Achats</a>
      <span class="sep">/</span>
      <span class="current">Simuler / Valider</span>
    </div>

    <!-- FLASH MESSAGES -->
    <?php if (!empty($flash['success'])): ?>
      <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i>
        <?= htmlspecialchars($flash['success']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>
    <?php if (!empty($flash['error'])): ?>
      <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
        <i class="fa-solid fa-triangle-exclamation me-2"></i>
        <?= htmlspecialchars($flash['error']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <form id="achat_form" method="POST" action="/achat/validate">

      <!-- LIGNE SUPÉRIEURE : Ville + Dons disponibles -->
      <div class="row g-4 mb-4">

        <!-- Ville -->
        <div class="col-md-6">
          <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
              <label class="form-label fw-semibold text-secondary text-uppercase small">
                <i class="fa-solid fa-city me-1 text-primary"></i> Ville acheteuse
              </label>
              <select name="id_ville" id="ville_select" class="form-select form-select-lg rounded-3" required>
                <option value="">— Choisir une ville —</option>
                <?php foreach ($villes as $v): ?>
                  <option value="<?= $v['id'] ?>"><?= htmlspecialchars($v['nom']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>

      <div style="margin-left:auto;">
        <label><strong>Dons en argent disponibles</strong></label>
        <div id="available_money" data-available="<?= $available_money ?>" style="font-size:1.1rem; font-weight:600;"><?= number_format($available_money, 0, '.', ' ') ?> Ar</div>
     
      </div>

      <!-- TABLEAU DES BESOINS -->
      <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
          <h5 class="fw-bold mb-1" style="font-family:'Syne',sans-serif;">
            <i class="fa-solid fa-list-check text-primary me-2"></i>Besoins disponibles
          </h5>
          <p class="text-muted small mb-3">Cochez les lignes à acheter / attribuer pour la ville sélectionnée.</p>
        </div>
        <div class="card-body p-4 pt-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th style="width:50px;" class="text-center"></th>
                  <th><i class="fa-solid fa-box text-muted me-1"></i>Produit</th>
                  <th><i class="fa-solid fa-scale-balanced text-muted me-1"></i>Quantité</th>
                  <th><i class="fa-solid fa-coins text-muted me-1"></i>Prix Unitaire (Ar)</th>
                  <th><i class="fa-solid fa-calculator text-muted me-1"></i>Montant (Ar)</th>
                </tr>
              </thead>
              <tbody id="besoins_tbody">
                <?php if (empty($besoins)): ?>
                  <tr>
                    <td colspan="5" class="text-center py-5">
                      <div class="text-muted">
                        <i class="fa-solid fa-inbox fa-3x mb-3 d-block"></i>
                        <p class="mb-0">Aucun besoin disponible.</p>
                      </div>
                    </td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($besoins as $b):
                    $montant = ((float)($b['prix_unitaire'] ?? 0)) * ((float)($b['quantite'] ?? 0));
                    $villeId = isset($b['id_ville']) ? $b['id_ville'] : '';
                  ?>
                    <tr data-ville="<?= $villeId ?>">
                      <td class="text-center">
                        <input type="checkbox"
                               name="besoin_ids[]"
                               class="form-check-input cb-besoin"
                               value="<?= $b['id'] ?>"
                               data-montant="<?= $montant ?>"
                               data-id="<?= $b['id'] ?>"
                               data-ville="<?= $villeId ?>"
                               style="width:1.2em;height:1.2em;cursor:pointer;"/>
                      </td>
                      <td><strong><?= htmlspecialchars($b['nom']) ?></strong></td>
                      <td><?= htmlspecialchars($b['quantite']) ?></td>
                      <td><?= number_format((float)($b['prix_unitaire'] ?? 0), 0, '.', ' ') ?></td>
                      <td class="montant-cell text-success fw-semibold">
                        <?= number_format($montant, 0, '.', ' ') ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- LIGNE INFÉRIEURE : Frais + Totaux + Boutons -->
      <div class="row g-4">

        <!-- Taux de frais -->
        <div class="col-md-4">
          <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
              <label class="form-label fw-semibold text-secondary text-uppercase small">
                <i class="fa-solid fa-percent me-1 text-warning"></i> Taux de frais
              </label>
              <div class="input-group input-group-lg">
                <input type="number"
                       id="fee_percent"
                       name="fee_percent"
                       class="form-control form-control-lg rounded-start-3 border-2"
                       value="10" min="0" max="100" step="0.1"/>
                <span class="input-group-text bg-warning text-dark fw-bold border-2 rounded-end-3">%</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Récapitulatif des montants -->
        <div class="col-md-5">
          <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
              <h6 class="fw-bold text-secondary text-uppercase small mb-3">
                <i class="fa-solid fa-receipt me-1"></i> Récapitulatif
              </h6>
              <div class="d-flex justify-content-between py-2 border-bottom">
                <span class="text-muted">Total sélectionné</span>
                <strong><span id="total_selected">0</span> Ar</strong>
              </div>
              <div class="d-flex justify-content-between py-2 border-bottom">
                <span class="text-muted">Frais estimés</span>
                <strong class="text-warning"><span id="fee_amount">0</span> Ar</strong>
              </div>
              <div class="d-flex justify-content-between py-2">
                <span class="fw-bold">Montant total à payer</span>
                <strong class="text-primary fs-5"><span id="net_needed">0</span> Ar</strong>
              </div>
            </div>
          </div>
        </div>

        <!-- Boutons d'action -->
        <div class="col-md-3">
          <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4 d-flex flex-column justify-content-between gap-3">
              <button type="button" id="btn_simuler"
                      class="btn btn-outline-primary btn-lg rounded-3 w-100">
                <i class="fa-solid fa-calculator me-2"></i> Simuler
              </button>
              <button type="submit" id="btn_valider"
                      class="btn btn-primary btn-lg rounded-3 w-100 shadow-sm">
                <i class="fa-solid fa-check me-2"></i> Valider
              </button>
              <a href="/dispatch"
                 class="btn btn-outline-secondary btn-lg rounded-3 w-100">
                <i class="fa-solid fa-xmark me-2"></i> Annuler
              </a>
            </div>
          </div>
        </div>

      </div><!-- /row boutons -->

      <!-- Résultat simulation -->
      <div id="simulation_result_wrap" class="mt-4" style="display:none;">
        <div id="simulation_result_alert" class="alert rounded-4 p-4 d-flex align-items-center gap-3 shadow-sm">
          <i id="simulation_icon" class="fa-solid fa-calculator fa-2x"></i>
          <div>
            <h6 class="fw-bold mb-1">Résultat de la simulation</h6>
            <p id="simulation_result" class="mb-0 fw-semibold"></p>
          </div>
        </div>
      </div>

    </form>

    <p class="text-muted small mt-3">
      <i class="fa-solid fa-circle-info me-1"></i>
      <strong>Simuler</strong> vérifie uniquement si les fonds sont suffisants.
      <strong>Valider</strong> envoie le formulaire au serveur pour créer la transaction.
    </p>

  </div><!-- /content -->

  <footer class="footer">
    BNGRC — Bureau National de Gestion des Risques et des Catastrophes &copy; <?= date('Y') ?>
  </footer>

</div><!-- /main -->

<script>
  window.AVAILABLE_MONEY = Number(<?= json_encode((int)$available_money) ?>) || 0;
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/form_achat.js"></script>