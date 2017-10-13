<?php
// +----------------------------------------------------------------------
// | Tieba.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Yi\Baidu\Tieba;

use Yi\Baidu\Exceptions\TiebaException;
use Yi\Baidu\Utils\Curl;

class Tieba
{
    public $name;

    public $fid;

    /**
     * Tieba constructor.
     * @param array|mixed $name 贴吧名
     * @param null        $fid  贴吧fid
     */
    public function __construct($name, $fid = null)
    {
        $this->name = $name;
        if (isset($fid)) {
            $this->fid = $fid;
        } else {
            $this->fid = static::fid($name);
        }
    }

    /**
     * @desc   获取贴吧Fid
     * @author limx
     * @param $tieBaName 贴吧名称
     */
    public static function fid($tieBaName)
    {
        $headers = [
            'User-Agent: fuck phone',
            'Referer: http://wapp.baidu.com/',
            'Content-Type: application/x-www-form-urlencoded',
            'Cookie:BAIDUID=' . strtoupper(md5(time()))
        ];
        $url = 'http://tieba.baidu.com/mo/m?kw=' . urlencode($tieBaName);

        $res = Curl::post($url, [], ['headers' => $headers]);

        preg_match('/\<input type="hidden" name="fid" value="(.*?)"\/\>/', $res, $output);

        if (isset($output[1])) {
            return $output[1];
        }

        throw new TiebaException('贴吧未找到！');
    }

}