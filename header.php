<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?> itemscope itemtype="http://schema.org/WebPage">
	<head>
	<?php echo '<meta charset="' . get_bloginfo('charset').'" />'.PHP_EOL; ?>
		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?>>

	<header>
        <div class="container">
            <a href="<?=get_home_url()?>" class="logo-link">
                <img src="<?=get_template_directory_uri()?>/assets/img/logo-dark.svg" alt="Logo image" />
            </a>
            <div class="menu-wrap">
                <nav class='header-menu' role='navigation'>
                    <ul>
                        <li class="has-children"><a href="">Home</a></li>
                        <li class="has-children"><a href="">Pages</a></li>
                        <li class="has-children"><a href="">Blog</a></li>
                        <li class="has-children"><a href="">Demos</a></li>
                        <li class="has-children"><a href="">Docs</a></li>
                    </ul>
                    <a href="javascript:void(0);" class="close-menu">
                        <img src="<?=get_template_directory_uri()?>/assets/img/close.svg" alt="Open mobile menu">
                    </a>
                </nav>
                <a href="" class="buy-link">Buy Now</a>
                <a href="javascript:void(0);" class="open-menu">
                    <img src="<?=get_template_directory_uri()?>/assets/img/humburger.svg" alt="Open mobile menu">
                </a>
            </div>
        </div>
    </header>

    <main>


