<?php
/**
* A Simple Category Template
*/

get_header(); ?> 

<section id="primary" class="site-content">
<div id="content" role="main">

<?php
  	$cat = get_query_var('cat');
  	$yourcat = get_category ($cat);
query_posts('category_name='.get_the_title().'&showpost=12');
// Check if there are any posts to display
if ( have_posts() ) { 
?>
<header class="archive-header">
<h1 class="archive-title">Category: <?php echo $yourcat->name; ?></h1>
</header>

<?php

// The Loop
while ( have_posts() ) : the_post(); ?>
<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
<small><?php the_time('F jS, Y') ?> by <?php the_author_posts_link() ?></small>
<?php endwhile; 
}

else{ ?>
<p>Sorry, no posts matched your criteria.</p>
<?php
}
?>

</div>
</section>

<?php wp_reset_query(); ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>