<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	
	<?php
		wp_head();

		global $current_user;
		wp_get_current_user();
	?>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<title><?php echo get_bloginfo('name') . ' — ' . get_the_title(); ?></title>
</head>

<body <?php body_class($post->post_name ?? ''); ?>>
	<header class="header">
		<div class="wrapper header__content">
			<a href="<?php echo esc_url(get_home_url()); ?>" title="Home Project Title">
				<h1 class="header__logo">
					<?php echo get_the_title(); ?>
					<img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/logo-w.svg'); ?>" alt="<?php echo get_the_title(); ?>">
				</h1>
			</a>
		
			<nav class="header__menu">
				<?php
				$header_menu = wp_get_nav_menu_items('Menu');
				if(is_array($header_menu)){
					foreach($header_menu as $key => $menu_item){
						echo '<a title="'. str_replace('*', '', $menu_item->title) .'" href="'.$menu_item->url.'" class="header__item '. $menu_item->classes[0] . (get_the_ID() == $menu_item->object_id ? ' header__item--active' : '') .'" target="'.$menu_item->target.'">';
							$menu_title = $menu_item->title;
							if (strpos($menu_item->title, '*') !== false) {
								$menu_title = str_replace('*', '', $menu_item->title);
							}
							echo $menu_title;
						echo '</a>';
					}
				}
				?>
			</nav>

			<div class="header__button">
				<span class="bar bar1"></span>
				<span class="bar bar2"></span>
				<span class="bar bar3"></span>
			</div>
		</div>
	</header>

	<main>