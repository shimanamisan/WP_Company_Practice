<?php get_header(); ?>
<div class="page-inner">
    <div
        class="page-main"
        id="pg-contribution"
    >
        <ul class="contribution">
          <?php

            // taxonomy.php や taxonomy-{slug}.php などのカスタム分類（タクソノミー）テンプレートでは
            // $termに閲覧しているタームのスラッグが自動に格納される
            $term = get_specific_posts('daily_contribution', 'event', $term, -1);

            if ($term->have_posts()) {
              while ($term->have_posts()) {
                $term->the_post();
                get_template_part('content-tax');
              }
            
              // サブクエリを実行した後、メインクエリに戻す時に必要となる記述
              // この記述がないと、以降の処理がメインクエリにセットされず異なる投稿情報が表示されるなど
              // 意図しないデータが処理・実行されてしまう
              wp_reset_postdata();
      
            }

          ?>
        </ul>
    </div>
</div>

<?php get_footer(); ?>