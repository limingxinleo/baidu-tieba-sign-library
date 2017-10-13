<?php
// +----------------------------------------------------------------------
// | User.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Yi\Baidu;

use Yi\Baidu\Exceptions\TiebaException;
use Yi\Baidu\User\Tieba;
use Yi\Baidu\Utils\Curl;

/**
 * Class User
 * @package Yi\Baidu
 * @property array $tiebas
 */
class User
{
    public $bdUss;

    public $nickName;

    public $tiebas = [];

    public function __construct($bdUss, $nickName = null)
    {
        $this->bdUss = $bdUss;
        $this->nickName = $nickName;
    }

    /**
     * @desc   获取贴吧实例
     * @author limx
     * @param $fid  贴吧fid
     * @param $name 贴吧名
     */
    public function tieba($name, $fid = null)
    {
        if (isset($this->tiebas[$name]) && $this->tiebas[$name] instanceof Tieba) {
            return $this->tiebas[$name];
        }

        $tieba = TiebaFactory::instance($name, $fid);

        return $this->tiebas[$name] = new Tieba($this, $tieba);
    }

    /**
     * @desc   获取用户ID
     * @author limx
     * @return mixed
     */
    public static function id($name)
    {
        $url = "http://tieba.baidu.com/home/get/panel?ie=utf-8&un=" . $name;
        $res = Curl::post($url);

        $ur = json_decode($res, true);
        if (isset($ur['data']['id'])) {
            return $ur['data']['id'];
        }
        throw new TiebaException('对不起，您查询的贴吧ID不存在！');
    }

    /**
     * @desc   获取贴吧
     * @author limx
     */
    public function flushTiebas()
    {
        if (!isset($this->nickName)) {
            throw new TiebaException('请设置nickName');
        }

        $pn = 1;
        $userid = static::id($this->nickName);
        $bduss = $this->bdUss;

        $head = array();
        $head[] = 'Content-Type: application/x-www-form-urlencoded';
        $head[] = 'User-Agent: Mozilla/5.0 (SymbianOS/9.3; Series60/3.2 NokiaE72-1/021.021; Profile/MIDP-2.1 Configuration/CLDC-1.1 ) AppleWebKit/525 (KHTML, like Gecko) Version/3.0 BrowserNG/7.1.16352';
        $head[] = 'Cookie:' . 'BDUSS:' . $bduss;

        $url = 'http://c.tieba.baidu.com/c/f/forum/like';

        $data = array(
            '_client_id' => 'wappc_' . time() . '_' . '258',
            '_client_type' => 2,
            '_client_version' => '6.5.8',
            '_phone_imei' => '357143042411618',
            'from' => 'baidu_appstore',
            'is_guest' => 1,
            'model' => 'H60-L01',
            'page_no' => $pn,
            'page_size' => 200,
            'timestamp' => time() . '903',
            'uid' => $userid,
        );
        $sign_str = '';
        foreach ($data as $k => $v) $sign_str .= $k . '=' . $v;
        $sign = strtoupper(md5($sign_str . 'tiebaclient!!!'));
        $data['sign'] = $sign;


        $rt = Curl::post($url, $data, $head);
        $res = json_decode($rt, true);

        if (isset($res['forum_list']['non-gconforum'])) {
            $list = $res['forum_list']['non-gconforum'];

            $result = [];

            foreach ($list as $item) {
                $name = $item['name'];
                $fid = $item['id'];

                $tieba = TiebaFactory::instance($name, $fid);
                $result[$name] = new Tieba($this, $tieba, $item);
            }

            return $this->tiebas = $result;
        }

        return $this->tiebas = [];
    }


    /**
     * @desc   获取TBS
     * @author limx
     * @param $bduss
     */
    public static function tbs($bduss)
    {
        $url = 'http://tieba.baidu.com/dc/common/tbs';
        $headers = [
            'User-Agent: fuck phone',
            'Referer: http://tieba.baidu.com/',
            'X-Forwarded-For: 115.28.1.' . mt_rand(1, 255),
            'Cookie:' . "BDUSS=" . $bduss
        ];

        $res = Curl::post($url, [], ['headers' => $headers]);

        $x = json_decode($res, true);
        if ($x['is_login'] !== 1) {
            throw new TiebaException('BD_USS 已失效');
        }

        return $x['tbs'];
    }
}