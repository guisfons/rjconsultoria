window.addEventListener('DOMContentLoaded', function(){

    window.addEventListener('resize', function(){
        wrapperDistance()
    })

    wrapperDistance()
    header()
    $(window).on('resize', function(){ header() })
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
    const menuAside = document.querySelector('.aside')
    const menuButtonAside = document.querySelector('.aside__button')

    if ($(window).width() > 900) {
        menuButton.addEventListener('click', function() {
            menuButton.classList.toggle('header__button--active')
            menuHeader.classList.toggle('header__menu--active')
        })
    } else {
        menuButton.addEventListener('click', function() {
            menuButtonAside.classList.toggle('aside__button--active')
            menuAside.classList.toggle('aside--active')
        })

        menuButtonAside.addEventListener('click', function() {
            menuButtonAside.classList.toggle('aside__button--active')
            menuAside.classList.toggle('aside--active')
        })
    }
}

function masks() {
    $(document).on('input', 'input[name="CPF"]', function() {
        $(this).mask('999.999.999-99')
    })
    
    $(document).on('input', 'input[name="nascimento"], .t-trabalho__admissao, .t-trabalho__demissao', function() {
        $(this).mask('99/99/9999')
    })
}

function formulario() {
    masks()

    $('.t-trabalho__calculo').on('submit', function() {
        return false
    })

    $(document).on('click', '.t-trabalho__adicionar', function() {
        let form = $(this).closest('.t-trabalho__empresas').find('.t-trabalho__empresa:last-of-type').clone()

        form.find('input, select').each(function() {
            if($(this).is('select')) {
                $(this).next('.nice-select').css('border-color', '#fff')
                $(this).val('')
            } else {
                $(this).val('').css('border-color', '#fff')
            }
        })

        $(this).closest('.t-trabalho__empresas').append(form)
    })

    $(document).on('click', '.t-trabalho__remover', function() {
        $(this).closest('.t-trabalho__empresa').remove()
    })

    $('.t-trabalho__enviar').on('click', function() {
        let hasError = false

        $(this).parent().find('input, select').each(function() {
            if($(this).val() == '' || $(this).val() == 'null') {
                if($(this).is('select')) {
                    $(this).next('.nice-select').focus().addClass('error')
                } else {
                    $(this).focus().addClass('error')
                }

                hasError = true
            } else {
                if($(this).is('select')) {
                    $(this).next('.nice-select').removeClass('error')
                } else {
                    $(this).removeClass('error')
                }
            }
        })

        if(hasError) {
            return false
        }
        
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

        let form = $('.t-trabalho__calculo').serialize()
        // let calculoNonce = $('.t-trabalho__nonce').val()

        let formData = ''

        // formData += form + '&' + '&empregos=' + 
        //     encodeURIComponent(JSON.stringify(empregos)) + '&calculo_nonce=' +
        //     calculoNonce + '&action=create_pessoas_post'

        formData += form + '&' + '&empregos=' + 
            encodeURIComponent(JSON.stringify(empregos)) +
            '&action=create_pessoas_post'

        if($('[name="acceptance"]').is(':not(:checked)')) {
            $('[name="acceptance"]').parent().focus().addClass('error')

            return
        } else {
            $('[name="acceptance"]').parent().removeClass('error')
        }

        var recaptchaResponse = grecaptcha.getResponse()

        if (recaptchaResponse.length === 0) {
            $('.g-recaptcha').addClass('g-recaptcha--error').focus()
        } else {
            $('.g-recaptcha').removeClass('g-recaptcha--error')

            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // $('.t-trabalho__anos').append('<strong>'+response.data.anos_trabalhados+'</strong> Anos')
                        // $('.t-trabalho__meses').append('<strong>'+response.data.meses_trabalhados+'</strong> Meses')
                        // $('.t-trabalho__dias').append('<strong>'+response.data.dias_trabalhados+'</strong> Dias')
                        // $('.t-trabalho__nonce').val(response.data.nonce)
                        $('.t-trabalho__modal').addClass('t-trabalho__modal--active')
                    } else {
                        alert('Erro: 2 | Não foi possível fazer o calculo, tente novamente mais tarde!')
                    }
                },
                error: function(xhr, status, error) {
                    alert('Erro: 1 | Não foi possível fazer o calculo, tente novamente mais tarde!')
                }
            })
        }
    })

    $('.t-trabalho__close').on('click', function() {
        grecaptcha.reset()
        $(this).closest('.t-trabalho').find('.t-trabalho__form').find('input, textarea').val('')
        $(this).closest('.t-trabalho').find('.t-trabalho__form').find('input[type="checkbox"]').prop('checked', false)
        $(this).parent().removeClass('t-trabalho__modal--active')
    })
}