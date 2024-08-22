<?php
/**
 * Declare all used post types
 */
function ks_register_post_types(){

    $def_posttype_args = array(

        'labels'             => array(),
        'description'        => '',
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => '',
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 4,
        'supports'           => array('title', 'thumbnail', 'editor', 'author', 'excerpt', 'page-attributes' ),
        'show_in_rest'		 => true

    );

    $def_taxonomy_args = array(
        'hierarchical'      => true,
        'labels'            => array(),
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => '',
        'show_in_rest'		 => true,
        'show_in_quick_edit' => true,
    );

    $posttypes = array(

        'pessoas' => array(

            'labels' => array(
                'name'               => __('Pessoas'),
                'singular_name'      => __('Pessoa'),
                'menu_name'          => __('Pessoas'),
                'name_admin_bar'     => __('Pessoas'),
                'add_new'            => __('Nova Pessoa'),
                'add_new_item'       => __('Nova Pessoa'),
                'new_item'           => __('Nova Pessoa'),
                'edit_item'          => __('Editar Pessoa'),
                'view_item'          => __('Ver Pessoa'),
                'all_items'          => __('Pessoas'),
                'search_items'       => __('Procurar por Pessoas'),
                'parent_item_colon'  => __('Pessoas pai:'),
                'not_found'          => __('Nenhum Pessoa encontrado.'),
                'not_found_in_trash' => __('Nenhum Pessoa encontrado na lixeira.')
            ),
            'menu_icon' => 'dashicons-universal-access-alt',
            'description' => __('Pessoas'),
            'rest_base' =>'custom/pessoas',
            'has_archive' => 'biblioteca/pessoas',
            'rewrite'     => [
                'slug' => 'pessoas',
            ],
            'supports'    => array('title', 'thumbnail', 'editor'),
            'show_in_rest' => false,  // @info inherited from old version
        ),

        // 'eventos' => array(

        //     'labels' => array(
        //         'name'               => __('Eventos'),
        //         'singular_name'      => __('Evento'),
        //         'menu_name'          => __('Eventos'),
        //         'name_admin_bar'     => __('Eventos'),
        //         'add_new'            => __('Novo Evento'),
        //         'add_new_item'       => __('Novo Evento'),
        //         'new_item'           => __('Novo Evento'),
        //         'edit_item'          => __('Editar Evento'),
        //         'view_item'          => __('Ver Evento'),
        //         'all_items'          => __('Eventos'),
        //         'search_items'       => __('Procurar por Eventos'),
        //         'parent_item_colon'  => __('Eventos pai:'),
        //         'not_found'          => __('Nenhum Evento encontrado.'),
        //         'not_found_in_trash' => __('Nenhum Evento encontrado na lixeira.')
        //     ),
        //     'menu_icon' => 'dashicons-admin-site-alt',
        //     'description' => __('Eventos'),
        //     'rest_base' =>'custom/eventos',
        //     'has_archive' => 'biblioteca/eventos',
        //     'rewrite'     => [
        //         'slug' => 'eventos',
        //     ],
        //     'supports'    => array('title', 'editor', 'thumbnail', 'excerpt'),
        //     'show_in_rest' => false,  // @info inherited from old version
        // ),

		// 'podcast' => array(

        //     'labels' => array(
        //         'name'               => __('Podcasts'),
        //         'singular_name'      => __('Podcast'),
        //         'menu_name'          => __('Podcasts'),
        //         'name_admin_bar'     => __('Podcasts'),
        //         'add_new'            => __('Novo Post'),
        //         'add_new_item'       => __('Novo Post'),
        //         'new_item'           => __('Novo Post'),
        //         'edit_item'          => __('Editar Post'),
        //         'view_item'          => __('Ver Post'),
        //         'all_items'          => __('Posts'),
        //         'search_items'       => __('Procurar por Posts'),
        //         'parent_item_colon'  => __('Posts pai:'),
        //         'not_found'          => __('Nenhum Post encontrado.'),
        //         'not_found_in_trash' => __('Nenhum Post encontrado na lixeira.')
		// 	),
		// 	'menu_position' => 2,
        //     'menu_icon' => 'dashicons-megaphone',
        //     'description' => __('Podcasts'),
        //     'rest_base' =>'custom/podcasts',
        //     'has_archive' => 'biblioteca/podcasts',
        //     'rewrite'     => [
        //     	'slug' => 'podcasts/post',
        //     ],
        //     'supports'    => array('title', 'editor', 'thumbnail'),
        //     'taxonomy'    => array(

        //         'podcasts_categories' => array(

        //             'hierarchical'      => true,
        //             'labels'            => array(
        //                 'name'              => __('Categorias'),
        //                 'singular_name'     => __('Categoria'),
        //                 'search_items'      => __('Procurar por categoria' ),
        //                 'all_items'         => __('Categorias' ),
        //                 'parent_item'       => __('Categoria Pai' ),
        //                 'parent_item_colon' => __('Categorias Pai:' ),
        //                 'edit_item'         => __('Editar Categoria' ),
        //                 'update_item'       => __('Atualizar Categoria' ),
        //                 'add_new_item'      => __('Nova Categoria' ),
        //                 'new_item_name'     => __('Nova Categoria' ),
        //                 'menu_name'         => __('Categorias' ),
        //             ),

        //             'show_ui'           => true,
        //             'show_admin_column' => true,
        //             'query_var'         => true,
		// 			'rewrite'           => array('slug' => 'podcasts/categorias'),
		// 			'show_in_rest'      => true,
        //             'rest_base'         => 'podcasts_categories'

        //         ),

        //     ),

		// ),

    );

    foreach ($posttypes as $posttype => $options) {

        $args = array_merge($def_posttype_args, $options);

        if(isset($args['taxonomy'])){

            $taxonomies = $args['taxonomy'];

            foreach($taxonomies as $taxonomy => $taxonomy_args){

                $taxonomy_args = array_merge($def_taxonomy_args, $taxonomy_args);

                register_taxonomy($taxonomy, array($posttype), $taxonomy_args);

            }

            unset($args['taxonomy']);

        }

        register_post_type($posttype, $args);

    }

}

add_action('init', 'ks_register_post_types', 10 );

/**
 * Change Native Posts labels
 */
function ks_change_post_label() {

    global $menu;
	global $submenu;

    $menu[5][0] = 'Processos';
    $submenu['edit.php'][5][0] = 'Processos';
    $submenu['edit.php'][10][0] = 'Adicionar Processo';

}

add_action( 'admin_menu', 'ks_change_post_label' );

function ks_change_post_object() {

	global $wp_post_types;

    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Processos';
    $labels->singular_name = 'Processos';
	$labels->menu_name = 'Processos';
	$labels->name_admin_bar = 'Processos';
    $labels->add_new = 'Novo Processo';
    $labels->add_new_item = 'Novo Processo';
    $labels->new_item = 'Novo Processo';
    $labels->edit_item = 'Editar Processo';
    $labels->view_item = 'Ver Processo';
    $labels->all_items = 'Processos';
	$labels->search_items = 'Procurar Processos';
	$labels->parent_item_colon = 'Processos pai:';
    $labels->not_found = 'Nenhuma Processo encontrada';
	$labels->not_found_in_trash = 'Nenhuma Processo encontrada na lixeira';

}

add_action( 'init', 'ks_change_post_object' );
