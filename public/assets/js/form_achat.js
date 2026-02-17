  (function(){
    function toNum(v){ return Number(String(v).replace(/\s+/g,'')) || 0; }
    function fmt(n){ return n.toLocaleString('fr-FR'); }

    // Read available money from the DOM dataset or from the inline global set by PHP
    const availEl = document.getElementById('available_money');
    const availableMoney = toNum((availEl && availEl.dataset && availEl.dataset.available) || window.AVAILABLE_MONEY || 0);
    const villeSelect = document.getElementById('ville_select');
    const tbody = document.getElementById('besoins_tbody');
  console.debug('availableMoney (from DOM/global):', availableMoney);

    // Filter rows to show only besoins for the selected city
    function filterByVille() {
      const vid = villeSelect.value;
      console.debug('filterByVille selected vid=', vid);
      const rows = Array.from(tbody.querySelectorAll('tr'));
      rows.forEach(row => {
        const rowVille = row.dataset.ville || '';
        if (!vid) {
          row.style.display = '';
        } else if (String(rowVille) === String(vid)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
          // uncheck any checkbox in hidden rows so they won't be submitted
          const cb = row.querySelector('.cb-besoin');
          if (cb) { cb.checked = false; }
        }
      });
      recompute();
    }

    // prepare references used by recompute before any call
    const totalEl = document.getElementById('total_selected');
    const feeEl = document.getElementById('fee_amount');
    const netEl = document.getElementById('net_needed');
    const feeInput = document.getElementById('fee_percent');
    const simResult = document.getElementById('simulation_result');
    const form = document.getElementById('achat_form');

    // when ville changes, filter
    if (villeSelect) {
      villeSelect.addEventListener('change', filterByVille);
      // initialize selection: if nothing selected, choose the first ville to improve UX
      if (!villeSelect.value && villeSelect.options.length > 1) {
        villeSelect.selectedIndex = 1; // first actual ville (index 0 is placeholder)
      }
      // run initial filter
      filterByVille();
    }

    function isVisible(elem){
      // check if element or its row is visible
      if (!elem) return false;
      const row = elem.closest('tr');
      if (!row) return false;
      return !!(row.offsetParent);
    }

    function parseNumeric(v){
      if (v === null || v === undefined) return 0;
      // remove spaces and non numeric except dot and minus
      const s = String(v).replace(/\s+/g, '').replace(/[^0-9.\-]/g, '');
      return Number(s) || 0;
    }

    function recompute(){
      let total = 0;
      // consider only visible & checked checkboxes
      const boxes = Array.from(document.querySelectorAll('.cb-besoin'));
      console.debug('recompute: total boxes=', boxes.length);
      let counted = 0;
      boxes.forEach(cb => {
        const visible = isVisible(cb);
        const checked = !!cb.checked;
        console.debug('box', cb.dataset.id, 'visible=', visible, 'checked=', checked, 'dataset.montant=', cb.dataset.montant);
        if (!visible) return; // skip hidden rows
        if (!checked) return;
        // prefer dataset.montant, fallback to computing from row cells
        let m = parseNumeric(cb.dataset.montant ?? 0);
        if (!m || m === 0) {
          const row = cb.closest('tr');
          if (row) {
            const qtyCell = row.children[2];
            const puCell = row.children[3];
            const qty = parseNumeric(qtyCell ? qtyCell.textContent : 0);
            const pu = parseNumeric(puCell ? puCell.textContent : 0);
            m = qty * pu;
          }
        }
        total += m;
        counted++;
      });
      console.debug('recompute: counted checked visible boxes=', counted);

      const feePercent = parseNumeric(feeInput.value);
      const feeAmount = Math.round(total * (feePercent / 100));
      const net = total + feeAmount;

      totalEl.textContent = fmt(total) + ' Ar';
      feeEl.textContent = fmt(feeAmount) + ' Ar';
      netEl.textContent = fmt(net) + ' Ar';

      return { total, feeAmount, net };
    }
    // Use event delegation on the tbody to handle checkbox changes dynamically
    tbody.addEventListener('change', function(e){
      const target = e.target;
      if (target && target.classList && target.classList.contains('cb-besoin')){
        recompute();
        simResult.textContent = '';
      }
    });
    feeInput.addEventListener('input', recompute);

    document.getElementById('btn_simuler').addEventListener('click', function(){
      const r = recompute();
      if (r.total === 0){ simResult.style.color = '#b00'; simResult.textContent = 'Aucune ligne sélectionnée.'; return; }
      if (availableMoney >= r.net){
        simResult.style.color = '#0a0';
        simResult.textContent = 'Fonds suffisants. Montant disponible : ' + fmt(availableMoney) + ' Ar. (Simulation seulement)';
      } else {
        simResult.style.color = '#b00';
        simResult.textContent = 'Fonds insuffisants. Montant disponible : ' + fmt(availableMoney) + ' Ar.';
      }
    });

    form.addEventListener('submit', function(ev){
      ev.preventDefault();
      const r = recompute();
      if (r.total === 0){ alert('Veuillez sélectionner au moins une ligne.') ; return; }
      if (availableMoney >= r.net){
        // submit
        // optionally show a confirmation
        if (confirm('Fonds suffisants. Confirmez-vous l\'enregistrement de la transaction ?')){
          // log checked besoin ids to help debugging what is sent to the server
          try {
            const checkedIds = Array.from(document.querySelectorAll('.cb-besoin:checked')).map(cb => cb.value);
            console.debug('Submitting besoin_ids:', checkedIds);
          } catch (e) { console.debug('Could not compute checkedIds before submit', e); }
          form.submit();
        }
      } else {
        alert('Fonds insuffisants : la validation ne peut pas être effectuée. Utilisez Simuler pour voir le détail.');
      }
    });
 // expose available money to external JS sa
    // initial compute
    recompute();
  })();