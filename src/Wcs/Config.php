<?php

namespace  Wcs;


class Config
{
    //version
    const WCS_SDK_VER = "1.0.0";
    const WCS_TIMEOUT = 30;
    const WCS_CONNECTTIMEOUT = 30;

    public static $config = [
        //url设置
        "wcs_put_url" => "http://PUT_URL",
        "wcs_get_url" => "http://GET_URL",
        "wcs_mgr_url" => "http://MGR_URL",

        //access key and secret key
        "wcs_access_key" => "",
        "wcs_secret_key" => "",

        ///token的deadline,默认是1小时,也就是3600s
        "wcs_token_deadline" => "",

        //上传文件设置
        //默认文件不覆盖
        "wcs_overwrite" => 0,

        //超时时间
        "wcs_timeout" => 30,
        "wcs_connecttimeout" => 30,
        "wcs_ram_url" =>'/mnt/ramdisk/',


        //分片上传参数设置
        "wcs_block_size" => 4194304,     //4 * 1024 * 1024 默认块大小4M
        "wcs_chunk_size" => 4194304,     //  4 * 1024 * 1024 默认不分片
        "wcs_record_url" => '',          //默认当前文件目录
        "wcs_count_for_retry" => 3,      //超时重试次数

        //并发请求数目
        "wcs_concurrency"=>5
    ];

    /**
     * 架构函数 读取数据库配置信息
     * @access public
     * @param  array $config 数据库配置数组
     */
    public function __construct(array $config = [])
    {
        if (!empty($config)) {
            self::$config = array_merge(self::$config, $config);
        }
    }
    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        return $this->config[$name];
    }
    
    //创建一个用来实例化对象的方法
    public static function getInstance(){
        if(!(self::$config instanceof self)){
            self::$config = new self;
        }
        return self::$config;
    }
    //防止对象被复制
    public function __clone(){
        trigger_error('Clone is not allowed !');
    }
}

