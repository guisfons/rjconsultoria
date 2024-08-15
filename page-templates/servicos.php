<?php

/**
 * Template Name: Serviços
 * Template Post Type: page
 *
 * @package UAU
 * @since 1.0.0
 */

get_header();

$menu_items = wp_get_nav_menu_items('Menu');
$contato = null;

if (!empty($menu_items)) {
    foreach ($menu_items as $item) {
        if ($item->title === 'Contato') {
            $contato = $item;
            break;
        }
    }
}
?>
<section animate-fadein class="wrapper s-banner">
    <figure><img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>"></figure>
    <article><?php echo wpautop(get_the_content()); ?></article>
</section>

<section animate-fadein class="wrapper s-servico">
    <div class="s-servico__content">
        <article class="s-servico__text"><?php echo get_field('conteudo_primeira'); ?></article>
        <?php if (have_rows('lista_primeira')) : ?>
            <ul class="s-servico__list">
                <?php while (have_rows('lista_primeira')) : the_row(); ?>
                    <li><?php the_sub_field('item'); ?></li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>
    </div>
    <a href="<?php echo $contato->url; ?>" class="s-servico__button">Entrar em contato</a>
</section>

<section animate-fadein class="s-servico s-servico--red">
    <div class="wrapper">
        <div class="s-servico__content">
            <article class="s-servico__text"><?php echo get_field('conteudo_segunda'); ?></article>
            <?php if (have_rows('lista_segunda')) : ?>
                <ul class="s-servico__list">
                    <?php while (have_rows('lista_segunda')) : the_row(); ?>
                        <li><?php the_sub_field('item'); ?></li>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>
        </div>
        <a href="<?php echo $contato->url; ?>" class="s-servico__button">Entrar em contato</a>
    </div>
</section>

<?php get_template_part('template-parts/tempo-de-trabalho'); ?>

<section animate-fadein class="wrapper s-servico">
    <div class="s-servico__content">
        <article class="s-servico__text"><?php echo get_field('conteudo_terceira'); ?></article>
        <?php if (have_rows('lista_terceira')) : ?>
            <ul class="s-servico__list">
                <?php while (have_rows('lista_terceira')) : the_row(); ?>
                    <li><?php the_sub_field('item'); ?></li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>
    </div>
    <a href="<?php echo $contato->url; ?>" class="s-servico__button">Entrar em contato</a>
</section>

<?php
get_footer();
