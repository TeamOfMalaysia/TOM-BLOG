<?php
namespace App\Controller\Admin;


use App\Models\Users;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PublicController extends BaseController
{

    public function login()
    {
        return $this->render('Admin/Public/login');
    }

    public function checkLogin()
    {
        $request = $this->request();
        $session = $request->getSession();
        $username = $request->get('username');
        $password = $request->get('password');
        if (empty($username) || empty($password)) {
            return json_encode(array(
                'status' => 0,
                'msg' => '�û��������벻��Ϊ��'
            ), JSON_UNESCAPED_UNICODE);
        }
        $userinfo = Users::where('username',$username)->first();
        //�����ȡ�����û���Ϣ��������ʾ��Ϣ
        if (!$userinfo || $userinfo['password'] != md5($password)) {
            return array(
                'status' => 0,
                'msg' => '�û��������������'
            );
        }
        $session->set('uid',$userinfo['id']);
        return new RedirectResponse('/admin');
    }

}
