<?php

require_once 'vendor/tpl.php';
include_once 'Request.php';

$request = new Request($_GET);

if ($request->param('page') === 'dashboard') {
    include_once 'dashboard.php';
} else if ($request->param('page') === 'employee-list') {
    include_once 'employee-list.php';
} else if ($request->param('page') === 'employee-form') {
    include_once 'employee-form.php';
} else if ($request->param('page') === 'task-list') {
    include_once 'task-list.php';
} else if ($request->param('page') === 'task-form') {
    include_once 'task-form.php';
} else {
    include_once 'dashboard.php';
}