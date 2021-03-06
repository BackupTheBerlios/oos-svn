<?php

// DO NOT RUN THIS SCRIPT STANDALONE
  defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );
    header("HTTP/1.1 301 Moved Permanently"); header("Location: /"); exit;

class SimplePie_Chronological extends SimplePie
{
	function sort_items($a, $b) {
		return ($a->get_date("U") >= $b->get_date("U")) ? 1 : -1;
	}

	function get_items($start = 0, $end = 0)
	{
		if (!empty($this->multifeed_objects))
		{
			return SimplePie_Chronological::merge_items($this->multifeed_objects, $start, $end, $this->item_limit);
		}
		elseif (!isset($this->data['items']))
		{
			if ($items = $this->get_feed_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'entry'))
			{
				$keys = array_keys($items);
				foreach ($keys as $key)
				{
					$this->data['items'][] =& new $this->item_class($this, $items[$key]);
				}
			}
			if ($items = $this->get_feed_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'entry'))
			{
				$keys = array_keys($items);
				foreach ($keys as $key)
				{
					$this->data['items'][] =& new $this->item_class($this, $items[$key]);
				}
			}
			if ($items = $this->get_feed_tags(SIMPLEPIE_NAMESPACE_RSS_10, 'item'))
			{
				$keys = array_keys($items);
				foreach ($keys as $key)
				{
					$this->data['items'][] =& new $this->item_class($this, $items[$key]);
				}
			}
			if ($items = $this->get_feed_tags(SIMPLEPIE_NAMESPACE_RSS_090, 'item'))
			{
				$keys = array_keys($items);
				foreach ($keys as $key)
				{
					$this->data['items'][] =& new $this->item_class($this, $items[$key]);
				}
			}
			if ($items = $this->get_channel_tags('', 'item'))
			{
				$keys = array_keys($items);
				foreach ($keys as $key)
				{
					$this->data['items'][] =& new $this->item_class($this, $items[$key]);
				}
			}
		}

		if (!empty($this->data['items']))
		{
			// If we want to order it by date, check if all items have a date, and then sort it
			if ($this->order_by_date)
			{
				if (!isset($this->data['ordered_items']))
				{
					$do_sort = true;
					foreach ($this->data['items'] as $item)
					{
						if (!$item->get_date('U'))
						{
							$do_sort = false;
							break;
						}
					}
					$item = null;
					$this->data['ordered_items'] = $this->data['items'];
					if ($do_sort)
					{
						usort($this->data['ordered_items'], array(&$this, 'sort_items'));
					}
				}
				$items = $this->data['ordered_items'];
			}
			else
			{
				$items = $this->data['items'];
			}

			// Slice the data as desired
			if ($end == 0)
			{
				return array_slice($items, $start);
			}
			else
			{
				return array_slice($items, $start, $end);
			}
		}
		else
		{
			return array();
		}
	}

	function merge_items($urls, $start = 0, $end = 0, $limit = 0)
	{
		if (is_array($urls) && count($urls) > 0)
		{
			$items = array();
			foreach ($urls as $arg)
			{
				if (is_a($arg, 'SimplePie'))
				{
					$items = array_merge($items, $arg->get_items(0, $limit));
				}
				else
				{
					trigger_error('Arguments must be SimplePie objects', E_USER_WARNING);
				}
			}

			$do_sort = true;
			foreach ($items as $item)
			{
				if (!$item->get_date('U'))
				{
					$do_sort = false;
					break;
				}
			}
			$item = null;
			if ($do_sort)
			{
				usort($items, array('SimplePie_Chronological', 'sort_items'));
			}

			if ($end == 0)
			{
				return array_slice($items, $start);
			}
			else
			{
				return array_slice($items, $start, $end);
			}
		}
		else
		{
			trigger_error('Cannot merge zero SimplePie objects', E_USER_WARNING);
			return array();
		}
	}
}

