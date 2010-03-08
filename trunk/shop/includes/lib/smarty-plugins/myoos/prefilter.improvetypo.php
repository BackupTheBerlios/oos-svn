<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     prefilter.improvetypo.php
 * Purpose:  see shared.improvetypo.php
 *
 * Author:   Christoph Erdmann <smarty@cerdmann.com>
 * Internet: http://www.cerdmann.com
 * -------------------------------------------------------------
 */
function smarty_prefilter_improvetypo($content, &$smarty)
{
    MyOOS_CoreApi::requireOnce('lib/smarty-plugins/myoos/shared.improvetypo.php');

	return smarty_improvetypo($content);

}


