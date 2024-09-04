<?php
/**
 * Template Name: Login
 * Template Post Type: page
 *
 * @package UAU
 * @since 1.0.0
 */

if (is_user_logged_in()) {
    wp_redirect(home_url());
    exit;
}
get_header();
?>
<section class="login__container">
    <?php
    wp_login_form(array(
        'redirect' => '/processos/',
        'label_username' => __('Usuário'),
        'label_password' => __('Senha'),
        'label_remember' => __('Lembrar de mim?'),
        'label_log_in' => __('Entrar'),
        'remember' => true
    ));
    ?>
</section>
<?php
get_footer();