(function(){
    const nature = document.getElementById('nature_select');
    if (!nature) return;

    const fieldNature = document.getElementById('field_en_nature');
    const fieldMat = document.getElementById('field_en_materiaux');
    const fieldArg = document.getElementById('field_en_argent');

    const nomNature = document.getElementById('nom_en_nature');
    const nomMat = document.getElementById('nom_en_materiaux');
    const montantArg = document.getElementById('montant_argent');
    const nomArgentHidden = document.getElementById('nom_argent');
    const quantiteInput = document.querySelector('input[name="quantite"]');

    function resetFields(){
      // hide all
      [fieldNature, fieldMat, fieldArg].forEach(f => { if (f) f.style.display = 'none'; });
      // remove required attrs
      if (nomNature) nomNature.required = false;
      if (nomMat) nomMat.required = false;
      if (montantArg) montantArg.required = false;
      // restore nom hidden value to empty except argent
      if (nomArgentHidden) nomArgentHidden.disabled = true;
    }

    function onChange(){
      resetFields();
      const v = nature.value;
      if (v === 'en_nature'){
        if (fieldNature) fieldNature.style.display = '';
        if (nomNature) nomNature.required = true;
        if (quantiteInput) quantiteInput.disabled = false;
      } else if (v === 'en_materiaux'){
        if (fieldMat) fieldMat.style.display = '';
        if (nomMat) nomMat.required = true;
        if (quantiteInput) quantiteInput.disabled = false;
      } else if (v === 'en_argent'){
        // if (fieldArg) fieldArg.style.display = '';
        // if (montantArg) montantArg.required = true;
        if (nomArgentHidden) { nomArgentHidden.disabled = false; }
        // for argent, set quantity to 1 unless user wants otherwise
        if (quantiteInput){ quantiteInput.value = 1; quantiteInput.readOnly = false; }
      } else {
        if (quantiteInput){ quantiteInput.readOnly = false; }
      }
    }

    nature.addEventListener('change', onChange);
    // initialize on load
    onChange();
  })();