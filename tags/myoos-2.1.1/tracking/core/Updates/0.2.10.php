<?php

try {
	$tables = Piwik::getTablesCreateSql();
	$optionTable = $tables['option'];
	Piwik_Query( $optionTable );
} catch (Exception $e) {
	throw new UpdateErrorException("Error trying to create the option table in Mysql: " . $e->getMessage());
}
