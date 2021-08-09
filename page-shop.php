<?php get_header(); ?>
<div class="page-inner">
    <div
        class="page-main"
        id="pg-common"
    >
        <ul class="commons">
            <!-- <li class="common-item">
                      <a class="common-link" href="#">
                        <div class="common-image">
                          <img src="#" alt="" />
                        </div>
                        <div class="common-body">
                          <p class="name">会社概要</p>
                          <p class="caption">私たちパシフィックモール開発は 世界各地のショッピングモール開発を通じて 人と人...</p>
                          <div class="buttonBox">
                            <button type="button" class="seeDetail">MORE</button>
                          </div>
                        </div>
                      </a>
                    </li> -->

    <?php
      $common_pages = get_child_page();
      if ($common_pages->have_posts()) :
        while ($common_pages->have_posts()) : $common_pages->the_post();
          get_template_part('content-common');
        endwhile;
        // サブクエリを実行した後、メインクエリに戻す時に必要となる記述
        // この記述がないと、以降の処理がメインクエリにセットされず異なる投稿情報が表示されるなど
        // 意図しないデータが処理・実行されてしまう
        wp_reset_postdata();
      endif;

      ?>
        </ul>
    </div>
</div>

<?php get_footer(); ?>