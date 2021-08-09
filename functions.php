<?php

//================================
// デバッグ
//================================
//デバッグフラグ
$debug_flg = true;

//デバッグログ関数
function debug($str)
{
    global $debug_flg;
    if (!empty($debug_flg)) {
        error_log($str);
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
    if(is_singular('post')){

        // 引数に投稿IDを指定することで、紐付いているカテゴリー情報をオブジェクトの配列形式で取得する
        $category_obj = get_the_category();

        // wp-content/debug.log へログを出力する
        debug(print_r($category_obj, true));

        return $category_obj[0]->name;
    }elseif(is_page()){ // 固定ページが表示されていたらtrueを返す
        return get_the_title();
    }elseif(is_category()){ // カテゴリーページが表示されている場合にtrueを返す

        // 現在のカテゴリー名を出力するテンプレートタグ
        return single_cat_title();
    }
}