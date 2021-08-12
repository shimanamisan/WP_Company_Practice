<?php get_header(); ?>
<div class="page-inner full-width">
  <div class="page-main" id="pg-news">
    <div class="main-container">
      <div class="main-wrapper">
        <div class="newsLists">
          <!-- ループ処理 -->
          <?php
          if (have_posts()) :
            while (have_posts()) : the_post();
              get_template_part('content-archive');
              debug($wp_query->max_num_pages);
            endwhile;
          endif;
          ?>
          <div class="pager">
            <ul class="pagerList">
              <?php
              if(function_exists('page_navi')){
                page_navi();
              }
              ?>
              <?php //if (function_exists("pagination")) pagination($wp_query->max_num_pages); ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>