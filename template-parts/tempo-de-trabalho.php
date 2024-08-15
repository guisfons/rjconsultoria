<?php
$texto1 = get_field('texto_1_calculo', 'option');
$texto2 = get_field('texto_2_calculo', 'option');
$imagem_de_destaque = get_field('imagem_de_destaque_calculo', 'option');
$calculo = get_field('calculo_de_tempo_de_trabalho', 'option');
if($calculo) :
    $titulo = $calculo['titulo_da_sessao'];
    $chamada = $calculo['chamada'];
    $informacoes = $calculo['informacoes'];
    $formulario = $calculo['formulario'][0]->ID;

    echo '<section class="wrapper t-trabalho">';
    if(!is_front_page()) :
        echo
        '<div class="t-trabalho__heading">
            <article>'.$texto1.'</article>
            <figure><img src="'.esc_url($imagem_de_destaque).'" alt="Imagem de uma mulher de amarelo com uma lupa"></figure>
            <article>'.$texto2.'</article>
        </div>';
    endif;
    echo '<article animate-fadein><span class="heading">'.$titulo.'</span>'.$chamada.'</article>';

    if(is_array($informacoes)) :
        echo '<div class="t-trabalho__content">';
    endif;
    
    foreach ($informacoes as $row) :
        $icone = $row['icone'];
        $conteudo = $row['conteudo'];
        
        echo '<article animate-fadein><figure><img src="'.$icone['url'].'" alt="'.$icone['alt'].'"></figure>'.$conteudo.'</article>';
    endforeach;
        
    if(is_array($informacoes)) :
        echo '</div>';
    endif;

    echo '<div animate-fadein class="t-trabalho__form">'.do_shortcode( '[contact-form-7 id="'.$formulario.'" ]' ).'</div>';
    echo '</section>';
endif;

?>