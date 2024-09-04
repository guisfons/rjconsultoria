<?php
/**
 * Template Name: Processos
 * Template Post Type: page
 *
 * @package UAU
 * @since 1.0.0
 */

if (!is_user_logged_in()) {
    wp_redirect('/login/');
    exit;
}
get_header();

$current_user_id = get_current_user_id();
$current_user = wp_get_current_user();
$profile_image = get_field('foto_de_perfil', 'user_' . $current_user_id);
$first_name = $current_user->user_firstname;
$last_name = $current_user->user_lastname;
$full_name = $first_name . ' ' . $last_name;

$hour = date('H');

if ($hour >= 5 && $hour < 12) {
    $greeting = "Bom dia,";
} elseif ($hour >= 12 && $hour < 18) {
    $greeting = "Boa tarde,";
} else {
    $greeting = "Boa noite,";
}
?>
<section class="wrapper p-processos">
    <div class="p-processos__head">
        <div class="p-processos__profile">
            <figure><img src="<?php echo $profile_image; ?>" alt="<?= $full_name; ?>"></figure>

            <span><?= $greeting . ' ' . $full_name; ?></span>
        </div>

        <a class="p-proccessos__logout" href="<?= esc_url(wp_logout_url()); ?>"><svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.75 33.75H5.75C4.82174 33.75 3.9315 33.3813 3.27513 32.7249C2.61875 32.0685 2.25 31.1783 2.25 30.25V5.75C2.25 4.82174 2.61875 3.9315 3.27513 3.27513C3.9315 2.61875 4.82174 2.25 5.75 2.25H12.75M25 26.75L33.75 18M33.75 18L25 9.25M33.75 18H12.75" stroke="#EB001B" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
    </div>

    <div class="p-processos__box">
        <?php
        $args = array(
            'post_type' => 'post',
            'meta_query' => array(
                array(
                    'key' => 'usuario_atrelado',
                    'value' => '"' . $current_user_id . '"',
                    'compare' => 'LIKE',
                )
            )
        );
    
        $query = new WP_Query($args);
        $titulo = '';
        if ($query->have_posts()) { ?>
        <div class="p-processos__heading">
            <h2>Meus processos</h2>

            <label for="search">
                <input type="search" name="search" id="search" placeholder="Buscar por processo">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.4851 17.154L10.2231 10.892C9.7231 11.318 9.14811 11.6477 8.49811 11.881C7.84811 12.1143 7.19477 12.231 6.53811 12.231C4.93677 12.231 3.58144 11.6767 2.47211 10.568C1.36277 9.45933 0.808105 8.10433 0.808105 6.503C0.808105 4.90167 1.36211 3.546 2.47011 2.436C3.57811 1.326 4.93277 0.770333 6.53411 0.769C8.13544 0.767666 9.49144 1.32233 10.6021 2.433C11.7128 3.54367 12.2681 4.89933 12.2681 6.5C12.2681 7.19467 12.1451 7.867 11.8991 8.517C11.6531 9.167 11.3298 9.723 10.9291 10.185L17.1911 16.446L16.4851 17.154ZM6.5391 11.23C7.86577 11.23 8.98577 10.7733 9.89911 9.86C10.8124 8.94667 11.2691 7.82633 11.2691 6.499C11.2691 5.17167 10.8124 4.05167 9.89911 3.139C8.98577 2.22633 7.86577 1.76967 6.5391 1.769C5.21244 1.76833 4.09211 2.225 3.17811 3.139C2.26411 4.053 1.80744 5.173 1.80811 6.499C1.80877 7.825 2.26544 8.945 3.17811 9.859C4.09077 10.773 5.21077 11.2297 6.53811 11.229" fill="white"/> </svg>
            </label>
        </div>

        <div class="p-processos__lista">
            <div class="p-processos__lista-head">
                <span>Nome do cliente</span>
                <span>Tipo de Processo</span>
                <span>Status</span>
                <span>Última Atualização</span>
            </div>

            <div class="p-processos__lista-processos">
                <?php            
                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        $categories = get_the_category($post->ID);

                        echo
                        '<div class="p-processos__item">
                            <span>'.get_the_title().'</span>
                            <span>'.$categories[0]->name.'</span>
                            <span>'.get_field('status').'</span>
                            <span>'.get_the_modified_date('d/m/Y').'</span>
                        </div>';
                    }
                }
            
                wp_reset_postdata();
                ?>
            </div>
        </div>
        <?php } else { ?>
        <div class="p-processos__heading">
            <h2>Nenhum processo encontrado.</h2>
        </div>
        <?php } ?>
    </div>
</section>
<?php

get_footer();