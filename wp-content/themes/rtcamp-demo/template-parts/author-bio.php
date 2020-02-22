<?php
/**
 * The template for displaying Author info
**/ ?>
<?php if (!wan_choose_opt('show_author_info')) return;?>
<div class="author-info">
	<div class="author-avatar">
		<?php
		$img_size =  wan_choose_opt('author_img_size');
		echo get_avatar( get_the_author_meta( 'user_email' ), $img_size);
		?>
	</div><!-- .author-avatar -->

	<div class="author-description">
		<h6 class="author-title"><?php echo get_the_author(); ?></h6>

		<p class="author-bio">
			<?php the_author_meta( 'description' ); ?>
			<p class="text-secondary"><a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php printf( __( 'View all posts by %s', 'wan' ), get_the_author() ); ?>
			</a></p>
		</p><!-- .author-bio -->
	</div><!-- .author-description -->
</div><!-- .author-info -->
