<!doctype html>
<html <?php language_attributes();?>>

<head>
    <?php $path = get_template_directory_uri(); ?>
    
    <link rel="stylesheet" href="<?php echo $path.'/css/main.css?ver=' . CSS_VERSION; ?>">
    <link rel="stylesheet" href="<?php echo $path.'/css/style-original.min.css'; ?>" async>
     
    <?php 
        if ( is_page( [435, 1254, 5957, 1344, 1348, 1342, 1254, 1346, 12462, 12464, 12427, 3050, 1974, 2789, 1098, 19467, 59935, 59964, 59959, 59949, 59969, 59995, 60000, 59954, 59990, 59941, 59977, 60014, 59985, 60005, 60019, 27412] ) ) {
            add_filter( 'wpseo_canonical', '__return_false' );
            add_filter( 'wpml_head_langs', '__return_false');
        }
    ?>

    <?php echo isset($args['blog_tags']) ? $args['blog_tags'] : ''; ?>

    <?php wp_head(); ?>

    <meta charset="UTF-8">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="profile" href="https://gmpg.org/xfn/11" />
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="msvalidate.01" content="D148DF86A03A6781A1758D6BDADD9DA0" />

    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo $path; ?>/img/icons/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $path; ?>/img/icons/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $path; ?>/img/icons/favicon/favicon-16x16.png">
    <link rel="mask-icon" href="<?php echo $path; ?>/img/icons/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="<?php echo $path; ?>/img/icons/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="<?php echo $path; ?>/img/icons/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <?php include_once('Scripts/HeaderScripts.php'); ?>
</head>

