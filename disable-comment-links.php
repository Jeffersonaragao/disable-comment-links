<?php
/*
Plugin Name: Disable Comment Links
Plugin URI: https://reservasite.com.br
Description: This plugin prevents users from adding hyperlinks within comments on your WordPress site.
Version: 1.0.0
Author: Jefferson Aragão
Author URI: https://reservasite.com.br
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

// Plugin functionality

function disable_comment_links( $data ) {
    // Check if the comment contains any link
    if ( preg_match( '/http(s)?:\/\//i', $data['comment_content'] ) ) {
        // If it contains a link, show an error message and prevent comment submission
        wp_die( 'Sorry, adding links in comments is not allowed.' );
    }

    // Check if the comment contains any prohibited patterns
    $prohibited_patterns = array(
        '/www\./i',
        '/\.com/i',
        '/\.br/i',
        '/\.org/i',
        '/\.in/i',
        '/http/i',
        '/\.ac/i',
        '/\.audio/i',
        '/\.al/i',
        '/\.be/i',
        '/\.cn/i',
        '/\.us/i',
        '/\.co/i',
        '/\.net/i',
        '/\.pt/i',
        '/\.eu/i',
        '/\.ru/i'
        // Add more patterns as needed
    );

    foreach ( $prohibited_patterns as $pattern ) {
        if ( preg_match( $pattern, $data['comment_content'] ) ) {
            // If it contains a prohibited pattern, show an error message and prevent comment submission
            wp_die( 'Sorry, adding links in comments is not allowed.' );
        }
    }

    return $data;
}
add_filter( 'preprocess_comment', 'disable_comment_links' );

// Adicionar menu no painel de administração
function donation_plugin_menu() {
    add_menu_page(
        'Disable Comment Links', // Título da página
        'Disable Comment Links', // Nome no menu
        'manage_options', // Capacidade necessária para acessar
        'disable-comment-links-settings', // Slug da página
        'disable_comment_links_settings_page', // Função de renderização da página
        'dashicons-admin-links', // Ícone para o menu (troque para outro ícone se preferir)
        80 // Posição do menu
    );
}
add_action('admin_menu', 'donation_plugin_menu');

// Página de configurações do plugin
function disable_comment_links_settings_page() {
    ?>
    <div class="wrap">
        <h1>Disable Comment Links Settings</h1>
        <p>Welcome to the settings page for the Disable Comment Links plugin.</p>
        <p>This plugin is crucial in preventing spam and enhancing the security of your website by disabling hyperlinks within comments.</p>
        <!-- Conteúdo da página de configurações -->
        <h1>Donation</h1>
        <p>Thank you for considering supporting our plugin! Your contributions help us improve and maintain this plugin.</p>
        <p>You can make a.</p>
        <a href="https://www.paypal.com/donate/?hosted_button_id=PM5AKF845TX6C" target="_blank" style="display: inline-block; padding: 10px 20px; background-color: #0073aa; color: #fff; text-decoration: none; border-radius: 5px;">donation here</a>
    </div>
    <?php
}

