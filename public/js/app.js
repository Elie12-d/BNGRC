// public/js/app.js — BNGRC Dashboard

(function () {
  "use strict";

  const searchInput  = document.getElementById('searchInput');
  const statusFilter = document.getElementById('statusFilter');

  function applyFilters() {
    const search = (searchInput?.value || '').toLowerCase().trim();
    const status = statusFilter?.value || '';

    document.querySelectorAll('#detailTable tbody tr.item-row').forEach(row => {
      const produit   = row.dataset.produit || '';
      const rowStatut = row.dataset.statut  || '';
      const ok = (!search || produit.includes(search)) && (!status || rowStatut === status);
      row.style.display = ok ? '' : 'none';
    });

    document.querySelectorAll('#detailTable tbody tr.city-row').forEach(cityRow => {
      const ville = cityRow.dataset.ville;
      const items = document.querySelectorAll(`#detailTable tbody tr.item-row[data-ville="${CSS.escape(ville)}"]`);
      cityRow.style.display = Array.from(items).some(r => r.style.display !== 'none') ? '' : 'none';
    });
  }

  if (searchInput)  searchInput.addEventListener('input',   applyFilters);
  if (statusFilter) statusFilter.addEventListener('change', applyFilters);

  window.addEventListener('load', () => {
    document.querySelectorAll('.progress-fill').forEach(bar => {
      const target = bar.style.width;
      bar.style.width = '0';
      requestAnimationFrame(() => { setTimeout(() => { bar.style.width = target; }, 150); });
    });
  });

})();