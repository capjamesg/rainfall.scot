document.addEventListener('DOMContentLoaded', () => {
    let searchInput = document.getElementById('station');
    if (!searchInput) return;


    searchInput.addEventListener('keyup', function() {
        let listItems = document.querySelectorAll('#home ul li');

        let searchValue = searchInput.value.toLowerCase();

        listItems.forEach(function(article) {

            const textContent = article.textContent.toLocaleLowerCase();

            if (textContent.indexOf(searchValue) === -1) {
                article.style.display = 'none';
            } else {
                article.style.display = 'list-item';
            }
        });
    });

});
