export function removeAll(node){
    while (node.firstElementChild){
        node.removeChild(node.firstElementChild)
    }
}