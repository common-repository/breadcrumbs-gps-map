<?php

/**
 * Map map types to their corresponding IDs as used by MapToolkit
 * @param string $type The map type (satellite|hybrid|map|terrain)
 * @return number
 */
function breadcrumbs_maptype_id ($type) {
	$maptype = 2;
	switch ($type) {
			case 'hybrid':
				$maptype = 'hybrid';
				break;
			case 'terrain':
				$maptype = 'terrain';
				break;
			case 'satellite':
				$maptype = 'satellite';
				break;	
			case 'map':
				$maptype = 'map';
				break;
			default:
				$maptype = 'terrain';
		}
	return $maptype;
}


?>