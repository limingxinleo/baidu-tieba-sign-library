<?php
// +----------------------------------------------------------------------
// | Tieba.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Yi\Baidu\User;

use Yi\Baidu\User;
use Yi\Baidu\Utils\Curl;

/**
 * Class Tieba
 * @package Yi\Baidu\User
 * @property User                  $user
 * @property \Yi\Baidu\Tieba\Tieba $tieba
 */
class Tieba
{
    public $user;

    public $tieba;

    public $favo_type;

    public $level_id;

    public $level_name;

    public $cur_score;

    public $levelup_score;

    public $avatar;

    public $slogan;

    public function __construct(User $user, \Yi\Baidu\Tieba\Tieba $tieba, $detail = [])
    {
        $this->user = $user;
        $this->tieba = $tieba;

        foreach ($detail as $key => $item) {
            $this->$key = $item;
        }
    }

    /**
     * @desc   签到
     * @author limx
     * @param $tbs 用户凭证
     * @param $kw  贴吧名
     * @param $fid 贴吧FID
     * @return mixed no=0 成功签到 no=1101 已签到过
     */
    public function sign()
    {
        $bduss = $this->user->bdUss;
        $tbs = User::tbs($bduss);
        $kw = $this->tieba->name;
        $fid = $this->tieba->fid;

        $url = 'http://tieba.baidu.com/mo/q/sign?tbs=' . $tbs . '&kw=' . urlencode($kw) . '&is_like=1&fid=' . $fid;
        $headers = [
            'User-Agent: fuck phone', 'Referer: http://tieba.baidu.com/f?kw=' . $kw,
            'Host: tieba.baidu.com',
            'X-Forwarded-For: 115.28.1.' . mt_rand(1, 255),
            'Origin: http://tieba.baidu.com',
            'Connection: Keep-Alive',
            'Cookie:' . "BDUSS=" . $bduss . "; BAIDUID=" . strtoupper(md5(time()))
        ];

        $res = Curl::post($url, [], ['headers' => $headers]);
        return json_decode($res, true);
    }

}