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
            error_log('DEBUG: ========================');
        } else {
            error_log('DEBUG: ' . $str);
            error_log('DEBUG: ========================');
        }
    }
}


//================================
// 各種関数
//================================
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
function get_child_page($number = -1, $specified_id = null)
{
    // Step4-8-2で追加
    if (isset($specified_id)) {
        $parent_id = $specified_id;
    } else {
        // $parent_id に格納されている値が、page-company.php と page-shop.php で
        // 表示される内容が異なる
        $parent_id = get_the_ID();
    }

    debug('get_child_page関数　$parent_id: ' . $parent_id);

    $args = array(
        // 取得したい条件を指定、-1だと全件取得
        'posts_per_page' => $number,
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

// 特定の記事を抽出する関数
// 第一引数：投稿タイプ
// 第二引数：取得したい記事に紐づくタームが属するタクソノミーのスラッグ
// 第三引数：記事が紐づくタームのスラッグ
// 第四引数：取得したい記事数を指定する
// 第一引数から第三引数はデフォルト値を指定していおかないとエラーになる
function get_specific_posts($post_type, $taxonomy = null, $term = null, $number = -1)
{
    $args = [
        // 取得したい投稿タイプを指定
        'post_type'   => $post_type,
        // tax_queryは記事を柔軟に取得できるようにタクソノミーに関する指定ができるパラメータ
        // 配列形式でパラメーターを渡す必要がある
        'tax_query'   => [
            [
                'taxonomy' => $taxonomy,
                'field'    => 'slug',
                'terms'    => $term
            ],
        ],
        'posts_per_page'   => $number,
    ];
    
    $specific_posts = new WP_Query($args);

    debug($specific_posts);

    return $specific_posts;
}


//================================
// アイキャッチ表示
//================================
// サムネイル表示の有効化
add_theme_support('post-thumbnails');

// トップページのメイン画像用のサイズ指定
add_image_size('top', '1077', '622', true);

// 地域貢献活動一覧用画像のサイズ指定
add_image_size('contribution', '557', '280', true);

// トップページの地域貢献活動にて使用している画像用のサイズ指定
add_image_size('front-contribution', '255', '189', true);

// 企業情報・店舗情報一覧画像用のサイズ指定
add_image_size('common', '465', '252', true);

// 各ページのメイン画像用のサイズ指定
add_image_size('detail', '1100', '300', true);

// 検索一覧画像用のサイズ指定
add_image_size('search', '168', '168', true);

//================================
// メイン画像の表示
//================================
// 各テンプレートごとのメイン画像を表示
function get_main_image()
{
    global $post;

    if (is_page()) {
        return get_the_post_thumbnail($post->ID, 'detail');
    } elseif (is_category('news') || is_singular('post')) {
        return '<img src="' . get_template_directory_uri() . '/assets/images/bg-page-news.jpg" />';
    } else {
        return '<img src="' . get_template_directory_uri() . '/assets/images/bg-page-dummy.png" />';
    }
}

