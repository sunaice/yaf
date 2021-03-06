<?php
   Class ProductModel
   {
      protected $_table = "shop_product";
      protected $_index = "product_uuid";

      public function __construct()
      {
         $this->_db = Yaf_Registry::get('_db');
      }

      public function select($username)
      {
         $params = array(
            "product_id",
            "product_uuid",
            "product_name",
            "reg_time",
            "money",
            "amount",
            "category_id"
         );
         $whereis = array(
            "AND"=>array( $this->_index=>$username, "is_del"=>0)
         );
         $result = $this->_db->select($this->_table, $params ,$whereis );

         return $result==null?false:$result;
      }
      public function select_category($username)
      {
         $params = array(
            "product_id",
            "product_uuid",
            "product_name",
            "reg_time",
            "money",
            "amount",
            "category_id"
         );
         $whereis = array( 
            "AND"=>array( 'category_id'=>$username, "is_del"=>0)
         );
         $result = $this->_db->select($this->_table, $params ,$whereis );

         return $result==null?false:$result;
      }
      public function select_name($username)
      {
         $params = array(
            "product_id",
            "product_uuid",
            "product_name",
            "reg_time",
            "money",
            "amount",
            "category_id"
         );
         // "AND"=>array( 'product_name'=>$username, "is_del"=>0)
         $username = '%'.$username.'%';
         $whereis = array( 
            "is_del"=>0,
            "LIKE"=>array(
               'product_name'=>$username
            )
         );
         $result = $this->_db->select($this->_table, $params ,$whereis );

         return $result==null?false:$result;
      }

      public function selectAll()
      {
         $params = array(
            "product_id",
            "product_uuid",
            "product_name",
            "reg_time",
            "money",
            "amount",
            "category_id"
         );

         //默认的起始页是第一页
         $whereis = array(
            "is_del"=>0
         );
         $result = $this->_db->select($this->_table, $params, $whereis );
         // print_r($this->_db->last_query());

         return $result==null?false:$result;
      }
      public function selectPage($page, $size)
      {
         $params = array(
            "product_id",
            "product_uuid",
            "product_name",
            "reg_time",
            "money",
            "amount",
            "category_id"
         );

         //默认的起始页是第一页
         $page = intval($page);
         $size = intval($size);
         $limit_start = ($page-1)*$size;
         $whereis = array(
            "is_del"=>0,
            "LIMIT"=>array($limit_start,$size)
         );
         $result = $this->_db->select($this->_table, $params, $whereis );
         // print_r($this->_db->last_query());

         return $result==null?false:$result;
      }
      public function selectAll_num(){
         $result = $this->_db->count($this->_table);

         return $result;
      }

      public function insert($info)
      {
         //这里主要是判断是否已经有了商品
         if(!$this->select($info[$this->_index])){
            $result = $this->_db->insert($this->_table, $info);
            return $result<1?false:true;
         }
         return false;
      }
      public function update($username, $info)
      {
         $whereis = array( $this->_index=>$username );
         $result = $this->_db->update($this->_table, $info, $whereis );

         return $result<1?false:true;
      }
      public function del($username)
      {
         $params = array( 'is_del'=>'1' );
         $whereis = array( $this->_index=>$username );
         $result = $this->_db->update($this->_table, $params, $whereis );

         return $result==null?false:true;
      }
   }
         //print_r($this->_db->error());
         //print_r($this->_db->last_query());
