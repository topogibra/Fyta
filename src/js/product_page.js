const addFavorites = document.querySelector('#favorites-add');

addFavorites.addEventListener('mousedown', () => {
    console.log('Meias');
    const classList = addFavorites.querySelector('i').classList;
    console.log(classList);
    classList.contains('far') ? classList.add('fas') || classList.remove('far') : classList.add('far') || classList.remove('fas');
});