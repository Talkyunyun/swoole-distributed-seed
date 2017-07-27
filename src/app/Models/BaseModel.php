<?php
/**
 * 基类模型
 * User: gene
 * Date: 2017/7/27
 * Time: 上午10:39
 */

namespace app\Models;

use Server\CoreBase\Model;

class BaseModel extends Model {

    // 表前缀
    public $table_prefix = '';

    // 表明
    public $table_name = '';


    // loader初始化
    public function initialization(&$context) {
        parent::initialization($context);

        $mysqlConfig = $this->config['mysql'];
        $this->table_prefix = $mysqlConfig[$mysqlConfig['active']]['prefix'];
    }

    // 获取表名
    public function table() {
        return $this->table_prefix . $this->table_name;
    }


    public function getOne($contidions, $fields = '*', $isResult = true, $orderBy = false, $group = '') {
        $this->mysql_pool->dbQueryBuilder->select($fields)->from($this->table());
        $this->_setConditions($contidions);
        $this->mysql_pool->dbQueryBuilder->limit(1);
        if (!empty($orderBy) || is_array($orderBy)) {
            $this->mysql_pool->dbQueryBuilder->orderBy($orderBy[0], $orderBy[1]);
        }
        if ($group) {
            $this->mysql_pool->dbQueryBuilder->groupBy($group, null);
        }

        //使用协程，发送sql
        $mySqlCoroutine = $this->mysql_pool->dbQueryBuilder->coroutineSend();
        if ($isResult) {
            // 等待查询结果，返回结果
            $result = yield $mySqlCoroutine;

            return $result;
//            return isset($result['result'][0]) ? $result['result'][0] : [];
        }

        //不等待查询结果，直接返回，通过yield获取结果
        return $mySqlCoroutine;
    }


    /**
     * 插入一条记录
     * @param array $data 二维数组 key:字段名  value: 值
     * @return mixed
     */
    public function insert($data = []) {
        $this->mysql_pool->dbQueryBuilder
            ->insertInto($this->table())
            ->intoColumns(array_keys($data))
            ->intoValues(array_values($data));

        $result = $this->mysql_pool->dbQueryBuilder->coroutineSend();

        return $result['insert_id'];
    }

    /**
     * 更新记录
     * @param array $data
     * @param array $contidions
     * @return bool
     */
    public function update($data = [], $contidions = []) {
        $this->mysql_pool->dbQueryBuilder->update($this->table());

        foreach ($data as $column => $value) {
            $this->mysql_pool->dbQueryBuilder->set($column, $value);
        }

        $this->_setConditions($contidions);
        $result = $this->mysql_pool->dbQueryBuilder->coroutineSend();

        return $result['affected_rows'] ? true : false;
    }

    /**
     * 删除记录
     * @param array $contidions
     * @return bool
     */
    public function delete($contidions = []) {
        $this->mysql_pool->dbQueryBuilder->delete()->from($this->table());
        $this->_setConditions($contidions);

        $result = $this->mysql_pool->dbQueryBuilder->coroutineSend();

        return $result['affected_rows'] ? true : false;
    }

    /**
     * 设置条件,目前只支持一维数组
     * @param $contidions
     * @return bool
     */
    private function _setConditions($contidions) {
        if (empty($contidions) || !is_array($contidions)) {
            return false;
        }

        foreach ($contidions as $column => $value){
            $this->mysql_pool->dbQueryBuilder->where($column, $value);
        }
    }
}