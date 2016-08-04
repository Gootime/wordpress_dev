<?php get_header(); ?>
<section id="content" role="main">
<header class="header">
<h1 class="entry-title"><?php _e( 'Category Archives: ', 'PSN-Theme' ); ?><?php single_cat_title(); ?></h1>
</header>
<?php 
$cat_name = get_category(get_query_var('cat'))->name;
$cat_ID = get_cat_ID( $cat_name );
query_posts('cat='.$cat_ID.'&showposts='.get_option('posts_per_page'));
if($query->have_posts()) :

	while ( $query->have_posts() ) : 
		$query->the_post();
		the_title();
	endwhile;
endif; 
}
?>
</section>
<?php get_footer(); ?>
