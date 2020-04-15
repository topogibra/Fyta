const addFavorites = document.querySelector('#favorites-add');

addFavorites && addFavorites.addEventListener('mousedown', () => {
    const classList = addFavorites.querySelector('i').classList;
    classList.contains('far') ? classList.add('fas') || classList.remove('far') : classList.add('far') || classList.remove('fas');
});
