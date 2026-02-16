<?php

use Tracy\Bar;
?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Récapitulation — BNGRC</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body class="bg-dark">

<div class="container py-5" style="max-width: 900px;">
  
  <!-- Header -->
  <div class="bg-body-secondary rounded-4 shadow-lg p-4 mb-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
      <div class="d-flex align-items-center gap-3">
        <div class="bg-primary bg-gradient rounded-3 p-3 shadow">
          <i class="fa-solid fa-chart-bar text-white fs-2"></i>
        </div>
        <h1 class="mb-0 fw-bold display-6 text-light">Récapitulation</h1>
      </div>
      <button class="btn btn-primary btn-lg rounded-pill shadow-lg" id="refresh">
        <i class="fa-solid fa-rotate me-2"></i>
        Actualiser
      </button>
    </div>
  </div>

  <!-- Carte principale -->
  <div class="bg-body-secondary rounded-4 shadow-lg p-4 mb-4">
    
    <!-- Besoins totaux -->
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between py-3 border-bottom border-secondary">
      <div class="d-flex align-items-center gap-3 mb-3 mb-md-0">
        <div class="bg-primary bg-opacity-25 rounded-3 p-3 border border-primary border-opacity-50">
          <i class="fa-solid fa-clipboard-list text-primary fs-1"></i>
        </div>
        <div>
          <h5 class="text-uppercase fw-semibold text-info mb-1 small">Besoins Totaux</h5>
          <p class="text-light-emphasis mb-0 small">Montant total des besoins identifiés</p>
        </div>
      </div>
      <div class="text-center text-md-end">
        <div class="display-4 fw-bold text-primary"><?= number_format($total_besoins, 0, ',', ' ') ?></div>
        <small class="text-info fw-semibold">Ariary</small>
      </div>
    </div>

    <!-- Besoins satisfaits -->
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between py-3 border-bottom border-secondary">
      <div class="d-flex align-items-center gap-3 mb-3 mb-md-0">
        <div class="bg-success bg-opacity-25 rounded-3 p-3 border border-success border-opacity-50">
          <i class="fa-solid fa-circle-check text-success fs-1"></i>
        </div>
        <div>
          <h5 class="text-uppercase fw-semibold text-success-emphasis mb-1 small">Besoins Satisfaits</h5>
          <p class="text-light-emphasis mb-0 small">Montant déjà couvert par les dons</p>
        </div>
      </div>
      <div class="text-center text-md-end">
        <div class="display-4 fw-bold text-success"><?= number_format($total_satisfaits, 0, ',', ' ') ?></div>
        <small class="text-success-emphasis fw-semibold">Ariary</small>
      </div>
    </div>

    <!-- Besoins restants -->
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between py-3">
      <div class="d-flex align-items-center gap-3 mb-3 mb-md-0">
        <div class="bg-danger bg-opacity-25 rounded-3 p-3 border border-danger border-opacity-50">
          <i class="fa-solid fa-exclamation-circle text-danger fs-1"></i>
        </div>
        <div>
          <h5 class="text-uppercase fw-semibold text-danger-emphasis mb-1 small">Besoins Restants</h5>
          <p class="text-light-emphasis mb-0 small">Montant encore à couvrir</p>
        </div>
      </div>
      <div class="text-center text-md-end">
        <div class="display-4 fw-bold text-danger"><?= number_format($total_besoins - $total_satisfaits, 0, ',', ' ') ?></div>
        <small class="text-danger-emphasis fw-semibold">Ariary</small>
      </div>
    </div>

  </div>

  <!-- Barre de progression -->
  <div class="bg-body-secondary rounded-4 shadow-lg p-4 border border-secondary border-opacity-25">
    <h4 class="fw-bold mb-3 text-light">
      <i class="fa-solid fa-chart-line me-2 text-primary"></i>
      Taux de couverture des besoins
    </h4>
    <?php 
      $pourcentage = $total_besoins > 0 ? round(($total_satisfaits / $total_besoins) * 100, 1) : 0;
    ?>
    <div class="progress mb-3 border border-secondary" style="height: 45px;">
      <div class="progress-bar bg-success bg-gradient progress-bar-striped progress-bar-animated fw-bold fs-5 shadow" 
           role="progressbar" 
           style="width: <?= $pourcentage ?>%"
           aria-valuenow="<?= $pourcentage ?>" 
           aria-valuemin="0" 
           aria-valuemax="100">
        <?= $pourcentage ?>%
      </div>
    </div>
    <div class="d-flex justify-content-between">
      <small class="fw-semibold text-info">
        <i class="fa-solid fa-arrow-left me-1"></i>0 Ar (départ)
      </small>
      <small class="fw-semibold text-info">
        <?= number_format($total_besoins, 0, ',', ' ') ?> Ar (objectif)
        <i class="fa-solid fa-arrow-right ms-1"></i>
      </small>
    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/actualiser.js"></script>
</body>
</html>