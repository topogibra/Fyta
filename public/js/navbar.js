import ClassWatcher from './class_watcher.js'

const wrapperClasses = document.querySelector('.navbar-wrapper').classList;


new ClassWatcher(document.querySelector('.navbar-collapse.collapse'), 'show', () => wrapperClasses.add('click'), () => wrapperClasses.remove('click'));