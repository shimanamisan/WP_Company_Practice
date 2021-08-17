<article class="article-card">
    <a
        href="<?php echo get_term_link($term); ?>"
        class="cars-link"
    >
        <!-- <div class="image"><?php // the_post_thumbnail('contribution'); // 記事に紐付いた画像を表示させる ?></div> -->
        <div class="image"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/bg-page-dummy.png" alt=""></div>
        <div class="body">
            <p class="name"><?php echo $term->name; ?></p>
            <p class="excerpt">
                <?php
                    // 該当ページの抜粋データを取得する
                    // 抜粋データがない場合は本文を取得する
                    echo $term->description; 
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