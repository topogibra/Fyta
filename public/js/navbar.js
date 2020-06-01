import ClassWatcher from './class_watcher.js'

const wrapperClasses = document.querySelector('.navbar-wrapper').classList;
const noScroll = () => {
    window.scrollTo(0, 0);
    console.log("Meias")
}

new ClassWatcher(document.querySelector('.navbar-collapse.collapse'), 'show',
() => {
    wrapperClasses.add('click');
    document.querySelector('body').classList.add("position-fixed")
}, 
() => {
    wrapperClasses.remove('click');
    document.querySelector('body').classList.remove("position-fixed")
});