<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.improvetypo.php
 * Purpose:  see shared.improvetypo.php
 *
 * Author:   Christoph Erdmann <smarty@cerdmann.com>
 * Internet: http://www.cerdmann.com
 * -------------------------------------------------------------
 */

MyOOS_CoreApi::requireOnce('lib/smarty-plugins/myoos/shared.improvetypo.php');

function smarty_modifier_improvetypo($content,$diff = false)
	{
	return smarty_improvetypo($content,$diff);
	}


