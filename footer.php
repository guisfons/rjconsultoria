<?php wp_footer(); ?>
</main>
<footer class="footer">
    <?php
    $content = get_field('conteudo', 'option');

    // Inferior
    $imagem = get_field('imagem_de_destaque', 'option');
    $texto2 = get_field('texto_de_destaque', 'option');

    if(!is_page('processos')):
    ?>
    <section class="footer-ajuda">
        <div class="wrapper footer-ajuda__inferior">
            <article><?= $content; ?></article>
            <div class="card">
                <figure><img src="<?= $imagem; ?>" alt="<?= $imagem; ?>"></figure>  
                <article>
                    <svg width="38" height="34" viewBox="0 0 38 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.0825 3.99C4.9875 1.8975 7.7075 0.75 10.9 0.75C13.81 0.75 16.9175 2.125 19 4.8125C21.0675 2.125 24.1625 0.75 27.1 0.75C30.285 0.75 33 1.8925 34.91 3.98C36.8 6.05 37.75 8.885 37.75 12.0325C37.75 17.445 34.9675 21.8025 31.445 25.19C27.9325 28.57 23.52 31.1475 19.8625 33.04C19.5946 33.1786 19.2972 33.2505 18.9956 33.2496C18.694 33.2487 18.3971 33.1751 18.13 33.035C14.4725 31.1225 10.06 28.565 6.5475 25.2025C3.025 21.825 0.25 17.4825 0.25 12.0325C0.25 8.895 1.195 6.06 3.0825 3.99ZM5.855 6.515C4.7175 7.765 4 9.6325 4 12.0325C4 16.0925 6.04 19.5225 9.1425 22.4925C12.0075 25.24 15.6425 27.455 19.005 29.255C22.3425 27.48 25.98 25.245 28.8475 22.4875C31.955 19.4975 34 16.05 34 12.0325C34 9.625 33.28 7.7575 32.14 6.5075C31.02 5.285 29.35 4.5 27.1 4.5C24.66 4.5 21.8675 6.0675 20.7825 9.37C20.6598 9.74604 20.4213 10.0736 20.1011 10.306C19.781 10.5383 19.3956 10.6633 19 10.6633C18.6044 10.6633 18.219 10.5383 17.8989 10.306C17.5787 10.0736 17.3402 9.74604 17.2175 9.37C16.135 6.07 13.3125 4.5 10.9 4.5C8.6425 4.5 6.975 5.285 5.855 6.515Z" fill="#EB001B" />
                    </svg>
                    <?= $texto2; ?>
                </article>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <section class="footer__content">
        <div class="wrapper">
            <figure class="footer__logo"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/logotipo.webp" alt="RJ Consultoria"></figure>
            <hr>
            <div class="footer__links">
            <?php
				$footer_menu = wp_get_nav_menu_items('Menu footer');
				if(is_array($footer_menu)){
					foreach($footer_menu as $key => $menu_item){
						echo '<a title="'. str_replace('*', '', $menu_item->title) .'" href="'.$menu_item->url.'" target="'.$menu_item->target.'">';
							$menu_title = $menu_item->title;
							if (strpos($menu_item->title, '*') !== false) {
								$menu_title = str_replace('*', '', $menu_item->title);
							}
							echo $menu_title;
						echo '</a>';
					}
				}
				?>
            </div>
        </div>
    </section>
    <section class="footer__foot">
        <div class="wrapper">
            <span>Copyright © <?= date('Y'); ?>, RJ Consultoria. todos os direitos reservados</span>
            <a href="mailto:contato@gruporjconsultoria.com.br">contato@gruporjconsultoria.com.br</a>
        </div>
    </section>
</footer>

</body>

</html>