<?php
$mantenha_informado = get_field('mantenha-se_informado');
if($mantenha_informado):
    $titulo = $mantenha_informado['titulo_da_sessao'];
    $imagem_de_destaque = $mantenha_informado['imagem_de_destaque'];
    $conteudo = $mantenha_informado['conteudo'];

    echo
    '<section animate-fadein class="m-informado">
        <figure><img src="'.$imagem_de_destaque['url'].'" alt="'.$imagem_de_destaque['alt'].'"></figure>

        <article>
            <span class="heading">'.$titulo.'</span>
            '.$conteudo.'
        </article>
    </section>';
endif;
?>