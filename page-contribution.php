<?php get_header(); ?>
<div class="page-inner">
    <div
        class="page-main"
        id="pg-contribution"
    >
        <ul class="contribution">
          <?php

            $terms = get_terms('event');
            foreach($terms as $term){
              // get_template_part関数で呼び出されたファイルは呼び出し元の変数を参照することが出来ない
              // そのためテンプレートをinclude関数で読み込むことで、呼び出されたファイルが呼び出し元の
              // 変数を参照できる
              include 'content-contribution.php';
            }

            // if ($common_pages->have_posts()) :
            //   while ($common_pages->have_posts()) : $common_pages->the_post();
            //     get_template_part('content-contribution');
            //   endwhile;
            //   // サブクエリを実行した後、メインクエリに戻す時に必要となる記述
            //   // この記述がないと、以降の処理がメインクエリにセットされず異なる投稿情報が表示されるなど
            //   // 意図しないデータが処理・実行されてしまう
            //   wp_reset_postdata();
            // endif;

          ?>
        </ul>
    </div>
</div>

<?php get_footer(); ?>