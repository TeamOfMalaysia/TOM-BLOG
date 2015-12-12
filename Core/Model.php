<?php

namespace Core;

use PDO;

class Model
{
    const PDO_DEBUG = true;
    protected $_dbInstance;
    public $_confAssoc;
    protected $_tableName;

    /**
     * ʵ����ʱע���Ӧ��ģ�Ͷ���
     *
     * @param $name
     */
    public function __construct($name = '')
    {
        $this->_confAssoc = include BASEDIR . '/app/cache/cli-files/php-conf-cache.php';
        $this->_tableName = $name;
        $this->pdoInstance();
    }

    /**
     * @return null
     * @Author Orino
     */
    private function  pdoInstance()
    {
        if ($this->_dbInstance != null) return null;
        $this->_dbInstance = new PDO(
            'mysql:host=' . $this->_confAssoc['database_host'] . ';port=' . $this->_confAssoc['database_port'] . ';dbname=' . $this->_confAssoc['database_name'],
            $this->_confAssoc['database_user'],
            $this->_confAssoc['database_password'],
            array(PDO::ATTR_PERSISTENT => false, PDO::ATTR_TIMEOUT => 3)//����������
        );
        $this->_dbInstance->exec('set names utf8');
        if ($this->_dbInstance == null) {
            exit(json_decode(array(
                "status" => 0,
                "msg" => "���ݿ��쳣��"
            )));
        }
    }

    /**
     * ִ��SQL���ص�һ��
     *
     * @param string $sql
     * @param array $params
     * @return mixed
     */
    public function find($sql, $params = array())
    {
        $statement = $this->_dbInstance->prepare($sql);
        $result = $statement->execute($params);
        if (PDO_DEBUG) {
            $info = array();
            $info['sql'] = $sql;
            $info['params'] = $params;
            $info['error'] = $statement->errorInfo();
            var_dump($info);
//            pdo_debug(false, $info);
        }
        if (!$result) {
            return false;
        } else {
            return $statement->fetch(pdo::FETCH_ASSOC);
        }
    }

    /**
     * ִ��SQL����ȫ����¼
     *
     * @param string $sql
     * @param array $params
     * @return mixed
     */
    public function findAll($sql, $params = array(), $keyfield = '')
    {
        $statement = $this->_dbInstance->prepare($sql);
        $result = $statement->execute($params);
        if (PDO_DEBUG) {
            $info = array();
            $info['sql'] = $sql;
            $info['params'] = $params;
            $info['error'] = $statement->errorInfo();
            var_dump($info);
//            pdo_debug(false, $info);
        }
        if (!$result) {
            return false;
        } else {
            if (empty($keyfield)) {
                return $statement->fetchAll(pdo::FETCH_ASSOC);
            } else {
                $temp = $statement->fetchAll(pdo::FETCH_ASSOC);
                $rs = array();
                if (!empty($temp)) {
                    foreach ($temp as $key => &$row) {
                        if (isset($row[$keyfield])) {
                            $rs[$row[$keyfield]] = $row;
                        } else {
                            $rs[] = $row;
                        }
                    }
                }
                return $rs;
            }
        }
    }


    public function add($tablename, $arr)
    {
        $new_arr = array();
        $cols1 = $cols2 = '';
        foreach ($arr as $key => $item) {
            $new_arr[':' . $key] = $item;
            $cols1 .= $cols1 == '' ? '`' . $key . '`' : ',`' . $key . '`';
            $cols2 .= $cols2 == '' ? ':' . $key . '' : ',:' . $key . '';
        }
        $this->pdoInstance();
        $sql = 'INSERT INTO `' . $tablename . '` (' . $cols1 . ') VALUES (' . $cols2 . ')';
        $statement = $this->_dbInstance->prepare($sql);
        $statement->execute($new_arr);
        if (PDO_DEBUG) {
            $info = array();
            $info['sql'] = $sql;
            $info['params'] = $new_arr;
            $info['error'] = $statement->errorInfo();
            var_dump($info);
//            pdo_debug(false, $info);
        }
        return $this->_dbInstance->lastInsertId();
    }


    /**
     * ���¼�¼
     *
     * @param string $table
     * @param array $data
     *          Ҫ���µ���������
     *          array(
     *              '�ֶ���' => 'ֵ'
     *          )
     * @param array $params
     *          ��������
     *          array(
     *              '�ֶ���' => 'ֵ'
     *          )
     * @param string $gule
     *          ����ΪAND OR
     * @return mixed
     */
    public function flush($table, $data = array(), $params = array(), $gule = 'AND')
    {
        $fields = $this->createParams($data, ',');
        $condition = $this->createParams($params, $gule);
        $params = array_merge($fields['params'], $condition['params']);
        $sql = "UPDATE $table SET {$fields['fields']}";
        $sql .= $condition['fields'] ? ' WHERE ' . $condition['fields'] : '';
        $statement = $this->_dbInstance->prepare($sql);
        $result = $statement->execute($params);

        if (!$result) {
            return false;
        } else {
            return $statement->rowCount();
        }
    }


    /**
     * ת��PDO���ֶ�������б�
     *
     * @param array or string $params
     *          ������������ַ���
     *          ���ַ���ֱ�ӷ���
     * @param string $glue
     *          �ֶμ�ķָ���
     *          ����Ϊ���ţ�,������ AND OR Ӧ�Բ�ͬ��SQL
     * @return mixed
     *          array(
     *              'fields' �ֶ��б������
     *              'params' �����б�
     *          )
     */
    private function createParams($params, $glue = ',')
    {
        $result = array('fields' => ' 1 ', 'params' => array());
        $split = '';
        if (!is_array($params)) {
            $result['fields'] = $params;
            return $result;
        }
        if (is_array($params)) {
            $result['fields'] = '';
            foreach ($params as $fields => $value) {
                $result['fields'] .= $split . "`$fields` =  :$fields";
                $split = ' ' . $glue . ' ';
                $result['params'][':' . $fields] = is_null($value) ? '' : $value;
            }
        }
        return $result;
    }

    /**
     * ���ٶ���
     */
    public function __destruct()
    {
        $this->_dbInstance = null;
    }


}