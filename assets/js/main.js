// const $ = document.querySelector.bind(document)
// const $$ = document.querySelectorAll.bind(document)

window.addEventListener('DOMContentLoaded', function(){

    window.addEventListener('resize', function(){
        wrapperDistance()
    })

    wrapperDistance()
    header()
})

function wrapperDistance(){
    let distance = document.querySelector('.wrapper').offsetLeft
    
    document.querySelectorAll('.wrapper-left').forEach(function(item){
        item.style.paddingLeft = `${distance}px`
    })
    document.querySelectorAll('.wrapper-right').forEach(function(item){
        item.style.paddingRight = `${distance}px`
    })
}

function header() {
    const menuButton = document.querySelector('.header__button');
    const menuHeader = document.querySelector('.header__menu');
    
    menuButton.addEventListener('click', function() {
        menuButton.classList.toggle('header__button--active')
        menuHeader.classList.toggle('header__menu--active')
    })
}