<?php

/**
 * Theme functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package itmidia
 * @since 1.0.0
 */

if (in_array(session_status(), [PHP_SESSION_NONE, 1])) {
	session_start();
}

/**
 * Composer autoload
 */
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once (__DIR__ . '/vendor/autoload.php');
}

/**
 * @todo improve to use namespaces and Helpers be a class
 */
require_once (__DIR__ . '/src/Helpers.php');
require_once(__DIR__ . '/inc/post-types.php');
#require_once(__DIR__ . '/inc/shortcodes/galleries.php');
#require_once(__DIR__ . '/inc/shortcodes/special-posts-videos.php');

/**
 * @info Security Tip
 * Remove version info from head and feeds
 */
add_filter('the_generator', 'wp_version_removal');

function wp_version_removal() {
    return false;
}

/**
 * @info Security Tip
 * Disable oEmbed Discovery Links and wp-embed.min.js
 */
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );
remove_action('rest_api_init', 'wp_oembed_register_route');
remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);

/**
 * @bugfix Yoast fix wrong canonical url in production
 *
 * Set canonical URLs on non-production sites to the production URL
 */
#add_filter( 'wpseo_canonical', function( $canonical ) {
#	$canonical = preg_replace('#//[^/]*/#U', '//itmorum365.com.br/', trailingslashit( $canonical ) );
#	return $canonical;
#});

/**
 * Filter except length to 35 words.
 *
 * @param integer $length
 * @return integer
 */
function custom_excerpt_length( $length ) {
    return 40;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/**
 * Add excerpt support for pages
 */
add_post_type_support( 'page', 'excerpt' );

/**
 * Remove Admin Bar from front-end
 */
add_filter('show_admin_bar', '__return_false');

/**
 * Disables block editor "Gutenberg"
 */
add_filter("use_block_editor_for_post_type", "use_gutenberg_editor");
function use_gutenberg_editor() {
    return false;
}

/**
 * Add support to thumbnails
 */
add_theme_support('post-thumbnails');

/**
 * @info this theme doesn't have custom thumbnails dimensions
 *
 * define the size of thumbnails
 * To enable featured images, the current theme must include
 * add_theme_support( 'post-thumbnails' ) and they will show the metabox 'featured image'
 */
add_image_size('company-size', 162, 81, false );
add_image_size('event-gallery', 490, 568, false );
/*add_image_size('slide-large', 1366, 400, true );
add_image_size('slide-extra-large', 2560, 749, true );*/


/**
 * Páginas Especiais
 */

if( function_exists('acf_add_options_page') ) {

   /* @info disabled by unused*/
    acf_add_options_page(array(
        'page_title' => 'Opções Gerais',
        'menu_title' => 'Opções Gerais',
        'menu_slug'  => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
        'icon_url'   => 'dashicons-admin-settings',
        'position'   => 2

    ));

    acf_add_options_page(array(
        'page_title' => 'Destaques',
        'menu_title' => 'Destaques',
        'menu_slug'  => 'uau-slides',
        'capability' => 'edit_posts',
        'redirect'   => false,
        'icon_url'   => 'dashicons-excerpt-view',
        'position'   => 3
	));

}


/**
 * Registering Locations of Navigation Menus
 */

function navigation_menus(){
    /* this function register a array of locations */
    register_nav_menus(
        array(
			'header-menu' => 'Menu Header',
        )
    );
}

add_action('init', 'navigation_menus');

/**
 * ACF Improvements
 * Order results by descendent date in relational fields
 *
 * @param array $args
 * @param array $field
 * @param integer $post_id
 * @return array
 */
function relational_fields_order( $args, $field, $post_id ) {
    $args['orderby'] = 'date';
	$args['order'] = 'DESC';
	return $args;
}
add_filter('acf/fields/relationship/query', 'relational_fields_order', 10, 3);

/**
 * ACF Improvements
 * Order results by descendent date in post object fields
 *
 * @param array $args
 * @param array $field
 * @param integer $post_id
 * @return array
 */
function post_objects_fields_order( $args, $field, $post_id ) {
    $args['orderby'] = 'date';
	$args['order'] = 'DESC';
	return $args;
}
add_filter('acf/fields/post_object/query', 'post_objects_fields_order', 10, 3);

/**
 * Declaring the JS files for the site
 */

function scripts() {
    wp_deregister_script("jquery");
}
add_action('wp_enqueue_scripts','scripts', 10); // priority 10


/**
 * Applying custom logo at WP login form
 */
function login_logo() {
?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url("<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo.svg");
            width:260px;
            height:55px;
            background-size: contain;
            background-repeat: no-repeat;
        }
    </style>
<?php
}
add_action( 'login_enqueue_scripts', 'login_logo' );

function login_logo_url() {
    return home_url();
}

add_filter( 'login_headerurl', 'login_logo_url' );

function login_logo_url_title() {
    return 'Grupo RJ Consultoria';
}

add_filter( 'login_headertext', 'login_logo_url_title' );

function custom_logout_redirect() {
    wp_redirect(home_url());
    exit();
}
add_action('wp_logout', 'custom_logout_redirect');

