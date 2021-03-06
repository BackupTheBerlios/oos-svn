<?php
class Piwik_Provider_Controller extends Piwik_Controller 
{	
	/**
	 * Provider
	 */
	function getProvider($fetch = false)
	{
		$view = Piwik_ViewDataTable::factory();
		$view->init( $this->pluginName,  __FUNCTION__, "Provider.getProvider" );
	
		$this->setPeriodVariablesView($view);
		$column = 'nb_visits';
		if($view->period == 'day')
		{
			$column = 'nb_uniq_visitors';
		}
		$view->setColumnsToDisplay( array('label',$column) );
		$view->setColumnTranslation('label', Piwik_Translate('Provider_ColumnProvider'));
		$view->setSortedColumn( $column	 );
		$view->setLimit( 5 );
		return $this->renderView($view, $fetch);
	}
	
}

