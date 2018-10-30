<?php

class DbManager
{
    protected $connections = array();
    protected $model_connection_map = array();
    protected $models = array();

    /**
     * データベースへ接続
     *
     * @param string $name
     * @param array $params
     */
    public function connect($name, $params)
    {
        $params = array_merge(array(
            'dsn'      => null,
            'user'     => '',
            'password' => '',
            'options'  => array(),
        ), $params);

        $con = new PDO(
            $params['dsn'],
            $params['user'],
            $params['password'],
            $params['options']
        );

        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->connections[$name] = $con;
    }

    public function getConnection($name = null)
    {
        if (is_null($name)) {
            return current($this->connections);
        }

        return $this->connections[$name];
    }
    
    public function setmodelConnectionMap($model_name, $name)
    {
        $this->model_connection_map[$model_name] = $name;
    }

    public function getConnectionFormodel($model_name)
    {
        if (isset($this->model_connection_map[$model_name])) {
            $name = $this->model_connection_map[$model_name];
            $con = $this->getConnection($name);
        } else {
            $con = $this->getConnection();
        }

        return $con;
    }

    public function get( $model_name )
    {
        if (!isset($this->models[$model_name])) {
            $model_class = $model_name;
            $con = $this->getConnectionFormodel($model_name);

            $model = new $model_class($con);

            $this->models[$model_name] = $model;
        }

        return $this->models[$model_name];
    }

    /**
     * デストラクタ
     * リポジトリと接続を破棄する
     */
    public function __destruct()
    {
        foreach ($this->models as $model) {
            unset($model);
        }

        foreach ($this->connections as $con) {
            unset($con);
        }
    }
}