/**
 * Declaring the JS files for the site
 */
add_action('wp_enqueue_scripts','scripts', 10); // priority 10

REQUIRE_ONCE('inc/style-scripts.php');


/**
 * Pagination of posts in pages
 */
function pagination($pages = '', $range = 4) {
   $showitems = ($range * 2) + 1;

   global $paged;
   if (empty($paged)) $paged = 1;

   if ($pages == '') {
      global $wp_query;
      $pages = $wp_query->max_num_pages;
      if (!$pages) {
         $pages = 1;
      }
   }

   if (1 != $pages) {
      echo "<div class=\"pagination__arrow\">";
      if ($paged > 1 && $showitems < $pages) echo "<a href='" . get_pagenum_link($paged - 1) . "'><svg width=\"10\" height=\"17\"><use xlink:href=\"" . get_template_directory_uri() . "/assets/img/SVG/sprite.svg#p-arrow-left\"></use></svg>Anterior</a>";
      echo "</div>";

      echo '<div class="pagination__numbers">';
      for ($i = 1; $i <= $pages; $i++) {
         if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
            echo ($paged == $i) ? "<a href=\"\" class=\"active\">" . $i . "</a>" : "<a href='" . get_pagenum_link($i) . "'>" . $i . "</a>";
         } elseif ($i == $paged) {
            echo '<a href=\"\" class=\"active\">' . $i . '</a>';
         }
      }
      echo '</div>';

      echo "<div class=\"pagination__arrow pagination__arrow--right\">";         
      if ($paged < $pages && $showitems < $pages) echo "<a href='" . get_pagenum_link($paged + 1) . "'>Próxima<svg width=\"10\" height=\"17\"><use xlink:href=\"" . get_template_directory_uri() .  "/assets/img/SVG/sprite.svg#p-arrow-right\"></use></svg></a>";
      echo "</div>";
   }
}

// Allow SVG
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {
    global $wp_version;
    if ( $wp_version !== '4.7.1' ) {
        return $data;
    }

    $filetype = wp_check_filetype( $filename, $mimes );
    return [
        'ext'             => $filetype['ext'],
        'type'            => $filetype['type'],
        'proper_filename' => $data['proper_filename']
    ];
}, 10, 4 );
  
function cc_mime_types( $mimes ){
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );
  
function fix_svg() {
    echo '<style type="text/css">
            .attachment-266x266, .thumbnail img {
                width: 100% !important;
                height: auto !important;
            }
        </style>';
}
add_action( 'admin_head', 'fix_svg' );

function remove_gravatar_from_user_profile($user) {
    ?>
    <style>
        .user-profile-picture { display: none; }
    </style>
    <?php
}

add_action('show_user_profile', 'remove_gravatar_from_user_profile');
add_action('edit_user_profile', 'remove_gravatar_from_user_profile');

add_action('wp_ajax_create_pessoas_post', 'create_pessoas_post');
add_action('wp_ajax_nopriv_create_pessoas_post', 'create_pessoas_post');

function create_pessoas_post() {
    check_ajax_referer('calculo_nonce_action', 'calculo_nonce');

    $nome_completo = sanitize_text_field($_POST['nome'] . ' ' . $_POST['sobrenome']);
    $genero = sanitize_text_field(strtolower($_POST['genero']));
    $telefone = sanitize_text_field($_POST['telefone']);
    $email = sanitize_text_field($_POST['email']);
    $idade = '';
    $hoje = new DateTime();
    $data_nascimento = DateTime::createFromFormat('d/m/Y', sanitize_text_field($_POST['nascimento']));
    $diferenca = $hoje->diff($data_nascimento);
    $empregos = isset($_POST['empregos']) ? json_decode(stripslashes($_POST['empregos']), true) : array();

    $post_id = wp_insert_post(array(
        'post_title'   => $nome_completo,
        'post_status'  => 'publish',
        'post_type'    => 'pessoas',
    ));

    if ($post_id) {
        $field = acf_get_field('empresas_trabalhadas');
        if ($field) {
            $field_key = $field['key'];
            if (!empty($empregos)) {
                $acf_data = array();
                $total_dias = 0;

                foreach ($empregos as $emprego) {
                    $data_admissao = DateTime::createFromFormat('d/m/Y', $emprego['data_admissao']);
                    $data_demissao = DateTime::createFromFormat('d/m/Y', $emprego['data_demissao']);
                    $tipo_tempo = $emprego['tipo_tempo'];

                    if ($data_admissao && $data_demissao) {
                        $formatted_data_admissao = $data_admissao->format('Y-m-d');
                        $formatted_data_demissao = $data_demissao->format('Y-m-d');

                        $interval = $data_admissao->diff($data_demissao);
                        $tempo_total_em_dias = $interval->days + 1;

                        if($tipo_tempo == 'especial') {
                            if($genero == 'masculino') {
                                $tempo_total_em_dias = $tempo_total_em_dias + ($tempo_total_em_dias * 0.4);
                            } else {
                                $tempo_total_em_dias = $tempo_total_em_dias + ($tempo_total_em_dias * 0.2);
                            }
                        }

                        if ($interval->invert) {
                            $tempo_total_em_dias = -$tempo_total_em_dias;
                        }
                    } else {
                        $tempo_total_em_dias = 0;
                    }

                    $total_dias += $tempo_total_em_dias;

                    $acf_data[] = array(
                        'nome_da_empresa'  => sanitize_text_field($emprego['empresa']),
                        'data_de_admissao' => $formatted_data_admissao,
                        'data_de_demissao' => $formatted_data_demissao,
                        'tipo'             => sanitize_text_field($emprego['tipo_tempo']),
                        'tempo_total_em_dias' => $tempo_total_em_dias,
                    );
                }

                $anos = floor($total_dias / 365);
                $dias_remanescentes = $total_dias % 365;
                $meses = floor($dias_remanescentes / 30);
                $dias = $dias_remanescentes % 30;
                
                update_field('sexo', $genero, $post_id);
                update_field('telefone', $telefone, $post_id);
                update_field('email', $email, $post_id);
                update_field('data_de_nascimento', $data_nascimento->format('Y-m-d'), $post_id);
                update_field('idade', $diferenca->y, $post_id);
                update_field('anos_trabalhados', $anos, $post_id);
                update_field('meses_trabalhados', $meses, $post_id);
                update_field('dias_trabalhados', $dias, $post_id);

                update_field($field_key, $acf_data, $post_id);
            }
        }

        wp_send_json_success(array('post_id' => $post_id, 'total_dias' => $total_dias, 'anos_trabalhados' => $anos, 'meses_trabalhados' => $meses, 'dias_trabalhados' => $dias));
    } else {
        wp_send_json_error('Error creating post');
    }

    wp_die();
}

