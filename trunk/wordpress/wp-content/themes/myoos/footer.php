<?php
/**
 * @package WordPress
 * @subpackage MyOOS_Theme
 */
?>

<hr />
<div id="footer" role="contentinfo">
<!-- If you'd like to support WordPress, having the "powered by" link somewhere on your blog is the best way; it's our only promotion or advertising. -->
	<p>
		<?php printf(__('%1$s is proudly powered by %2$s', 'myoos'), get_bloginfo('name'),
		'<a href="http://wordpress.org/">WordPress</a>'); ?>
		<br /><?php printf(__('%1$s and %2$s.', 'myoos'), '<a href="' . get_bloginfo('rss2_url') . '">' . __('Entries (RSS)', 'myoos') . '</a>', '<a href="' . get_bloginfo('comments_rss2_url') . '">' . __('Comments (RSS)', 'myoos') . '</a>'); ?>
		<!-- <?php printf(__('%d queries. %s seconds.', 'myoos'), get_num_queries(), timer_stop(0, 3)); ?> -->
	</p>
</div>
</div>

<!-- Gorgeous design by Michael Heilemann - http://binarybonsai.com/kubrick/ -->
<?php /* "Just what do you think you're doing Dave?" */ ?>

		<?php wp_footer(); ?>
</body>
</html>
