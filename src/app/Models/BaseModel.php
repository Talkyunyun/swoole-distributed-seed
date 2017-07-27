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


    /**
     * 查询一条记录
     * @param $contidions
     * @param string $fields
     * @param array $orderBy ['id' => 'desc']
     * @param string $group
     * @return array
     */
    public function getOne($contidions, $fields = '*', $orderBy = false, $group = '') {
        $this->mysql_pool->dbQueryBuilder->select($fields)->from($this->table());
        $this->_setConditions($contidions);
        $this->mysql_pool->dbQueryBuilder->limit(1);
        if (!empty($orderBy) || is_array($orderBy)) {
            $this->mysql_pool->dbQueryBuilder->orderBy($orderBy[0], $orderBy[1]);
        }
        if (!empty($group)) {
            $this->mysql_pool->dbQueryBuilder->groupBy($group, null);
        }

        // 使用协程，发送sql
        $result = yield $this->mysql_pool->dbQueryBuilder->coroutineSend();

        return isset($result['result'][0]) ? $result['result'][0] : [];
    }


    /**
     * 插入一条记录 必须 yield
     * @param array $data 二维数组 key:字段名  value: 值
     * @return mixed
     */
    public function insert($data = []) {
        $this->mysql_pool->dbQueryBuilder
            ->insertInto($this->table())
            ->intoColumns(array_keys($data))
            ->intoValues(array_values($data));

        $result = yield $this->mysql_pool->dbQueryBuilder->coroutineSend();

        return $result['insert_id'];
    }

    /**
     * 更新记录 yield
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
        $result = yield $this->mysql_pool->dbQueryBuilder->coroutineSend();

        return $result['affected_rows'] ? true : false;
    }

    /**
     * 删除记录 yield
     * @param array $contidions
     * @return bool
     */
    public function delete($contidions = []) {
        $this->mysql_pool->dbQueryBuilder->delete()->from($this->table());
        $this->_setConditions($contidions);

        $result = yield $this->mysql_pool->dbQueryBuilder->coroutineSend();

        return $result['affected_rows'] ? true : false;
    }

    /**
     * 获取总数
     * @param $contidions
     * @return int
     */
    public function count($contidions) {
        $this->mysql_pool->dbQueryBuilder->select('count(*) as count')->from($this->table());
        $this->_setConditions($contidions);
        $this->mysql_pool->dbQueryBuilder->limit(1);

        //使用协程，发送sql
        $result = yield $this->mysql_pool->dbQueryBuilder->coroutineSend();

        return (int)$result['result'][0]['count'];
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