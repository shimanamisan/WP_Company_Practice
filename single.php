<?php get_header();?>

<div class="page-inner full-width">
    <div
        class="page-main"
        id="pg-newsDetail"
    >
        <div class="main-container">
            <div class="main-wrapper">
            <!-- ここからWordPress内のコンテンツを表示させる -->
<?php
// if(have_posts()):
//   while(have_posts()) : the_post();
//     // Step4-5-4で、記事の内容部分をcontent-single.phpへ切り出し
//     get_template_part('content-single');
//   endwhile;
// endif;

if ( have_posts() ):
	while ( have_posts() ) : the_post();
		get_template_part( 'content-single' );
	endwhile;
endif;
?>
            </div><!-- end main-wrapper -->
        </div>
    </div>
</div>
<?php get_footer(); ?>