function openTab(event, tabId) {
    // Hide all tab contents
    var tabContents = document.querySelectorAll('div[id]');
    tabContents.forEach(function(content) {
        content.style.display = 'none';
    });

    // Reset the background color of all tab buttons
    var tabButtons = document.querySelectorAll('ul li button');
    tabButtons.forEach(function(button) {
        button.style.backgroundColor = '#f1f1f1';
        button.style.fontWeight = 'normal';
    });

    // Show the selected tab content
    document.getElementById(tabId).style.display = 'block';

    // Highlight the clicked button
    event.currentTarget.style.backgroundColor = '#ddd';
    event.currentTarget.style.fontWeight = 'bold';
}