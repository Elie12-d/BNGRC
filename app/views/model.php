<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <!-- Titre dynamique -->
    <title>
        <?php 
        $pageTitles = [
            'dashboard' => 'Tableau de Bord',
            'villes' => 'Gestion des Villes',
            'besoins' => 'Besoins des Sinistrés',
            'dons' => 'Gestion des Dons',
            'recapitulatif' => 'Récapitulation Générale',
            'disp' => 'Simulation de Dispatch',
            'historique' => 'Historique des Achats'
        ];
        echo isset($pageTitles[$page]) ? $pageTitles[$page] . ' — BNGRC' : 'BNGRC — Suivi des Dons';
        ?>
    </title>
    
    <!-- Fonts & Icons (toujours présents) -->
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    
    <!-- CSS global (toujours présent) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css" />
    
    <!-- CSS spécifique selon la page -->
    <?php if ($page === 'villes'): ?>
        <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/villes.css" />
        <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/tables.css" />
        
    <?php elseif ($page === 'besoins'): ?>
        <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/besoins.css" />
        <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/forms.css" />
        <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/tables.css" />
        
    <?php elseif ($page === 'dons'): ?>
        <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/dons.css" />
        <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/forms.css" />
        
    <?php elseif ($page === 'recapitulatif'): ?>
        <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/recapitulation.css" />
        <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/cards.css" />
        
    <?php elseif ($page === 'disp'): ?>
        <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/dispatch.css" />
        <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/simulation.css" />
        
    <?php elseif ($page === 'historique'): ?>
        <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/historique.css" />
        <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/tables.css" />
        <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/filters.css" />
    <?php endif; ?>
    
    <!-- Scripts spécifiques dans le head (si nécessaire) -->
    <?php if ($page === 'dashboard'): ?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        
    <?php elseif ($page === 'recapitulatif'): ?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        
    <?php elseif ($page === 'disp'): ?>
        <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1"></script>
    <?php endif; ?>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/assets/images/favicon.png" />
</head>

<body class="page-<?= htmlspecialchars($page) ?>">
    <!-- ════════ SIDEBAR ════════ -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-icon">🛡️</div>
            <div>
                <div class="logo-text">BNGRC</div>
                <div class="logo-sub">Suivi des Dons</div>
            </div>
        </div>

        <div class="sidebar-section">Navigation</div>
        <a href="<?= BASE_URL ?>/dashboard" class="nav-item <?= $page === 'dashboard' ? 'active' : '' ?>">
            <i class="fa-solid fa-gauge-high"></i> Tableau de Bord
        </a>
        <a href="<?= BASE_URL ?>/villes" class="nav-item <?= $page === 'villes' ? 'active' : '' ?>">
            <i class="fa-solid fa-city"></i> Villes & Régions
        </a>
        <a href="<?= BASE_URL ?>/besoins" class="nav-item <?= $page === 'besoins' ? 'active' : '' ?>">
            <i class="fa-solid fa-list-check"></i> Besoins
        </a>
        <a href="<?= BASE_URL ?>/dons" class="nav-item <?= $page === 'dons' ? 'active' : '' ?>">
            <i class="fa-solid fa-hand-holding-heart"></i> Dons
        </a>
        <a href="<?= BASE_URL ?>/recapitulatif" class="nav-item <?= $page === 'recapitulatif' ? 'active' : '' ?>">
            <i class="fa-solid fa-chart-bar"></i> Récapitulation
        </a>
        <a href="<?= BASE_URL ?>/disp" class="nav-item <?= $page === 'disp' ? 'active' : '' ?>">
            <i class="fa-solid fa-wand-magic-sparkles"></i> Simulation Dispatch
        </a>
        <a href="<?= BASE_URL ?>/achat/historique" class="nav-item <?= $page === 'historique' ? 'active' : '' ?>">
            <i class="fa-solid fa-list"></i> Liste des achats
        </a>
        <a href="<?= BASE_URL ?>/dispatch" class="nav-item"><i class="fa-solid fa-wand-magic-sparkles"></i>Formulaire achat</a>

        <div class="sidebar-section">Administration</div>
        <a href="/produits" class="nav-item"><i class="fa-solid fa-tags"></i> Catalogue Produits</a>

        <div class="sidebar-footer">BNGRC Madagascar &copy; <?= date('Y') ?></div>
    </aside>

    <!-- Inclusion du contenu de la page -->
    <?php
    define('VIEWS_PATH', realpath(__DIR__ . '/../views'));
    $allowed_pages = [
        'dashboard' => 'dashboard.php',
        'villes' => 'villes.php',
        'besoins' => 'form_besoin.php',
        'form_don' => 'form_don.php',
        'recapitulatif' => 'recapitulation.php',
        'disp' => 'dispatch.php',
        'historique' => 'historique.php',
        'form_achat' => 'form_achat.php'
    ];
    
    if (isset($allowed_pages[$page])) {
        $file = VIEWS_PATH . '/' . $allowed_pages[$page];
        if (file_exists($file)) {
            include $file;
        } else {
            echo '<div class="error-message">Fichier de vue introuvable : ' . htmlspecialchars($file) . '</div>';
        }
    } else {
        echo '<div class="error-message">Page non trouvée : ' . htmlspecialchars($page) . '</div>';
    }
    ?>
    
    <script src="<?= BASE_URL ?>/assets/js/app.js"></script>
    
    <!-- Scripts spécifiques en fin de page -->
    <?php if ($page === 'dashboard'): ?>
        <script src="<?= BASE_URL ?>/assets/js/dashboard.js"></script>
        <script src="<?= BASE_URL ?>/assets/js/charts-init.js"></script>
        
    <?php elseif ($page === 'villes'): ?>
        <script src="<?= BASE_URL ?>/assets/js/villes.js"></script>
        
    <?php elseif ($page === 'besoins'): ?>
        <script src="<?= BASE_URL ?>/assets/js/besoins.js"></script>
        <script src="<?= BASE_URL ?>/assets/js/form-validation.js"></script>
        
    <?php elseif ($page === 'dons'): ?>
        <script src="<?= BASE_URL ?>/assets/js/dons.js"></script>
        
    <?php elseif ($page === 'recapitulatif'): ?>
        <script src="<?= BASE_URL ?>/assets/js/recapitulation.js"></script>
        <script src="<?= BASE_URL ?>/assets/js/ajax-refresh.js"></script>
        
    <?php elseif ($page === 'disp'): ?>
        <script src="<?= BASE_URL ?>/assets/js/dispatch.js"></script>
        <script src="<?= BASE_URL ?>/assets/js/simulation.js"></script>
        
    <?php elseif ($page === 'historique'): ?>
        <script src="<?= BASE_URL ?>/assets/js/historique.js"></script>
        <script src="<?= BASE_URL ?>/assets/js/filters.js"></script>
    <?php endif; ?>
</body>

</html>