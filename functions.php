<?php

//================================
// デバッグ
//================================
// デバッグフラグ

use function PHPSTORM_META\map;

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
        debug('get_main_title関数 ↓');
        debug($category_obj);
        return $category_obj[0]->name;
    } elseif (is_page()) { // 固定ページが表示されていたらtrueを返す

        debug('固定ページが表示されている処理');
        return get_the_title();
    } elseif (is_category() || is_tax()) { // カテゴリーページが表示されている場合にtrueを返す

        debug('カテゴリーページが表示されている処理');
        // 現在のカテゴリー名を出力するテンプレートタグ
        return single_cat_title();
    } elseif (is_search()) {

        return 'サイト内検索結果';
    } elseif (is_404()) {
        return 'ページが見つかりません';
    } elseif(is_singular('daily_contribution')){
        global $post;
        $term_obj = get_the_terms($post->ID, 'event');
        return $term_obj[0]->name;
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
    debug('get_specific_posts関数の処理スタート');
    
    if(!$term){
        // debug('nullの否定');
        $terms_obj = get_terms($taxonomy);
        // debug($terms_obj);
        $term = wp_list_pluck($terms_obj, 'slug');
    }

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

    // debug($args);

    $specific_posts = new WP_Query($args);

    // debug($specific_posts);

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
    } elseif (is_search() || is_404()) {
        return '<img src="' . get_template_directory_uri() . '/assets/images/bg-page-search.jpg" />';
    } else {
        return '<img src="' . get_template_directory_uri() . '/assets/images/bg-page-dummy.png" />';
    }
}

//================================
// ページネーション
//================================
function pagination($pages = '', $range = 2)
{
    debug('ページネーション関数: ' . $pages);
    // 表示するページ数（5ページ表示）
    $showitems = ($range * 2) + 1;

    // 現在のページの値
    global $paged;
    // デフォルトのページ
    if (empty($paged)) $paged = 1;

    if ($pages == '') {

        global $wp_query;
        $pages = $wp_query->max_num_pages; // 全ページを取得
        if (!$pages) { // 全ページ数が空の場合は1とする
            $pages = 1;
        }
    }

    if (1 != $pages) // 全ページが1でない場合はページネーションを表示する
    {
        // ダブルクォーテーションはそのままでは出力できないのでエスケープする
        echo "<div class=\"pagenation\">\n";
        echo "<ul>\n";

        // PREV：現在のページ値が1より大きい場合は表示
        if ($paged > 1) echo "<li class=\"prev\"><a href='" . get_pagenum_link($paged - 1) . "'>Prev</a></li>\n ";

        for ($i = 1; $i <= $pages; $i++) {
            if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
                // 三項演算子での条件分岐
                echo ($paged == $i) ? "<li class=\"active\">" . $i . "</li>\n" : "<li><a href='" . get_pagenum_link($i) . "'>" . $i . "</a></li>\n";
            }
        }

        // NEXT：総ページ数より現在のページ値が小さい場合は表示
        if ($paged < $pages) echo "<li class=\"next\"><a href='" . get_pagenum_link($paged + 1) . "'>Next</a></li>\n";
        echo "</ul>\n";
        echo "</div>\n";
    }
}

//================================
// 抜粋文の文字数を調整する
//================================
function cms_excerpt_more()
{
    return '...';
}
// 抜粋文の最後につく文字列を変更
add_filter('excerpt_more', 'cms_excerpt_more');

function cms_excerpt_length()
{
    return 80;
}
// 文字数を標準の110文字から80文字に変更する
add_filter('excerpt_mblength', 'cms_excerpt_length');

// 抜粋機能を固定ページに使えるように設定
add_post_type_support('page', 'excerpt');

function get_flexible_excerpt($number)
{
    $value = get_the_excerpt();
    $value = wp_trim_words( $value, $number, '...');
    return $value;
}

// get_the_excerpt関数で取得する文字列に改行タグを追加
function apply_excerpt_br($value)
{
    return nl2br($value);
}
add_filter('get_the_excerpt', 'apply_excerpt_br');

//================================
// ウィジェット機能を有効化
//================================
function theme_widgets_init()
{
    register_sidebar(array(
        'name'          => 'サイドバーウィジェットエリア',
        'id'            => 'primary-widget-area',
        'description'   => '固定ページのサイドバー',
        'before_widget' => '<aside class="side-inner">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h4 class="title">',
        'after_title'   => '</h4>'
    ));
}
add_action('widgets_init', 'theme_widgets_init');