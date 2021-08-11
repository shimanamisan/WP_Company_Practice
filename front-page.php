<?php get_header(); ?>

<section
    class="section-contents"
    id="shop"
>
    <div class="wrapper">
        <?php

        // 引数に固定ページのスラッグを指定することで、そのページのオブジェクトを取得することが出来る
        // 店舗情報を取得したいので親ページの店舗情報のスラッグを指定している
        // 子ページのオブジェクトを取得したい場合は、('親ページ/子ページ') のように指定する
        $shop_obj = get_page_by_path('shop');
        $post = $shop_obj;

        // 引数に投稿オブジェクトを指定
        // WordPressの多くのテンプレートタグが参照する各種グローバル変数へ指定した投稿情報をセットする
        // setup_postdata() から wp_reset_postdata() で使用されているテンプレートタグは、指定した投稿情報を元に実行される
        // setup_postdataをメインクエリに戻すときは wp_reset_postdata() を実行する必要がある
        setup_postdata($post);
        $shop_title = get_the_title();

        ?>
        <span class="section-title-en">Shop Information</span>
        <h2 class="section-title"><?php the_title(); ?></h2>
        <p class="section-lead"><?php echo get_the_excerpt(); ?></p>
        <?php wp_reset_postdata(); ?>
        <ul class="shops">
            <?php

            // 作成した子ページを取得する関数を実行
            // 店舗情報の固定ページ情報を取得できるようにfunctions.php を修正
            $shop_page = get_child_page(4, $shop_obj->ID);

            if ($shop_page->have_posts()) {

                while ($shop_page->have_posts()) {

                    $shop_page->the_post();

            ?>
            <li class="shops-item">
                <a
                    class="shop-link"
                    href="<?php the_permalink(); ?>"
                >
                    <div class="shop-image"><?php the_post_thumbnail('common'); ?></div>
                    <div class="shop-body">
                        <p class="name"><?php the_title(); ?></p>
                        <p class="location"></p>
                        <div class="buttonBox">
                            <button
                                type="button"
                                class="seeDetail"
                            >MORE</button>
                        </div>
                    </div>
                </a>
            </li>
            <?php

                } // endwhile
                wp_reset_postdata();
            } // endif

            ?>
        </ul>
        <div class="section-buttons">
            <button
                type="button"
                class="button button-ghost"
                onclick="javascript:location.href = '<?php echo esc_url(home_url('shop')); ?>';"
            >
                <?php echo $shop_title; ?>一覧を見る
            </button>
        </div>
    </div>
</section>
<section
    class="section-contents"
    id="contribution"
>
    <div class="wrapper">
        <?php

        // 地域貢献ページ取得の準備
        $contribution_obj = get_page_by_path('contribution');
        $post = $contribution_obj;
        setup_postdata($post);
        $contribution_title = get_the_title();

        ?>
        <span class="section-title-en">Regional Contribution</span>
        <h2 class="section-title"><?php the_title(); ?></h2>
        <p class="section-lead"><?php echo get_the_excerpt(); ?></p>
        <?php wp_reset_postdata(); ?>
        <div class="articles">
            <?php

            $contribution_page = get_child_page(3, $contribution_obj->ID);
            if ($contribution_page->have_posts()) {
                while ($contribution_page->have_posts()) {
                    $contribution_page->the_post();

            ?>
            <article class="article-card">
                <a
                    class="card-link"
                    href="<?php the_permalink(); ?>"
                >
                    <div class="card-inner">
                        <div class="card-image"><?php the_post_thumbnail('front-contribution'); ?></div>
                        <div class="card-body">
                            <p class="title"><?php the_title(); ?></p>
                            <p class="excerpt"><?php echo get_the_excerpt(); ?></p>
                            <div class="buttonBox">
                                <button
                                    type="button"
                                    class="seeDetail"
                                >MORE</button>
                            </div>
                        </div>
                    </div>
                </a>
            </article>
            <?php
                } // endwhile
                wp_reset_postdata();
            } // endif
            ?>
        </div>
        <div class="section-buttons">
            <button
                type="button"
                class="button button-ghost"
                onclick="javascript:location.href = '<?php echo esc_url(home_url('contribution')); ?>';"
            >
                <?php echo $contribution_title; ?>一覧を見る
            </button>
        </div>
    </div>
</section>




<section
    class="section-contents"
    id="news"
>
    <div class="wrapper">
        <?php $term_obj = get_term_by('slug', 'news', 'category'); ?>
        <span class="section-title-en">News Release</span>
        <h2 class="section-title"><?php echo $term_obj->name; ?></h2>
        <p class="section-lead"><?php echo $term_obj->description; ?></p>
        <ul class="news">
        <?php

        $news_pages = get_specific_posts('post', 'category', 'news', 3);

        if ($news_pages->have_posts()) {
            while ($news_pages->have_posts()) {
                $news_pages->the_post();

        ?>
            <li class="news-item">
                <a
                    class="detail-link"
                    href="<?php the_permalink(); ?>"
                >
                    <time class="time"><?php the_time('Y.m.d');?></time>
                    <p class="title"><?php the_title(); ?></p>
                    <p class="news-text"><?php echo get_the_excerpt(); ?></p>
                    <!-- <p class="news-text">パシフィックモール株式会社（以下、当社）は、インド共和国（以下、インド）において、Mecha-India（以下、メカ・インディア）との協業を開始します。
                        Mecha-Indiaは、インドにおける配車サービス大手であり、電 [&hellip;]</p> -->
                </a>
            </li>

            <?php
                } // endwhile
                wp_reset_postdata();
            } // endif
            ?>
        </ul>
        <div class="section-buttons">
            <button
                type="button"
                class="button button-ghost"
                onclick="javascript:location.href = '<?php echo esc_url(get_term_link($term_obj)); ?>';"
            >
            <?php echo $term_obj->name ; ?>一覧を見る
            </button>
        </div>
    </div>
</section>



<section
    class="section-contents"
    id="company"
>
    <div class="wrapper">
        <?php
        
        $company_page = get_page_by_path('company');
        $post = $company_page;
        setup_postdata($post);
        ?>
        <span class="section-title-en">Enterprise Information</span>
        <h2 class="section-title"><?php the_title(); ?></h2>
        <p class="section-lead"><?php echo get_the_excerpt(); ?></p>
        <div class="section-buttons">
            <button
                type="button"
                class="button button-ghost"
                onclick="javascript:location.href = '<?php echo esc_url(home_url('company')) ?>';"
            >
                <?php the_title(); ?>一覧を見る
            </button>
        </div>
        <?php wp_reset_postdata(); ?>
    </div>
</section>

<?php get_footer(); ?>