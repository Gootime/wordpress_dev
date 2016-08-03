<?php
/**
* A Simple Category Template
*/

get_header(); ?> 
<?php
?>
<header class="header">
<h1 class="entry-title"><?php _e( 'Category Archives: ', 'blankslate' ); ?><?php single_cat_title(); ?></h1>
</header>
<?php
	$cat = get_query_var('cat');
  	$yourcat = get_category ($cat);

$cats = array();
foreach (get_the_category($post_id) as $c) {
$cat = get_category($c);
array_push($cats, $cat->name);
}

if (sizeOf($cats) > 0) {
$post_categories = implode(', ', $cats);
} else {
$post_categories = 'Not Assigned';
}

echo $post_categories;
?>
	</div>
</section>

<?php get_footer(); ?>
