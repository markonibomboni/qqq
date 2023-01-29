<?php
/**
 * Template Name: Movies List
 */

get_header(); ?>

<?php if ( is_home() && ! is_front_page() && ! empty( single_post_title( '', false ) ) ) : ?>
	<header class="page-header alignwide">
		<h1 class="page-title"><?php single_post_title(); ?></h1>
	</header><!-- .page-header -->
<?php endif; ?>

<?php
if ( have_posts() ) { ?>

	<div class="zzz-boxed-content">
		<div class="zzz-grid col-3">

			<?php
			$args = array(
				'post_type'      => 'movies',
				'post_status'    => 'publish',
				'posts_per_page' => 9,
				'orderby'        => 'title',
				'order'          => 'ASC',
			);

			$loop = new WP_Query( $args );

			while ( $loop->have_posts() ) : $loop->the_post(); ?>

				<div class="zzz-grid-item">
					<?php if ( has_post_thumbnail() ) { ?>
						<a class="zzz-item-image-link" href="<?php echo get_permalink(); ?>">
							<?php echo get_the_post_thumbnail( $post_id, 'full', array( 'class' => 'zzz-item-image' ) ); ?>
						</a>
					<?php } ?>
					<?php if ( ! empty( $post->post_title ) ) { ?>
						<a class="zzz-item-title-link" href="<?php echo get_permalink(); ?>">
							<h3 class="zzz-item-title"><?php the_title(); ?></h3>
						</a>
					<?php } ?>
					<?php the_excerpt(); ?>
					<span class="zzz-item-movie-title"><?php echo esc_attr( get_post_meta( get_the_ID(), 'movie_title', true ) ); ?></span>
				</div>

			<?php
			endwhile;

			wp_reset_postdata(); ?>

		</div>
	</div>

<?php } else {

	// If no content, include the "No posts found" template.
	get_template_part( 'template-parts/content/content-none' );

}

get_footer();