function generate_unique_user_creation_link($role = 'subscriber') {
    $token = wp_generate_password(20, false);

    $url = add_query_arg([
        'action' => 'create_user',
        'token' => $token,
        'role' => $role,
    ], site_url());

    update_option('user_creation_token_' . $token, $role);

    return $url;
}

function handle_user_creation_request() {
    if (isset($_GET['action']) && $_GET['action'] === 'create_user' && isset($_GET['token'])) {
        $token = sanitize_text_field($_GET['token']);
        $role = get_option('user_creation_token_' . $token);

        if ($role) {
            delete_option('user_creation_token_' . $token);

            wp_redirect(wp_registration_url());
            exit;
        } else {
            wp_die('Link inválido ou expirado.');
        }
    }
}
add_action('init', 'handle_user_creation_request');
$unique_link = generate_unique_user_creation_link('subscriber');

function modify_colaborador_capabilities() {
    $role = get_role('colaborador');
    
    if ($role) {
        $role->add_cap('edit_posts');
        $role->add_cap('publish_posts');
        $role->add_cap('edit_published_posts');
        $role->add_cap('delete_published_posts');

        $role->add_cap('edit_processos');
        $role->add_cap('publish_processos');
        $role->add_cap('edit_published_processos');
        $role->add_cap('delete_published_processos');

        $role->add_cap('edit_pessoas');
        $role->add_cap('publish_pessoas');
        $role->add_cap('edit_published_pessoas');
        $role->add_cap('delete_published_pessoas');
    }
}
add_action('init', 'modify_colaborador_capabilities');

function limit_post_categories_to_one() {
    global $pagenow;
    if ( $pagenow == 'post.php' || $pagenow == 'post-new.php' ) {
        ?>
        <script>
            jQuery(document).ready(function($) {
                var $categoryCheckBoxes = $('#categorychecklist input[type="checkbox"]');
                $categoryCheckBoxes.on('change', function() {
                    if ($(this).is(':checked')) {
                        $categoryCheckBoxes.not(this).prop('checked', false);
                    }
                });
            });
        </script>
        <?php
    }
}
add_action('admin_footer', 'limit_post_categories_to_one');

function custom_login_redirect($redirect_to, $request, $user) {
    if (isset($user->roles) && is_array($user->roles)) {
        if (in_array('administrator', $user->roles) || in_array('editor', $user->roles)) {
            return home_url('/wp-admin');
        } else {
            return home_url('/processos');
        }
    } else {
        return $redirect_to;
    }
}
add_filter('login_redirect', 'custom_login_redirect', 10, 3);

function disable_wp_login_page() {
    global $pagenow;
    if ($pagenow == 'wp-login.php' && !is_user_logged_in()) {
        wp_redirect(home_url('/login'));
        exit();
    }
}
// add_action('init', 'disable_wp_login_page');

function recaptcha() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['g-recaptcha-response'])) {
        $recaptcha_secret = '6LeOvyoqAAAAAE03ZefjzjgPrrwnB32Qplckafa6';
        $recaptcha_response = sanitize_text_field($_POST['g-recaptcha-response']);
        
        $response = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response");
        $responseKeys = json_decode(wp_remote_retrieve_body($response), true);

        if ($responseKeys["success"]) {
            echo "reCAPTCHA verified successfully!";
        } else {
            echo "reCAPTCHA verification failed!";
        }
    }
}
add_action('init', 'recaptcha');