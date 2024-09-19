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
            <div class="t-trabalho__info">
                <p><strong>Informações pessoais:</strong></p>

                <input type="text" name="nome" id="nome" placeholder="Nome*" required>
                <input type="text" name="sobrenome" id="sobrenome" placeholder="Sobrenome*" required>
                <input type="tel" name="nascimento" id="nascimento" placeholder="Data de nascimento*">
                <select name="genero" id="genero" required>
                    <option value="" selected>Gênero</option>
                    <option value="feminino">Feminino</option>
                    <option value="masculino">Masculino</option>
                </select>
                <input type="tel" name="telefone" id="telefone" placeholder="Telefone*">
                <input type="email" name="email" id="email" placeholder="E-mail*">
            </div>
            <div class="t-trabalho__empresas">
                <p><strong>Empresa(s):</strong></p>
                <div class="t-trabalho__empresa">
                    <input type="text" placeholder="Nome da empresa" class="t-trabalho__nome">
                    <input type="tel" placeholder="Data de admissão" class="t-trabalho__admissao">
                    <input type="tel" placeholder="Data de demissão" class="t-trabalho__demissao">
                    <select required>
                        <option value="" selected>Tipo do tempo</option>
                        <option value="comum">Comum</option>
                        <option value="especial">Especial</option>
                    </select>
                    <span class="t-trabalho__adicionar" title="Adicionar outra empresa">+</span>
                    <span class="t-trabalho__remover" title="Remover empresa">-</span>
                </div>
            </div>

            <label for="acceptance">
                <input type="checkbox" name="acceptance" id="acceptance">
                <p>Declaro que todas as informações fornecidas são verdadeiras e completas. Autorizo ao Grupo RJ Consultoria a utilizar e processar os dados e documentos fornecidos para a finalidade de calcular meu tempo de trabalho e verificar a elegibilidade para benefícios do INSS. Entendo que a análise dos dados é confidencial e que o Grupo RJ Consultoria se compromete a proteger minha privacidade e a utilizar as informações apenas para os fins descritos e para contato.</p>
            </label>
        </form>

        <!-- <input type="hidden" class="t-trabalho__nonce" value="<?php echo wp_create_nonce('calculo_nonce_action'); ?>"> -->
        <div class="g-recaptcha" data-sitekey="6LeOvyoqAAAAAL4orUGkdni1rBpdTGRl7qhG8z64"></div>
        <button class="t-trabalho__enviar">Enviar dados</button>
    </div>

    <div class="t-trabalho__modal">
        <!-- <h5>Você trabalhou por:</h5> -->
		<h5>Formulário enviado com sucesso! Em breve, um de nossos atendentes entrará em contato com você.</h5>
        <!-- <span class="t-trabalho__anos"></span>
        <span class="t-trabalho__meses"></span>
        <span class="t-trabalho__dias"></span> -->

        <button class="t-trabalho__close"></button>
    </div>
<?php
    echo '</section>';
endif;
?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>