<?php

define('PDO_DEBUG',false); // PDO����
// ����webĿ¼λ��
define('BASEDIR',dirname(__DIR__));
// ������Ŀ���
$app = require BASEDIR . '/App/app.php';

// ִ����Ŀ Application.goRun()
$app->goRun();