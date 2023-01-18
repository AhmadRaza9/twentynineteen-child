<?php

/**
 * post Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'post-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'post-main';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}
?>
<div id="<?php echo esc_attr( $id ); ?>"
     class="<?php echo esc_attr( $className ); ?> <?php echo get_field( 'post_layout' ) ?: ''; ?> <?php echo trim( get_field( 'post_alignment' ) ) ?: ''; ?>">
	<?php
	$post_type     = get_field( 'post_type' ) ?: '';
	$post_order    = get_field( 'post_order' ) ?: '';
	$post_per_page = get_field( 'post_per_page' ) ?: '';

	$args = array(
		'post_type'      => $post_type,
		'order'          => $post_order,
		'posts_per_page' => $post_per_page,
	);

	// The Query
	$the_query = new WP_Query( $args );
	?>
	<?php if ( $the_query->have_posts() ): ?>
		<?php while ( $the_query->have_posts() ) : ?>
			<?php $the_query->the_post(); ?>
			<?php $product = wc_get_product( get_the_ID() ); /* get the WC_Product Object */ ?>
            <article class="post-article">
				<?php if ( has_post_thumbnail() ): ?>
					<?php
					/**
					 * @hooked tnc_before_post_image
					 * echo something
					 */
					do_action( 'tnc_before_post_image' );
					?>
                    <a href="<?php the_permalink(); ?>">
                        <div class="article-img">
							<?php echo get_the_post_thumbnail( get_the_ID(), 'large' ); ?>
                        </div>
                    </a>
					<?php
					/**
					 * @hooked tnc_after_post_image
					 * echo something
					 */
					do_action( 'tnc_after_post_image' );
					?>
				<?php endif; ?>
                <div class="post-content">
					<?php
					/**
					 * @hooked tnc_before_post_content
					 * echo something
					 */
					do_action( 'tnc_before_post_content' );
					?>
					<?php if ( $post_type === 'product' ): ?>

						<?php $categories = get_the_terms( $product->get_id(), 'product_cat' ); ?>

						<?php if ( ! empty( $categories ) ): ?>
							<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>
						<?php endif; ?>

						<?php $tags = get_the_terms( $product->get_id(), 'product_tag' ); ?>

						<?php if ( ! empty( $tags ) ): ?>
							<?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>
						<?php endif; ?>

					<?php endif; ?>


					<?php
					/**
					 * @hooked tnc_before_post_title
					 * echo something
					 */
					do_action( 'tnc_before_post_title' );
					?>
                    <h4>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h4>
					<?php
					/**
					 * @hooked tnc_before_post_title
					 * echo something
					 */
					do_action( 'tnc_after_post_title' );
					?>
					<?php if ( $post_type === 'product' ): ?>
						<?php if ( $product->get_price_html() ): ?>
                            <p class="price">
								<?php echo $product->get_price_html(); ?>
                            </p>
						<?php endif; ?>
					<?php endif; ?>
					<?php
					/**
					 * @hooked tnc_before_post_excerpt
					 * echo something
					 */
					do_action( 'tnc_before_post_excerpt' );
					?>
					<?php the_excerpt(); ?>
					<?php
					/**
					 * @hooked tnc_after_post_excerpt
					 * echo something
					 */
					do_action( 'tnc_after_post_excerpt' );
					?>
					<?php
					/**
					 * @hooked tnc_after_post_content
					 * echo something
					 */
					do_action( 'tnc_after_post_content' );
					?>
                </div>
            </article>
		<?php endwhile; ?>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>
</div>
