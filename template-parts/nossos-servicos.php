<?php
$nossos_servicos = get_field('nossos_servicos');
if($nossos_servicos) :
    $saiba_mais = $nossos_servicos['saiba_mais'];
    $servicos = $nossos_servicos['servicos'];
?>
<section class="wrapper n-servicos">
    <div animate-fadein class="n-servicos__header">
        <h2>Nossos Serviços</h2>
        <a href="<?= esc_url($saiba_mais); ?>" title="Saiba mais">Saiba mais <img src="<?= esc_url(get_template_directory_uri() . '/assets/img/arrow-icon.svg'); ?>"></a>
    </div>
    <div class="n-servicos__content">
        <?php
        if ($servicos && is_array($servicos)) :
            $x = 0;
            foreach ($servicos as $row) :
                if ($x % 3 == 0) {
                    if ($x > 0) {
                        echo '</div>';
                    }
                    echo '<div animate-fadein class="n-servicos__row">';
                }

                $icone = $row['icone'];
                $descricao = $row['descricao'];

                echo '<div class="n-servicos__item"><figure><img src="' . $icone['url'] . '" alt="' . $icone['alt'] . '"></figure><article>' . $descricao . '</article></div>';

                $x++;
            endforeach;
            echo '</div>';
        endif;
        ?>
    </div>
</section>

<?php endif;?>