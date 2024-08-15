$( document ).ready(function() {
    effects()
})

function effects() {
    const intersectionObserver = new IntersectionObserver((entries) => {
        el = entries[0].target
        if (entries[0].intersectionRatio > 0) {
            el.classList.add('q-somos__inferior--active')
        } else {
            if(el.classList.contains('q-somos__inferior--active')) {
                el.classList.remove('q-somos__inferior--active')
            }
        }
    })

    intersectionObserver.observe(document.querySelector('.q-somos__inferior'))
}