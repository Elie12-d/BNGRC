(function(){
  'use strict';

  const nature = document.getElementById('nature_select');
  const fieldProduit = document.getElementById('field_produit');
  const fieldArgent = document.getElementById('field_argent');
  const nomInput = document.getElementById('nom_input');
  const nomFinal = document.getElementById('nom_final');
  const quantiteInput = document.getElementById('quantite_input');
  const form = document.querySelector('form');

  if (!nature) return;

  function resetFields() {
    fieldProduit.style.display = 'none';
    fieldArgent.style.display = 'none';
    if (nomInput) nomInput.value = '';
    if (quantiteInput) quantiteInput.readOnly = false;
  }

  function handleNatureChange() {
    resetFields();

    if (nature.value === 'en_nature' || nature.value === 'en_materiaux') {
      fieldProduit.style.display = '';
    }

    if (nature.value === 'en_argent') {
      fieldArgent.style.display = '';
      quantiteInput.placeholder = "Montant en Ariary";
    }
  }

  nature.addEventListener('change', handleNatureChange);

  form.addEventListener('submit', function(e){

    if (!nature.value) {
      e.preventDefault();
      alert("Veuillez sélectionner une nature de don.");
      return false;
    }

    let finalNom = '';

    if (nature.value === 'en_argent') {
      finalNom = 'Argent';
    } else {
      if (!nomInput.value.trim()) {
        e.preventDefault();
        alert("Veuillez saisir le produit du don.");
        return false;
      }
      finalNom = nomInput.value.trim();
    }

    nomFinal.value = finalNom;
  });

  handleNatureChange();

})();