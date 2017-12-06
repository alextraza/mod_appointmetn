<?php

defined('_JEXEC') or die;

require_once dirname(__FILE__) . '/helper.php';

$hello = modAppointmentHelper::getHello($params);
require JModuleHelper::getLayoutPath('mod_appointment');
