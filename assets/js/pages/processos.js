$( document ).ready(function() {
    $('.p-processos__heading input[type="search"]').on('input', function() {
        const textoBusca = $(this).val().toLowerCase()

        $('.p-processos__item').each(function() {
            const nome = $(this).find('span:first-of-type').text().toLowerCase();
            if (nome.includes(textoBusca)) {
                $(this).removeClass('p-processos__item--hidden');
            } else {
                $(this).addClass('p-processos__item--hidden');
            }
        });
    })
})