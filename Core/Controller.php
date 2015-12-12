<?php

namespace Core;

use Illuminate\Container\Container;
use Symfony\Component\HttpFoundation\Response as SymfonyResqonse;

class Controller
{
    protected $twig;
    protected $request;
    protected $response;
    protected $data = array();

    /**
     * ��ʼ����ע��container
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;

        // ��ʼ�� DB�� TODO Ӧ���� �¼������ķ�ʽ����ʼ�� ��Ϊ�п����ڲ���Ҫdb�������Ҳ��ʼ����
        $container->make('db');

        /**
         * ��ʼ��һЩ���õ�����
         */
        if(method_exists($this, '__init__')) {
            call_user_func_array(array($this, '__init__'),array());
        }
    }

    public function make($name)
    {
        return $this->container->make($name);
    }

    /**
     * ��������ֵ
     *
     * @param string|array $var
     * @param string $value
     */
    public function assign($var, $value = NULL)
    {
        if(is_array($var)) {
            foreach($var as $key => $val) {
                $this->data[$key] = $val;
            }
        } else {
            $this->data[$var] = $value;
        }
    }

    /**
     * ��Ⱦģ��
     *
     * @param $tpl
     * @param $params
     * @return Response
     */
    public function render($tpl, $params = [])
    {
        $twig = $this->container->make('view');
        $params = array_merge($this->data, $params);
        // ������html.twig��β
        return new SymfonyResqonse($twig->render($tpl . '.html.twig', $params, true));
    }

    /**
     * request ����
     */
    public function request()
    {
        return $this->container->make('request');
    }

    /**
     * response ��Ӧ
     */
    public function response()
    {
        return $this->container->make('response');
    }

}
