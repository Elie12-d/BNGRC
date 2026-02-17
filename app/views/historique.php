<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Historique des Achats — BNGRC</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>

  <div class="page-header">
    <div class="container">

    </div>
  </div>

  <div class="container">
    <div class="card shadow-sm">
      <div class="card-body p-0">
        <div class="table-responsive">
          <h2>
            <i class="fa-solid fa-shopping-cart me-2"></i>
            Historique des achats
          </h2>
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="px-4 py-3">
                  <i class="fa-solid fa-hashtag text-muted me-1"></i>ID
                </th>
                <th class="py-3">
                  <i class="fa-solid fa-box text-muted me-1"></i>Nom du don
                </th>
                <th class="py-3">
                  <i class="fa-solid fa-scale-balanced text-muted me-1"></i>Quantité
                </th>
                <th class="py-3">
                  <i class="fa-solid fa-coins text-muted me-1"></i>Prix unitaire
                </th>
                <th class="py-3">
                  <i class="fa-solid fa-percent text-muted me-1"></i>% frais
                </th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($achats)) : ?>
                <?php foreach ($achats as $achat) : ?>
                  <tr>
                    <td class="px-4">
                      <span class="badge bg-primary"><?= $achat['id'] ?></span>
                    </td>
                    <td>
                      <strong><?= htmlspecialchars($achat['nom'] ?? '') ?></strong>
                    </td>
                    <td><?= number_format($achat['quantite'], 0, ',', ' ') ?></td>
                    <td><?= number_format($achat['prix_unitaire'], 0, ',', ' ') ?> Ar</td>
                    <td>
                      <span class="badge bg-warning text-dark"><?= $achat['pourcentage'] ?>%</span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else : ?>
                <tr>
                  <td colspan="5" class="text-center py-5">
                    <div class="text-muted">
                      <i class="fa-solid fa-inbox fa-3x mb-3 d-block"></i>
                      <p class="mb-0">Aucun achat enregistré</p>
                    </div>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>