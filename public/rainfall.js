document.addEventListener('DOMContentLoaded', () => {
    let searchInput = document.getElementById('station');
    if (!searchInput) return;


    searchInput.addEventListener('keyup', function() {
        let listItems = document.querySelectorAll('#home ul li');

        let searchValue = searchInput.value.toLowerCase();

        listItems.forEach(function(article) {

            var textContent = article.textContent.toLowerCase();
            var hrefLinks = article.querySelectorAll('a[href]');
            hrefLinks.forEach(function(link) {
                textContent += link.getAttribute('href').toLowerCase();
                textContent += ' ' + link.getAttribute('href').replace('_', '').replace('-', '').toLowerCase();
            });

            if (textContent.indexOf(searchValue) === -1) {
                article.style.display = 'none';
            } else {
                article.style.display = 'list-item';
            }
        });
    });

});
