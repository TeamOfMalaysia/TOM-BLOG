<?php
namespace App\Models;

class Posts extends \Illuminate\Database\Eloquent\Model
{
    protected $table='posts';
    protected $primaryKey = 'id';
//    public $timestamps= ;
    protected $guarded = ['id'];

    /**
     * ���ͷ�����Ӧ���û���Ϣ
     * һ��һ
     *
     * <p>
     * �����û���
     * �ڻ�ȡʱ�� with('postUser') ����twig �п���ֱ�ӵ���
     * </p>
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function postUser()
    {
        return $this->hasOne('App\Models\Users','id','user_id');
    }

    /**
     * ���ͷ�����Ӧ�ķ�����Ϣ
     * һ��һ
     *
     * <p>
     * ���������
     * �ڻ�ȡʱ�� with('postCate') ����twig �п���ֱ�ӵ���
     * </p>
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function postCate()
    {
        return $this->hasOne('App\Models\Cates','id','cate_id');
    }

}