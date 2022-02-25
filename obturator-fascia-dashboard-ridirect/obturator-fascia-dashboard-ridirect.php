<?php
/*
Plugin Name: Obturator Fascia (ダッシュボード閉鎖)
Description: 管理者以外のダッシュボードへのアクセスを禁止するプラグイン。ついでにログアウト時に公開側ページにリダイレクトしてログインページもある程度秘匿する。
Version:     0.0.1
Author:      アルム＝バンド
*/

/**
 * ログイン時に管理者権限以外のユーザはリダイレクトさせる
 *
 * @param string $user_login
 * @param array $user
 *
 */
function obturator_fascia_login_redirect( $user_login, $user ) {
    if ( 'administrator' !== $user->roles[0] && 'semiadmin' !== $user->roles[0] ) {
        wp_safe_redirect( home_url(), 301 );
        exit();
    }
}
add_action( 'wp_login', 'obturator_fascia_login_redirect', 10, 2 );

/**
 * ログアウト時に管理者権限以外のユーザはリダイレクトさせる
 *
 */
function obturator_fascia_logout_redirect() {
    if ( ! current_user_can( 'administrator' ) && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
        wp_safe_redirect( home_url(), 301 );
        exit;
    }
}
add_action( 'wp_logout', 'obturator_fascia_logout_redirect', 10, 2 );

/**
 * 管理画面アクセス時に管理者権限以外のユーザはリダイレクトさせる
 *
 */
function obturator_fascia_restrict_admin() {
    if ( ! current_user_can( 'administrator' ) && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
        wp_safe_redirect( home_url(), 301 );
        exit;
    }
}
add_action( 'admin_init', 'obturator_fascia_restrict_admin', 1 );
