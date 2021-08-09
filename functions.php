<?php

//================================
// デバッグ
//================================
// デバッグフラグ
$debug_flg = true;

// デバッグログ関数
function debug($str)
{
    global $debug_flg;

    if (!empty($debug_flg)) {
        if (gettype($str === 'array')) {
            error_log('DEBUG: ' . print_r($str, true));
        } else {
            error_log('DEBUG: ' . $str);
        }
    }
}

// 読み込むリソースをまとめる
function resource_enqueue_scripts()
{
    // 第一引数：スクリプトを区別するためのハンドル名を記述する（初期値：なし）
    // 第二引数：読み込みたいファイルまでのURLを指定（初期値：false）
    // 第三引数：このスクリプトより前に読み込まれるべきスクリプトがある場合に配列の中に指定（依存スクリプト）（初期値：array()）
    wp_enqueue_script('jquery');
    wp_enqueue_script('bundle_js', get_template_directory_uri() . '/assets/js/bundle.js', array());
    wp_enqueue_style('my_styles', get_template_directory_uri() . '/assets/css/styles.css', array());
}
add_action('wp_enqueue_scripts', 'resource_enqueue_scripts');


// カスタムメニューを作成する
register_nav_menus( // カスタムメニューを有効化するWordPress関数
    array(
        'place_global' => 'グローバル',
        'place_footer' => 'フッターナビ'
    )
);

// 固定ページのメイン画像上のテキストを出し分ける
function get_main_title()
{
    // 個別の投稿を表示中であるか判定する
    // 引数に投稿タイプを指定した場合、指定された投稿タイプの投稿が表示中であるか判定する
    if (is_singular('post')) {

        // 引数に投稿IDを指定することで、紐付いているカテゴリー情報をオブジェクトの配列形式で取得する
        $category_obj = get_the_category();

        // wp-content/debug.log へログを出力する
        debug($category_obj);

        return $category_obj[0]->name;
    } elseif (is_page()) { // 固定ページが表示されていたらtrueを返す

        debug('固定ページが表示されている処理');
        return get_the_title();
    } elseif (is_category()) { // カテゴリーページが表示されている場合にtrueを返す

        debug('カテゴリーページが表示されている処理');
        // 現在のカテゴリー名を出力するテンプレートタグ
        return single_cat_title();
    }
}

// 子ページを取得する関数
function get_child_page($number = -1)
{
    // $parent_id に格納されている値が、page-company.php と page-shop.php で
    // 表示される内容が異なる
    $parent_id = get_the_ID();

    debug('get_child_page関数　$parent_id: ' . $parent_id);

    $args = array(
        // 取得したい条件を指定、-1だと全件取得
        'posts_per_page' => -1,
        // 取得したい投稿タイプを指定、「page」は固定ページを取得する
        'post_type'      => 'page',
        // 並び順を指定する（Step4-2で指定した並び順）
        'orderby'        => 'menu_order',
        // 取得した情報を昇順に並び替える
        'order'          => 'ASC',
        // 表示したい子ページが紐づく親ページをの記事IDを指定することで、その親ページに紐づく子ページの情報を取得できる
        'post_parent'    => $parent_id
    );

    $child_pages = new WP_Query($args);
    return $child_pages;
}
