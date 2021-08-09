<li class="common-item">
    <a
        class="common-link"
        href="<?php the_permalink(); ?>"
    >
        <div class="common-image">
            <?php the_post_thumbnail(); // 記事に紐付いた画像を表示させる ?>
        </div>
        <div class="common-body">
            <p class="name"><?php the_title(); ?></p>
            <p class="caption">
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
</li>