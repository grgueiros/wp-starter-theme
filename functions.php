<?php

add_theme_support('post-thumbnails');


function axs_theme_init()
{
    wp_register_script('main-js', get_template_directory_uri() . '/dist/js/main.min.js', array('jquery'), '1.0.0');
    wp_enqueue_script('main-js');

    wp_register_style('main-css', get_template_directory_uri() . '/dist/css/main.min.css');
    wp_enqueue_style('main-css');
}
add_action('wp_enqueue_scripts', 'axs_theme_init');

/* REGISTRO DE PAGINA DE CONFIGURACOES */
setup_options_page();
function setup_options_page()
{

    if (function_exists('acf_add_options_page')) {

        $option_page = acf_add_options_page(array(
            'page_title'     => 'Configurações Gerais',
            'menu_title'     => 'Configurações Gerais',
            'menu_slug'     => 'configuracoes-gerais',
            'capability'     => 'edit_posts',
            'redirect'     => false
        ));
    }
}


function axs_custom_excerpts($limit)
{
  return wp_trim_words(get_the_excerpt(), $limit);
}



/* PREVINIR ATUALIZACOES INDESEJADAS */
function filter_plugin_updates( $value ) {
    unset( $value->response['advanced-custom-fields-pro/acf.php'] );
    return $value;
}
add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );