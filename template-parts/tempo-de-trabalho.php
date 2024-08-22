<?php
$texto1 = get_field('texto_1_calculo', 'option');
$texto2 = get_field('texto_2_calculo', 'option');
$imagem_de_destaque = get_field('imagem_de_destaque_calculo', 'option');
$calculo = get_field('calculo_de_tempo_de_trabalho', 'option');
if ($calculo) :
    $titulo = $calculo['titulo_da_sessao'];
    $chamada = $calculo['chamada'];
    $informacoes = $calculo['informacoes'];
    $formulario = $calculo['formulario'][0]->ID;

    echo '<section class="wrapper t-trabalho">';
    if (!is_front_page()) :
        echo
        '<div class="t-trabalho__heading">
            <article>' . $texto1 . '</article>
            <figure><img src="' . esc_url($imagem_de_destaque) . '" alt="Imagem de uma mulher de amarelo com uma lupa"></figure>
            <article>' . $texto2 . '</article>
        </div>';
    endif;
    echo '<article ><span class="heading">' . $titulo . '</span>' . $chamada . '</article>';

    if (is_array($informacoes)) :
        echo '<div class="t-trabalho__content">';
    endif;

    foreach ($informacoes as $row) :
        $icone = $row['icone'];
        $conteudo = $row['conteudo'];

        echo '<article ><figure><img src="' . $icone['url'] . '" alt="' . $icone['alt'] . '"></figure>' . $conteudo . '</article>';
    endforeach;

    if (is_array($informacoes)) :
        echo '</div>';
    endif;
?>
    <div class="t-trabalho__form">
        <h3>Formúlário de Cálculo do  benefício de tempo de trabalho</h3>
        <p>Preencha os campos abaixo com suas informações para que possamos calcular seu tempo de trabalho e verificar a elegibilidade para benefícios do INSS.</p>

        <form class="t-trabalho__calculo">
            <div class="t-trabalho__empresa">
                <input type="text" placeholder="Nome da empresa" class="t-trabalho__nome">
                <input type="tel" placeholder="Data de admissão" class="t-trabalho__admissao">
                <input type="tel" placeholder="Data de demissão" class="t-trabalho__demissao">
                <select>
                    <option value="null" selected>Tipo do tempo</option>
                    <option value="comum">Comum</option>
                    <option value="especial">Especial</option>
                </select>
                <span class="t-trabalho__adicionar" title="Adicionar outra empresa">+</span>
                <span class="t-trabalho__remover" title="Remover empresa">-</span>
            </div>
        </form>

        <?php echo do_shortcode( '[contact-form-7 id="'.$formulario.'" ]' ); ?>
        
        <button class="t-trabalho__enviar">Enviar dados</button>
        <input type="hidden" id="calculo_nonce" name="calculo_nonce" value="<?php echo wp_create_nonce('calculo_nonce_action'); ?>">
    </div>
<?php
    echo '</section>';
endif;

?>