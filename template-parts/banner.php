<?php
loadModulesScriptsForTemplate('banner.js');
if( have_rows('banner') ):
    echo '<section class="wrapper banner"><div class="banner__slider">';
    $x = 0;
    while( have_rows('banner') ) : the_row();
        $imagem_de_fundo = get_sub_field('imagem_de_fundo');
        $conteudo = get_sub_field('conteudo');
        echo
        '<div class="banner__item" data-index="'.$x.'">
            <article>'.$conteudo.'</article>
            <figure><img src="'.esc_url($imagem_de_fundo['url']).'" alt="'.$imagem_de_fundo['alt'].'"></figure>
        </div>';
        $x++;
    endwhile;
    echo '</div>';
    echo '</section>';
endif;
?>