<body <?php body_class(); ?>>
    <?php 
        include_once('Scripts/BodyScripts.php');
        wp_body_open();
        
        $siteLogoUrl = "https://www.globkurier.pl";
        if(defined("ICL_LANGUAGE_CODE")) {
            if(ICL_LANGUAGE_CODE == 'en') {
                $siteLogoUrl = "https://globkurier.co.uk/";
            } elseif(ICL_LANGUAGE_CODE == 'es') {
                $siteLogoUrl = "https://globkurier.es/";
            }
        }
    ?>

    <!-- NAWIGACJA -->
    <div class="cboot upper-menu" style="z-index: 100000; background-color: white; position: relative; width: 100%;">
        <div class="container upper-menu-wrapper">
            <div class="upper-menu-switcher-wrapper">
                <img class="upper-menu-switcher" src="<?php echo $path; ?>/assets/img/upper-switcher.svg" width="35" height="35" alt="Icon" />
                <div id="upper-expandable-menu-desktop" class="upper-menu-dm">
                    <div class="ex-upper-menu-wrapper">
                        <div class="border"></div>                    
                        <div class="buttons">
                            <a class="login" href="https://www.globkurier.pl/dashboard">
                                <button><?php _e('Zaloguj się', 'globkurier_header'); ?></button>
                            </a>
                            <div class="text-line"><?php _e('Nie masz konta?', 'globkurier_header'); ?></div>
                            <a class="register" href="https://www.globkurier.pl/register">
                                <button><?php _e('Załóż konto', 'globkurier_header'); ?></button>
                            </a>
                        </div>
                        <div class="menu">
                            <?php wp_nav_menu([
                                'menu' => 'Menu główne górne v2.0', 
                                'theme_location' => 'upper-v2',
                            ]);?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="language-switcher">
                <?php dynamic_sidebar('language_switcher_widget'); ?>
            </div>
        </div>
    </div>
    <div id="menu-desktop" class="cboot" style="z-index: 10000; position: relative; width: 100%;">
        <div class="container">
            <nav id="navbar-holder" class="navbar navbar-expand-lg navbar-light m-0 p-0" role="navigation">
                <a class="navbar-brand" href="<?php echo $siteLogoUrl; ?>" rel="noreferrer" aria-label="Homepage">
                    <img id="logo-text" class="menu-logo-text" src="<?php echo get_logo_url_by_language(); ?>" alt="Logo"
                        width="208" height="52" />
                </a>
                <div class="main-menu-wrapper">
                    <?php wp_nav_menu([
                        'menu' => 'Menu Główne v2.0', 
                        'theme_location' => 'primary-v2',
                    ]);?>
                </div>
                <div class="ml-auto">
                    <form id="search-menu-form">
                        <input type="search" placeholder="<?php _e('Śledzenie przesyłki', 'globkurier_header'); ?>">
                        <button type="submit">Search</button>
                    </form>
                    <a class="menu-button search-btn" href="https://www.globkurier.pl/search"><?php _e('Wyceń przesyłkę', 'globkurier'); ?></a>
                </div>
                <div class="menu-hover">
                    <div class="hover-wrapper">
                        <div class="left-menu"></div>
                        <div class="right-menu">
                            <div class="wrapper"></div>
                            <div class="see-more"><?php _e('Zobacz więcej', 'globkurier'); ?></div>
                        </div>
                    </div>
                </div>
            </nav>
            <div id="menu-mobile">
                <a class="navbar-brand" href="<?php echo $siteLogoUrl; ?>" rel="noreferrer" aria-label="Homepage">
                    <img id="logo-text" class="menu-logo-text" src="<?php echo get_logo_url_by_language(); ?>" alt="Logo"
                        width="210" height="52" />
                </a>
                <div class="wrapp">
                    <div class="language-switcher">
                        <?php dynamic_sidebar('language_switcher_widget'); ?>
                    </div>
                    <img class="upper-menu-switcher" src="<?php echo $path; ?>/assets/img/upper-switcher.svg" width="40" height="40" alt="Icon">
                    <div class="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="cboot">
            <div class="breadcrumb-background">
                <div class="container">
                    <?php dynamic_sidebar('breadcrumbs_widget'); ?>
                </div>
            </div>
        </div>
    </div>

    <div id="upper-expandable-menu" class="upper-menu-dm">
        <div class="ex-upper-menu-wrapper">       
            <div class="ex-menu-header">
                <div class="close-button">&#10006;</div>
                <span><?php  _e('Moje konto', 'globkurier_header'); ?></span>
            </div>
            <div class="buttons">
                <a class="login" href="https://www.globkurier.pl/dashboard">
                    <button><?php _e('Zaloguj się', 'globkurier_header'); ?></button>
                </a>
                <div class="text-line"><?php _e('Nie masz konta?', 'globkurier_header'); ?></div>
                <a class="register" href="https://www.globkurier.pl/register">
                    <button><?php _e('Załóż konto', 'globkurier_header'); ?></button>
                </a>
            </div>
            <div class="menu">
                <?php wp_nav_menu([
                    'menu' => 'Menu główne górne v2.0', 
                    'theme_location' => 'upper-v2',
                ]);?>
            </div>
        </div>
    </div>

    <div class="mobile-expandable-menu">
        <div class="mobile-menu-wrapper">
            <div class="mob-ex-header">
                <div class="close-button">&#10006;</div>
                <div class="title" data-default="<?php _e('Menu', 'globkurier_header'); ?>"><?php _e('Menu', 'globkurier_header'); ?></div>
            </div>
            <div class="inside-wrapper">
                <div class="search-wrapper">
                    <form id="search-menu-form-mobile">
                        <input type="search" placeholder="<?php _e('Śledzenie przesyłki', 'globkurier_header'); ?>">
                        <button type="submit">Search</button>
                    </form>
                </div>
                <div class="btn-wrapper">
                    <a class="menu-button search-btn" href="https://www.globkurier.pl/search"><?php _e('Wyceń przesyłkę', 'globkurier'); ?></a>
                </div>
                <div class="menu-list">
                    <?php wp_nav_menu([
                        'menu' => 'Menu główne v2.0', 
                        'theme_location' => 'primary-v2',
                    ]);?>
                </div>
                <div class="menu-append-list">
                    <div class="go-back"><?php _e('Wróć', 'globkurier'); ?></div>
                    <div class="list"></div>
                </div>
                <div class="menu-append-list sub">
                    <div class="go-back"><?php _e('Wróć', 'globkurier'); ?></div>
                    <div class="list"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-aple"></div>
