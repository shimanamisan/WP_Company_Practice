<div class="news">
    <!-- 作成時間を出力 -->
    <time class="time"><?php the_time('Y.m.d');?></time>
    <!-- 記事のタイトルを出力 -->
    <p class='title'><?php the_title(); ?></p>
    <div class="news-body">
        <!-- 固定ページ記事本文を出力 -->
        <?php the_content(); ?>
    </div>
</div>
<div class="more-news">
    <div class="next">
        <a
            class="another-link"
            href="#"
        >NEXT</a>
    </div>
    <div class="prev">
        <a
            class="another-link"
            href="#"
        >PREV</a>
    </div>
</div>