<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package siteorigin-unwind
 * @since siteorigin-unwind 0.1
 * @license GPL 2.0
 */

get_header(); ?>

	<?php siteorigin_unwind_breadcrumbs(); ?>
<div class="project-wrapper">
	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<?php if(have_posts()): while(have_posts()):the_post(); ?>
				<h1 class=""><?php the_title(); ?></h1>
				<!-- <div class="datetime">
					<i class="fas fa-history"></i>
					<time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('d, m Y'); ?></time>
				</div> -->
				<div class="content-wrapper">
					<div class="content-left">
						<div class="-project-image"><img src="<?php the_field('image'); ?>" alt="" /></div>
					</div>
					<div class="content-right">
						<div class="post-content">
							<h2 class="sub-title title-h2">Project Brief</h2>
							<?php the_content(); ?>
						</div>
						<div class="project-tec"><?php echo get_the_term_list($post->ID,'project_tag','',' | '); ?></div>
						<?php
							// Load field value.
							$dateStr = get_field('year');
							$date = new DateTime();
							$date = DateTime::createFromFormat('d/m/Y', $dateStr);
							// show only Month and Year
							// echo $date->format('M Y');
						?>
						<div class="project-year">
							<h3 class="sub-title title-h3">Year</h3>
							<p><?php echo $date->format('M Y'); ?></p>
						</div>
						<div class="project-btn">
							<a href="<?php the_field('project_url'); ?>" target="_blank">View Website</a>
						</div>
					</div><!-- .content-left -->
				</div><!-- .content-wrapper -->
				<?php
				//リンクを出力：the_post_navigation() を使う場合の例
				// https://www.webdesignleaves.com/pr/wp/wp_func_pager.html
				$args = array(
				    'mid_size' => 1,
				    'prev_text' => '&lt;&lt;PREVIOUS： %title',
				    'next_text' => '%title：NEXT&gt;&gt;',
				    'screen_reader_text' => ' ',
				);
				the_post_navigation($args);


				 ?>
			<?php endwhile; endif; ?>
		</main><!-- #main -->
	</div><!-- #primary -->

</div><!-- .project-wrapper -->

<?php
// get_sidebar();
// echo "<div>書籍名：". $post->image . "</div>";
if(get_field('field_name'))
{
	echo '<p>' . get_field('field_name') . '</p>';
}
// var_dump(get_field());
get_footer();
