<?php
loadModulesScriptsForTemplate('depoimentos.js');
if (have_rows('depoimentos', 'option')) :
?>
    <section class="depoimentos">
        <div class="wrapper depoimentos__heading">
            <h2>O que nossos clientes acham sobre os nossos serviços?</h2>
            <div class="depoimentos__nav">
                <span class="depoimentos__arrow depoimentos__arrow--prev"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.71475 1.40314L3.47145 6.64645L2.61789 7.5H3.825H15.5V8.5H3.825H2.61789L3.47145 9.35355L8.71475 14.5969L8.00312 15.296L0.707107 8L8.00311 0.703992L8.71475 1.40314Z" fill="black" stroke="white"/></svg></span>
                <span class="depoimentos__arrow depoimentos__arrow--next"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.71475 1.40314L3.47145 6.64645L2.61789 7.5H3.825H15.5V8.5H3.825H2.61789L3.47145 9.35355L8.71475 14.5969L8.00312 15.296L0.707107 8L8.00311 0.703992L8.71475 1.40314Z" fill="black" stroke="white"/></svg></span>
            </div>
        </div>
        <div class="wrapper-left depoimentos__slider">
        <?php
        while (have_rows('depoimentos', 'option')) : the_row();
            $foto = get_sub_field('foto');
            $nome_completo = get_sub_field('nome_completo');
            $area = get_sub_field('area');
            $depoimento = get_sub_field('depoimento');
        ?>
            <div class="depoimentos__card">
                <figure><img src="<?= $foto['url']; ?>" alt="<?= $nome_completo; ?>"></figure>
                <article>
                    <strong><?= $nome_completo; ?></strong>
                    <span><?= $area; ?></span>
                    <blockquote>“<?= $depoimento; ?>”</blockquote>
                </article>
            </div>
        <?php
        endwhile;
        ?>
        </div>
    </section>
<?php
endif;
?>