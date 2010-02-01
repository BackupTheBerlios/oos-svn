<?php
/**
 * @package WordPress
 * @subpackage MyOOS_Theme
 */

get_header(); ?>

	<div id="content" class="narrowcolumn" role="main">

	<?php if (have_posts()) : ?>

		<h2 class="pagetitle"><?php _e('Search Results', 'myoos'); ?></h2>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link(__('&laquo; Older Entries', 'myoos')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Newer Entries &raquo;', 'myoos')) ?></div>
		</div>


		<?php while (have_posts()) : the_post(); ?>

			<div <?php post_class(); ?>>
				<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'myoos'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h3>
				<small><?php the_time('l, F jS, Y') ?></small>

				<p class="postmetadata"><?php the_tags(__('Tags:', 'myoos') . ' ', ', ', '<br />'); ?> <?php printf(__('Posted in %s', 'myoos'), get_the_category_list(', ')); ?> | <?php edit_post_link(__('Edit', 'myoos'), '', ' | '); ?>  <?php comments_popup_link(__('No Comments &#187;', 'myoos'), __('1 Comment &#187;', 'myoos'), __('% Comments &#187;', 'myoos'), '', __('Comments Closed', 'myoos') ); ?></p>
			</div>

		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link(__('&laquo; Older Entries', 'myoos')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Newer Entries &raquo;', 'myoos')) ?></div>
		</div>

	<?php else : ?>

		<h2 class="center"><?php _e('No posts found. Try a different search?', 'myoos'); ?></h2>
		<?php get_search_form(); ?>

	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
