<?php
/*
Template Name: page-shop
*/
get_header();
?>
<?php
// Items by category
$terms = "all"; // sorts_category
$args = []; // parameter for get_posts()
$info = []; // marker items on google map
global $post;

// set parameters
$args['article'] = array(
  'post_type' => 'shop',
  'post_status' => 'publish',
  'posts_per_page' => 3,
);
if (isset($_GET['cat'])) {
  $terms = $_GET['cat'];
  $args['map'] = array(
    'post_type' => 'shop',
    'post_status' => 'publish',
  	'posts_per_page' => -1,
    'tax_query' => array(
                    array(
	                    'taxonomy' => $taxonomy,
	                    'field' => 'slug',
	                    'terms' => $terms
                    )
  	 ),
  );
} else {
  $args['map'] = array(
    'post_type' => 'shop',
    'post_status' => 'publish',
    'posts_per_page' => -1,
  );
}
foreach ($args as $key => $val) {
  $posts_array[$key] = get_posts($val);
}

// set data for google map
$tmp = [];
foreach ($posts_array['map'] as $post) {
  setup_postdata($post);
  array_push(
    $tmp,
    array(
      'address' => get_field('address'),
      'name' => $post->post_title,
    )
  );
  wp_reset_postdata();
}
$info[$terms] = $tmp;
$json = json_encode($info[$terms], JSON_UNESCAPED_UNICODE);
?>
<script>
let info = JSON.parse('<?php echo $json; ?>');
</script>
<style>
#gmap {
  width: 100%;
  height: 450px;
}
.gmap-btn {
	display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: center;
}
.gmap-btn:hover {
	text-decoration: none;
}
.gmap-btn i {
	font-size: 50px;
}
</style>
<div class="container my-5">
	<div class="row">
		<div class="col-md-4">
			<a href="#" class="gmap-btn" data-cat="all">
				<i class="fas fa-angry"></i>
				<p>All</p>
			</a>
		</div>
		<div class="col-md-4">
			<a href="#" class="gmap-btn" data-cat="foods">
				<i class="fas fa-utensils"></i>
				<p>Foods</p>
			</a>
		</div>
		<div class="col-md-4">
			<a href="#" class="gmap-btn" data-cat="sports">
				<i class="fas fa-running"></i>
				<p>Sports</p>
			</a>
		</div>
	</div>
</div><!-- /container -->
<div class="container my-5">
	<div class="row article-list">
		<?php foreach ( $posts_array['article'] as $post ) : setup_postdata( $post ); ?>
			<div  class="col-4">
				<div class="card">
					<img class="card-img-top" src="<?php bloginfo('url'); ?>/wp-content/uploads/2022/02/sample.jpg" alt="Card image">
					<div class="card-body">
						<h4 class="card-title"><?php the_title(); ?></h4>
						<div class="card-text">
							<p class="address"><?php the_field('address'); ?></p>
							<p class="phone"><?php the_field('phone'); ?></p>
							<p class="email"><?php the_field('email'); ?></p>
						</div>
						<a href="<?php the_field('website'); ?>" class="btn btn-primary website" target="_blank" rel="noopener noreferrer">See Detail</a>
					</div>
				</div><!-- /card -->
			</div>
		<?php endforeach; wp_reset_postdata(); ?>
	</div>
</div><!-- /container -->
<div class="container my-5">
	<div class="row">
		<div class="col-12">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d216085.6500987104!2d130.62488857027233!3d32.19511418673048!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x353f7187b1202ffd%3A0xcea45879742d5612!2sHitoyoshi%2C%20Kumamoto!5e0!3m2!1sen!2sjp!4v1642729153847!5m2!1sen!2sjp" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
      <div id="gmap"></div>
		</div>
	</div>

</div>

<?php get_footer(); ?>
