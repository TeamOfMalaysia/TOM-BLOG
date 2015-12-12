<?php

namespace Core;

use Illuminate\Container\Container;

/**
 * �������
 *
 * Class Service
 * @package Core
 */
class Service
{
    /**
     * ����ע��
     * @var
     */
    protected $container;
    public function __construct(Container $container)
    {
        $this->container = $container;
    }


    /**
     * @param $name [ע������]
     * @return mixed
     * @author dc
     * @version 20151022
     * @description �̳�ԭע�뷽��,�������
     */
    protected function make($name){
        return $this->container->make($name);
    }
}