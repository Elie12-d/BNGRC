window.addEventListener('DOMContentLoaded', () => {
    const refreshButton = document.getElementById('refresh-button');
    if (refreshButton) {
        refreshButton.addEventListener('click', () => {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', '/recapitulatif');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert('Rafraîchissement effectué avec succès !');
                } else {
                    alert('Erreur lors du rafraîchissement : ' + xhr.status);
                }
            };
            xhr.onerror = function() {
                alert('Erreur de réseau lors du rafraîchissement.');
            };
            xhr.send();
        });
    }
});