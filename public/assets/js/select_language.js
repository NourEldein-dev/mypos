document.getElementById('language-icon').addEventListener('click', function() {
    var dropdown = document.getElementById('language-dropdown');
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
});

window.onclick = function(event) {
    if (!event.target.matches('#language-icon')) {
        var dropdown = document.getElementById('language-dropdown');
        if (dropdown.style.display === 'block') {
            dropdown.style.display = 'none';
        }
    }
};