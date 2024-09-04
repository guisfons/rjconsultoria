// const $ = document.querySelector.bind(document)
// const $$ = document.querySelectorAll.bind(document)

window.addEventListener('DOMContentLoaded', function(){

    window.addEventListener('resize', function(){
        wrapperDistance()
    })

    wrapperDistance()
    header()
    formulario()
    $('select').niceSelect()
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
    const menuButton = document.querySelector('.header__button')
    const menuHeader = document.querySelector('.header__menu')
    
    menuButton.addEventListener('click', function() {
        menuButton.classList.toggle('header__button--active')
        menuHeader.classList.toggle('header__menu--active')
    })
}

function masks() {
    $(document).on('input', 'input[name="CPF"]', function() {
        $(this).mask('999.999.999-99');
    });
    
    $(document).on('input', 'input[name="Nascimento"], .t-trabalho__admissao, .t-trabalho__demissao', function() {
        $(this).mask('99/99/9999');
    });
}

function formulario() {
    masks()

    $('.t-trabalho__calculo').on('submit', function() {
        return false
    })

    $(document).on('click', '.t-trabalho__adicionar', function() {
        let form = $(this).closest('.t-trabalho__calculo').find('.t-trabalho__empresa:last-of-type').clone()

        form.find('input, select').each(function() {
            if($(this).is('select')) {
                $(this).next('.nice-select').css('border-color', '#fff')
                $(this).val('')
            } else {
                $(this).val('').css('border-color', '#fff')
            }
        })

        $(this).closest('.t-trabalho__calculo').append(form)
    })

    $(document).on('click', '.t-trabalho__remover', function() {
        $(this).closest('.t-trabalho__empresa').remove()
    })

    $('.t-trabalho__enviar').on('click', function() {
        // $(this).parent().find('form').each(function() {
        //     $(this).find('input, select').each(function() {
        //         if($(this).val() == '' || $(this).val() == 'null') {
        //             if($(this).is('select')) {
        //                 $(this).next('.nice-select').focus().css('border', '1px solid red')
        //             } else {
        //                 $(this).focus().css('border', '1px solid red')
        //             }
        //             return
        //         }
        //     })
        // })

        $(this).parent().find('.wpcf7-submit').click()
        calculo()
    })
}

function calculo() {
    let empregos = []

    $('.t-trabalho__empresa').each(function() {
        let emprego = {
            empresa: $(this).find('.t-trabalho__nome').val(),
            data_admissao: $(this).find('.t-trabalho__admissao').val(),
            data_demissao: $(this).find('.t-trabalho__demissao').val(),
            tipo_tempo: $(this).find('select').val()
        }
        
        empregos.push(emprego)
    })

    let cf7Form = $('.t-trabalho__calculo + .wpcf7 form').serialize();
    let calculoNonce = $('.t-trabalho__nonce').val();

    cf7Send(cf7Form, empregos, calculoNonce)
}

function cf7Send(cf7Form, empregos, calculoNonce) {
    $(document).on('wpcf7mailsent', function(event) {
        let formData = ''

        formData += cf7Form + '&' + '&empregos=' + 
            encodeURIComponent(JSON.stringify(empregos)) + '&calculo_nonce=' +
            calculoNonce + '&action=create_pessoas_post'

        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    alert('Calculo feito com sucesso!')
                } else {
                    alert('Erro: 2 | Não foi possível fazer o calculo, tente novamente mais tarde!')
                }
            },
            error: function(xhr, status, error) {
                alert('Erro: 1 | Não foi possível fazer o calculo, tente novamente mais tarde!')
            }
        })

        return
    })
}