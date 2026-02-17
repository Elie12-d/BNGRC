<div class="main">
  <div class="content">
    <div class="form-card form-card--wide" style="margin:24px auto;">
      <h1 style="margin-bottom:12px;">Formulaire d'achat / attribution</h1>

      <?php
      // display flash messages passed from controller in $flash (already read from session)
      if (!empty($flash['success'])): ?>
        <div style="padding:10px;margin-bottom:12px;background:#e6f9ec;border:1px solid #bde9c8;color:#064;">
          <?= htmlspecialchars($flash['success']) ?>
        </div>
      <?php endif;
      if (!empty($flash['error'])): ?>
        <div style="padding:10px;margin-bottom:12px;background:#fdecea;border:1px solid #f5c2c2;color:#900;">
          <?= htmlspecialchars($flash['error']) ?>
        </div>
      <?php endif; ?>
      <!-- Debug panel removed (server-side logging only) -->

      <form id="achat_form" method="POST" action="/achat/validate">
    <div style="display:flex;gap:24px;align-items:center;margin-bottom:16px;">
      <div>
        <label><strong>Ville acheteuse</strong></label>
        <select name="id_ville" id="ville_select" class="form-select" required>
          <option value="">— Choisir une ville —</option>
          <?php foreach ($villes as $v): ?>
            <option value="<?= $v['id'] ?>"><?= htmlspecialchars($v['nom']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div style="margin-left:auto;">
        <label><strong>Dons en argent disponibles</strong></label>
        <div id="available_money" data-available="<?= $available_money ?>" style="font-size:1.1rem; font-weight:600;"><?= number_format($available_money, 0, '.', ' ') ?> Ar</div>
     
      </div>
    </div>

    <h2>Besoins disponibles</h2>
    <p>Choisissez les lignes à acheter / attribuer pour la ville sélectionnée.</p>

    <div class="table-responsive" style="margin:16px 0 20px; padding:8px; background:transparent;">
      <table class="table" style="width:100%;border-collapse:collapse;margin-bottom:12px;">
      <thead>
        <tr>
          <th style="width:40px"></th>
          <th>Produit</th>
          <th>Quantité</th>
          <th>Prix Unitaire (Ar)</th>
          <th>Montant (Ar)</th>
        </tr>
      </thead>
      <tbody id="besoins_tbody">
        <?php if (empty($besoins)): ?>
          <tr><td colspan="5">Aucun besoin disponible.</td></tr>
        <?php else: ?>
          <?php foreach ($besoins as $b):
            $montant = ((float)($b['prix_unitaire'] ?? 0)) * ((float)($b['quantite'] ?? 0));
            $villeId = isset($b['id_ville']) ? $b['id_ville'] : '';
          ?>
            <tr data-ville="<?= $villeId ?>">
              <td style="text-align:center;">
                <input type="checkbox" name="besoin_ids[]" class="cb-besoin" value="<?= $b['id'] ?>" data-montant="<?= $montant ?>" data-id="<?= $b['id'] ?>" data-ville="<?= $villeId ?>" />
              </td>
              <td><?= htmlspecialchars($b['nom']) ?></td>
              <td><?= htmlspecialchars($b['quantite']) ?></td>
              <td><?= number_format((float)($b['prix_unitaire'] ?? 0), 0, '.', ' ') ?></td>
              <td class="montant-cell"><?= number_format($montant, 0, '.', ' ') ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
      </table>
    </div>

    <div style="display:flex;gap:16px;align-items:center;margin-bottom:16px;">
      <div>
        <label><strong>Taux de frais (%)</strong></label>
        <input type="number" id="fee_percent" name="fee_percent" class="form-input" value="10" min="0" max="100" step="0.1" />
      </div>

      <div style="margin-left:auto; text-align:right;">
        <div>Total sélectionné : <span id="total_selected">0</span> Ar</div>
        <div>Frais estimés : <span id="fee_amount">0</span> Ar</div>
        <div style="font-weight:700;">Montant à payer (total + frais) : <span id="net_needed">0</span> Ar</div>
      </div>
    </div>

    <div id="simulation_result" style="margin-bottom:12px;font-weight:600;color:#333"></div>

    <div style="display:flex;gap:12px;">
      <button type="button" id="btn_simuler" class="btn btn-outline"><i class="fa-solid fa-calculator"></i> Simuler</button>
      <button type="submit" id="btn_valider" class="btn btn-primary"><i class="fa-solid fa-check"></i> Valider</button>
      <a href="/dispatch" class="btn btn-outline">Annuler</a>
    </div>

      </form>
      <p style="margin-top:12px;font-size:0.9rem;color:#666">Remarque : "Simuler" vérifie seulement si les fonds sont suffisants et affiche un message; "Valider" enverra le formulaire au serveur pour création de la transaction (doit être implémentée côté serveur).</p>
    </div>
  </div>
</div>
<script>
  window.AVAILABLE_MONEY = Number(<?= json_encode((int)$available_money) ?>) || 0;
</script>
<script src="<?= BASE_URL ?>/assets/js/form_achat.js"></script>