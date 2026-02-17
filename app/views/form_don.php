<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Saisir un Don — BNGRC</title>
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

    <!-- SPLIT LAYOUT -->
    <div class="row g-0 shadow-sm rounded-4 overflow-hidden">

      <!-- PANNEAU GAUCHE : infos visuelles -->
      <div class="col-lg-4 bg-primary d-flex flex-column justify-content-between p-5 text-white">
        <div>
          <div class="bg-white bg-opacity-25 rounded-3 d-inline-flex p-3 mb-4">
            <i class="fa-solid fa-hand-holding-heart fa-2x"></i>
          </div>
          <h2 class="fw-bold" style="font-family: 'Syne', sans-serif; font-size: 2rem;">
            Enregistrer<br/>un Don
          </h2>
          <p class="text-white-50 mt-3 mb-0">
            Chaque don compte. Saisissez les informations ci-contre pour enregistrer et dispatcher automatiquement ce don aux besoins identifiés.
          </p>
        </div>

        <div class="mt-5">
          <div class="d-flex align-items-center gap-3 mb-3 bg-white bg-opacity-10 rounded-3 p-3">
            <i class="fa-solid fa-bolt text-warning"></i>
            <small class="fw-semibold">Dispatch automatique après enregistrement</small>
          </div>
          <div class="d-flex align-items-center gap-3 bg-white bg-opacity-10 rounded-3 p-3">
            <i class="fa-solid fa-shield-halved text-success"></i>
            <small class="fw-semibold">Données sécurisées et traçables</small>
          </div>
        </div>
      </div>

      <!-- PANNEAU DROIT : formulaire -->
      <div class="col-lg-8 bg-white p-5">

        <h5 class="fw-bold text-dark mb-1" style="font-family: 'Syne', sans-serif;">
          Informations du don
        </h5>
        <p class="text-muted small mb-4">Remplissez tous les champs obligatoires marqués <span class="text-danger">*</span></p>

        <form action="/don/save" method="POST">
          <div class="row g-4">

            <!-- Type de don -->
             <!-- Nature du don -->
<div class="col-12">
  <label class="form-label text-muted fw-semibold small text-uppercase">
    <i class="fa-solid fa-box me-1"></i> Nature du don <span class="text-danger">*</span>
  </label>

  <select name="nature" id="nature_select"
          class="form-select form-select-lg border-0 border-bottom rounded-0"
          style="border-bottom: 2px solid #dee2e6 !important; background-color: #f8f9fa;"
          required>
    <option value="">— Sélectionner la nature —</option>
    <option value="en_nature">En nature</option>
    <option value="en_materiaux">En matériaux</option>
    <option value="en_argent">En argent</option>
  </select>
</div>

<!-- Produit (saisie libre uniquement) -->
<div class="col-12" id="field_produit" style="display:none;">
  <label class="form-label text-muted fw-semibold small text-uppercase">
    <i class="fa-solid fa-tag me-1"></i> Produit du don <span class="text-danger">*</span>
  </label>

  <input type="text" id="nom_input"
         class="form-control form-control-lg border-0 border-bottom rounded-0"
         style="border-bottom: 2px solid #dee2e6 !important; background-color: #f8f9fa;"
         placeholder="Ex: Riz, Eau, Tôle, etc."/>

  <input type="hidden" name="nom" id="nom_final">

  <div class="form-text text-muted mt-2">
    Le nom doit correspondre exactement au besoin pour permettre le dispatch automatique.
  </div>
</div>

<!-- Message si argent -->
<div class="col-12" id="field_argent" style="display:none;">
  <div class="alert alert-info">
    <i class="fa-solid fa-circle-info me-2"></i>
    <strong>Don en argent :</strong> le produit sera automatiquement défini à <strong>"Argent"</strong>.
  </div>
</div>


            <!-- Date de réception -->
            <div class="col-md-6">
              <label class="form-label text-muted fw-semibold small text-uppercase">
                <i class="fa-solid fa-calendar-day me-1"></i> Date de réception <span class="text-danger">*</span>
              </label>
              <input type="date" name="date_don"
                     class="form-control form-control-lg border-0 border-bottom rounded-0"
                     style="border-bottom: 2px solid #dee2e6 !important; background-color: #f8f9fa;"
                     value="<?= date('Y-m-d') ?>" required/>
            </div>

            <!-- Quantité / Montant -->
            <div class="col-md-6">
              <label class="form-label text-muted fw-semibold small text-uppercase">
                <i class="fa-solid fa-scale-balanced me-1"></i> Quantité / Montant <span class="text-danger">*</span>
              </label>
                    <input type="number" name="quantite" id="quantite_input"
       class="form-control form-control-lg border-0 border-bottom rounded-0"
       style="border-bottom: 2px solid #dee2e6 !important; background-color: #f8f9fa;"
       min="1" required placeholder="Ex: 200"/>

            </div>

          </div><!-- /row -->

          <hr class="my-4 opacity-10"/>

          <div class="d-flex justify-content-between align-items-center">
            <a href="/dons" class="btn btn-link text-secondary text-decoration-none px-0">
              <i class="fa-solid fa-arrow-left me-2"></i> Retour à la liste
            </a>
            <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm rounded-3">
              <i class="fa-solid fa-floppy-disk me-2"></i> Enregistrer et dispatcher
            </button>
          </div>

        </form>
      </div>

    </div><!-- /row split -->

  </div><!-- /content -->

  <footer class="footer">
    BNGRC — Bureau National de Gestion des Risques et des Catastrophes &copy; <?= date('Y') ?>
  </footer>

</div><!-- /main -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/app.js"></script>
<script src="<?= BASE_URL ?>/assets/js/form_don.js"></script>
</body>
</html>