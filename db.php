<?php

class DB {

    private static $ins;    //当前对象的实例
    private $db;            //当前数据库的实例
    private $field = '*';   //要查询的列
    private $table;         //表名
    private $where;         //条件
    private $limit;         //分页limit
    private $order;         //排序
    private $group;         //分组
    private $join = [];     //关联查询
    private $error;         //错误信息

    /*
     * 构造方法,创建pdo实例
     */

    private function __construct($ip, $dbname, $username, $password) {
        $this->db = new PDO("mysql:host=$ip;dbname=$dbname;charset=utf8", $username, $password);
    }

    private function __clone() {
        
    }

    /*
     * 获取db类实例
     */

    public static function getIns(...$db_config) {
        if (self::$ins instanceof SELF) {
            return self::$ins;
        }
        return self::$ins = new SELF(...$db_config);
    }

    /*
     * 查询方法，返回二维数组
     */

    public function select() {
        $sql = "select {$this->field} from {$this->table} " . implode(' ', $this->join) . " {$this->where} {$this->group} {$this->order} {$this->limit}";
        $res = $this->query($sql);
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
     * 查询方法，返回单条数据
     */

    public function find() {
        $sql = "select {$this->field} from {$this->table} " . implode(' ', $this->join) . " {$this->where} {$this->group} {$this->order} limit 1";
        $res = $this->query($sql);
        return $res->fetch(PDO::FETCH_ASSOC);
    }

    /*
     * 添加单条
     * @param array $param 一维数组
     * @return int $res 返回影响的记录数
     */

    public function add($param) {
        $sql = "insert into {$this->table}(" . implode(',', array_keys($param)) . ") value('" . implode("','", $param) . "')";
        $res = $this->exec($sql);
        return $res;
    }

    /*
     * 添加多条
     * @param array $param 二维数组
     * @return int $res 返回影响的记录数
     */

    public function addAll($param) {
        $columns = $param[0];
        $query = [];
        foreach ($param as $key => $val) {
            $query[] = "('" . implode("','", $val) . "')";
        }
        $sql = "insert into {$this->table}(" . implode(',', array_keys($columns)) . ") value" . implode(',', $query);
        $res = $this->exec($sql);
        return $res;
    }

    /*
     * 删除，返回影响的记录数
     */

    public function delete() {
        $sql = "delete from {$this->table} {$this->where} {$this->group} {$this->order} {$this->limit}";
        $res = $this->exec($sql);
        return $res;
    }

    /*
     * 修改
     * @return int $res 返回影响的记录数
     */

    public function update($param) {
        $query = [];
        foreach ($param as $key => $val) {
            $query[] = $key . '=' . '"' . $val . '"';
        }
        $sql = "update {$this->table} set " . implode(',', $query) . " {$this->where} {$this->group} {$this->order} {$this->limit}";
        $res = $this->exec($sql);
        return $res;
    }

    /*
     * 查询总条数
     * @return int $res 返回条数
     */

    public function count() {
        $sql = "select count(1) as count from {$this->table} " . implode(' ', $this->join) . " {$this->where} {$this->group} {$this->order} {$this->limit}";
        $res = $this->query($sql);
        return $res->fetch(PDO::FETCH_ASSOC)['count'];
    }

    /*
     * 执行写入语句
     * 返回影响的记录条数
     */

    private function exec($sql) {
        $res = $this->db->exec($sql);
        $this->resetParam();        //重置查询参数
        if (FALSE === $res) {
            $this->throwError();    //抛出错误异常
        }
        return $res;
    }

    /*
     * 执行查询语句
     * @return int $res 返回查询对象
     */

    private function query($sql) {
        $res = $this->db->query($sql);
        $this->resetParam();
        if (FALSE === $res) {
            $this->throwError();
        }
        return $res;
    }

    /*
     * where子语句封装
     * @param array|string $where 查询条件
     * @return object self::$ins 返回当前实例
     */

    public function where($where) {
        if (is_array($where)) {
            $_where = [];
            foreach ($where as $column => $value) {
                $_where[] = $column . '=' . '"' . $value . '"';
            }
            $this->where = 'where ' . implode(' and ', $_where);
        } else {
            $this->where = 'where ' . $where;
        }
        return self::$ins;
    }

    /*
     * limit子语句封装
     * @param int $offset 偏移量
     * @param int $limit 每页显示的条数
     * @return object self::$ins 返回当前实例
     */

    public function limit($offset, $limit) {
        $this->limit = 'limit ' . $offset . ',' . $limit;
        return self::$ins;
    }

    /*
     * order子语句封装
     * @param string $column 字段名称
     * @param string $order 排序规则 asc 正序（默认） desc倒叙
     * @return object self::$ins 返回当前实例
     */

    public function order($column, $order = 'asc') {
        $this->order = 'order by ' . $column . ' ' . $order;
        return self::$ins;
    }

    /*
     * group子语句封装
     * @param array|string $group 分组查询的列名
     * @return object self::$ins 返回当前实例
     */

    public function group($column) {
        if (is_array($column)) {
            $column = implode(',', $column);
        }
        $this->group = 'group by ' . $column;
        return self::$ins;
    }

    /*
     * join子语句封装，可使用如下方式简易调用：leftJoin() | rightJoin() | innerJoin()
     * @param string $table 关联的表名
     * @param string $join 关联的条件
     * @param string $direction 关联的方式 默认inner 
     * @return object self::$ins 返回当前实例
     */

    public function join($table, $join, $direction = 'inner') {
        $this->join[] = $direction . ' join ' . $table . ' on ' . $join;
        return self::$ins;
    }

    /*
     * 设置查询的列
     * @param string $field 要查询的列名
     * @return object self::$ins 返回当前实例
     */

    public function field($field) {
        $this->field = is_array($field) ? implode(',', $field) : $field;
        return self::$ins;
    }

    /*
     * 设置当前查询的表名
     * @return object self::$ins 返回当前实例
     */

    public function table($table) {
        $this->table = $table;
        return self::$ins;
    }

    /*
     * 调用不存在的方法时自动触发，为实现join的简易调用
     */

    public function __call($action, $param) {
        if ($limit = strpos($action, 'Join')) {
            $direction = substr($action, 0, $limit);
            $param[] = $direction;
            return $this->join(...$param);
        }
    }

    /*
     * 抛出错误异常的方法
     */

    private function throwError() {
        $this->error = $this->db->errorInfo()[2];
        throw new Exception($this->error);
    }

    /*
     * 获取错误信息的方法
     */

    public function getError() {
        return $this->error;
    }

    /*
     * 开启事务
     */

    public function beginTransaction() {
        $this->db->beginTransaction();
    }

    /*
     * 提交事务
     */

    public function commit() {
        $this->db->commit();
    }

    /*
     * 回滚事务
     */

    public function rollBack() {
        $this->db->rollBack();
    }

    /*
     * 重置查询参数
     */

    private function resetParam() {
        $this->field = '*';
        $this->where = NULL;
        $this->order = NULL;
        $this->limit = NULL;
        $this->group = NULL;
        $this->join = [];
        $this->table = NULL;
    }

}
