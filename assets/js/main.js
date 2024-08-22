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

function formulario() {
    $('input[name="CPF"]').mask('999.999.999-99')
    $('input[name="Nascimento"], .t-trabalho__admissao, .t-trabalho__demissao').mask('99/99/9999')

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
        $(this).parent().find('form').each(function() {
            $(this).find('input, select').each(function() {
                if($(this).val() == '' || $(this).val() == 'null') {
                    if($(this).is('select')) {
                        $(this).next('.nice-select').focus().css('border', '1px solid red')
                    } else {
                        $(this).focus().css('border', '1px solid red')
                    }

                    return
                }
            })
        })

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
            select_value: $(this).find('select').val()
        }

        empregos.push(emprego)
    })

    $(document).on('wpcf7mailsent', function(event) {
        let formId = event.detail.contactFormId
        let status = event.detail.status

        let formData

        formData += '&calculo_nonce=' + my_ajax_object.nonce

        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    alert('Post created successfully!')
                } else {
                    alert('Failed to create post: ' + response.data)
                }
            },
            error: function(xhr, status, error) {
                alert('AJAX error: ' + error)
            }
        })
    })
}