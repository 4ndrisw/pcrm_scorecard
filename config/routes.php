<?php

defined('BASEPATH') or exit('No direct script access allowed');

$route['scorecards/task_duration/(:num)/(:any)'] = 'scorecard/index/$1/$2';
