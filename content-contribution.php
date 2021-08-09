<article class="article-card">
    <a
        href="<?php the_permalink(); ?>"
        class="cars-link"
    >
        <div class="image"><?php the_post_thumbnail(); // 記事に紐付いた画像を表示させる ?></div>
        <div class="body">
            <time><?php the_time('Y.m.d'); ?></p></time>
            <p class="name"><?php the_title(); ?></p>
            <p class="excerpt">
                <?php
                    // 該当ページの抜粋データを取得する
                    // 抜粋データがない場合は本文を取得する
                    echo get_the_excerpt(); 
                ?>
            </p>
            <div class="buttonBox">
                <button
                    type="button"
                    class="seeDetail"
                >MORE</button>
            </div>
        </div>
    </a>
</article>