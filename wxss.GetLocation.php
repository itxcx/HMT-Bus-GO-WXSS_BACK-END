<?php
/**
 *  HMT Bus GO! (WXSS VER.)
 *
 *	@author CRH380A-2722 <609657831@qq.com>
 *	@copyright 2016-2017 CRH380A-2722
 *	@license MIT
 *	@note 获取站点位置
 */

header("Content-Type: application/json; charset=utf-8\n");

require_once '../inc.Config.php';

$stops = $SCAUBus->BusData->getStopLocation();
$bus = $SCAUBus->RealTimeBus->getBusLocation();
$data = array();
$i = 1;

foreach ($bus['online'] as $online) {
	$iconPath = NULL;
	switch (@$online['headPosition']) {
		case 1: $iconPath = '/source/map-marker/marker-bus-online-N.png'; break;
		case 2: $iconPath = '/source/map-marker/marker-bus-online-NE.png'; break;
		case 3: $iconPath = '/source/map-marker/marker-bus-online-E.png'; break;
		case 4: $iconPath = '/source/map-marker/marker-bus-online-SE.png'; break;
		case 5: $iconPath = '/source/map-marker/marker-bus-online-S.png'; break;
		case 6: $iconPath = '/source/map-marker/marker-bus-online-SW.png'; break;
		case 7: $iconPath = '/source/map-marker/marker-bus-online-W.png'; break;
		case 8: $iconPath = '/source/map-marker/marker-bus-online-NW.png'; break;
		default: $iconPath = '/source/map-marker/marker-bus-online.png'; break;
	}
	$data[] = array(
		'id' => $i,
		'title' => $online['busNum'] . ' @ ' . $online['line'] . ' [终端在线]',
		'longitude' => $online['position'][0] + 0.000050,
		'latitude' => $online['position'][1] - 0.000150,
		'iconPath' => $iconPath,
		'width' => 60,
		'height' => 60
	);
	$i++;
}

foreach ($bus['offline'] as $offline) {
	$data[] = array(
		'id' => $i,
		'title' => $offline['busNum'] . ' [终端离线]',
		'longitude' => $offline['position'][0] + 0.000050,
		'latitude' => $offline['position'][1] - 0.000150,
		'iconPath' => '/source/map-marker/marker-bus-offline.png',
		'width' => 40,
		'height' => 40
	);
	$i++;
}

foreach ($stops as $stop) {
	$data[] = array(
		'id' => $stop['stopId'] + 50,
		'title' => $stop['title'],
		'longitude' => $stop['position'][0] + 0.000050,
		'latitude' => $stop['position'][1] - 0.000150,
		'iconPath' => '/source/map-marker/marker-stop.png',
		'width' => 40,
		'height' => 40
	);
}

print json_encode($data);

die();
