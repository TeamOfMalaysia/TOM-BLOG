<?php
if(!defined('BASEDIR')){
    exit('File not found');
}
// �����Զ��������� composer��ʽ ��ע�ᵽϵͳ��
$loader = include BASEDIR.'/vendor/autoload.php';
spl_autoload_register(array($loader,'loadClass'));

// ��ʼ�������� ����
$app = new \Core\Application();

// ע����񵽿���У�ȫ�ֶ����Ե��� ����ʱ�� $container->make(service)
$app->alias('App\Service\Task\TaskService','taskServer');
$app->alias('App\Service\Message\MessageService','messageServer');
$app->alias('App\Service\User\UserService','userServer');
$app->alias('App\Service\UserGroup\UserGroupService','userGroupServer');
$app->alias('App\Service\System\SystemService', 'systemServer');
$app->alias('App\Service\Lottery\LotteryService', 'lotteryServer');

// ������Ŀ����·������
include 'Config/route.php';

return $app;
