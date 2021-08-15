<?php
/*
Plugin Name: Search Highlighter
Description: Highlight searched words when you search
Version: 1.0
Author: PACIFIC MALL DEVELOPMENT
Author URI: http://wp.example.com/
*/

class SearchHighlighter 
{
    private $debug_flg = false;

    public function __construct()
    {
        add_filter('the_title', array($this, 'highlight_keywords'));
        add_filter('get_the_excerpt', array($this, 'highlight_keywords'));
    }

    public function highlight_keywords($text)
    {
        $this->debug($this);
        if(is_search()){
            // 検索文字列を取得して空白でキーワードを分割する
            // 戻り値は配列
            $keys = explode(' ', get_search_query());
            foreach($keys as $key){
                $text = str_replace($key, '<span style="background: #ffff00">' . $key . '</span>', $text);
            }
        }

        return $text;
    }

    // デバッグ関数
    private function debug($str)
    {
        if (!empty($this->debug_flg)) {
            if (gettype($str === 'array')) {
                error_log('DEBUG: ' . print_r($str, true));
                error_log('DEBUG: ========================');
            } else {
                error_log('DEBUG: ' . $str);
                error_log('DEBUG: ========================');
            }
        }
    }
}

$SearchHighlighter = new SearchHighlighter();