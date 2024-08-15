// const $ = document.querySelector.bind(document)
// const $$ = document.querySelectorAll.bind(document)

window.addEventListener('DOMContentLoaded', function(){

    window.addEventListener('resize', function(){
        wrapperDistance()
    })

    wrapperDistance()
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