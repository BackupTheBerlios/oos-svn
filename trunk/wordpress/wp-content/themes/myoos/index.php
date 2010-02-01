<?php
/**
 * @package WordPress
 * @subpackage MyOOS_Theme
 */

get_header(); ?>

	<div id="content" class="narrowcolumn" role="main">

	<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>

			<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'myoos'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
				<small><?php the_time(__('F jS, Y', 'myoos')) ?> <!-- by <?php the_author() ?> --></small>

				<div class="entry">
					<?php the_content(__('Read the rest of this entry &raquo;', 'myoos')); ?>
				</div>

				<p class="postmetadata"><?php the_tags(__('Tags:', 'myoos') . ' ', ', ', '<br />'); ?> <?php printf(__('Posted in %s', 'myoos'), get_the_category_list(', ')); ?> | <?php edit_post_link(__('Edit', 'myoos'), '', ' | '); ?>  <?php comments_popup_link(__('No Comments &#187;', 'myoos'), __('1 Comment &#187;', 'myoos'), __('% Comments &#187;', 'myoos'), '', __('Comments Closed', 'myoos') ); ?></p>
			</div>

		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link(__('&laquo; Older Entries', 'myoos')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Newer Entries &raquo;', 'myoos')) ?></div>
		</div>

	<?php else : ?>

		<h2 class="center"><?php _e('Not Found', 'myoos'); ?></h2>
		<p class="center"><?php _e('Sorry, but you are looking for something that isn&#8217;t here.', 'myoos'); ?></p>
		<?php get_search_form(); ?>

	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
