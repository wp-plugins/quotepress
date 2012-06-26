<?php
// * if you want to work with the genre category on your query
// $wp_query = new WP_Query(array('post_type' => 'video', 'genre' => 'scifi','posts_per_page' => -1));
//
// * if you want to work with the actor tag on your query
// $wp_query = new WP_Query(array('post_type' => 'video', 'genre' => 'scifi','actor' => 'keanureaves','posts_per_page' => -1));
//
get_header();
?>
<div>
  <h3><a href="<?the_permalink();?>"><?=get_the_title();?></a></h3>
</div>
<div>
  <p><?=get_the_content();?></p>
</div>

<?php get_footer(); ?>
