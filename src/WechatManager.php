<?php
namespace luoyy\Wechat;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use luoyy\Wechat\ErrCode;
use luoyy\Wechat\Wechat;

class WechatManager extends Wechat
{
    // 小程序模板消息接口
    const WXS_TEMPLATE_TITLE_LIST_URL = '/wxopen/template/library/list?'; // 获取小程序模板库标题列表
    const WXS_TEMPLATE_KEYWORD_LIST_URL = '/wxopen/template/library/get?'; // 获取模板库某个模板标题下关键词库
    const WXS_TEMPLATE_ADD_TPL_URL = '/wxopen/template/add?'; // 组合模板并添加至帐号下的个人模板库
    const WXS_TEMPLATE_LIST_URL = '/wxopen/template/list?'; // 获取帐号下已存在的模板列表
    const WXS_TEMPLATE_DEL_TPL_URL = '/wxopen/template/del?'; // 删除帐号下的某个模板
    const WXS_TEMPLATE_SEND_URL = '/message/wxopen/template/send?'; // 发送模版消息
    const CUSTOM_TYPING_URL = '/message/custom/typing?';
    // 获取session
    const SESSION_KEY_URL = '/sns/jscode2session?';
    const CREATE_WXAQRCODE_URL = '/wxaapp/createwxaqrcode?';
    // 小程序API
    const WXA_API_URL_PREFIX = 'https://api.weixin.qq.com/wxa';
    const WXA_CODE_GET_URL = '/getwxacode?';
    const WXA_CODE_GET_LIMIT_URL = '/getwxacodeunlimit?';
    // 附近的小程序API
    const WXA_ADD_NEARBYPOI_URL = '/addnearbypoi?'; // 添加地点
    const WXA_GET_NEARBYPOI_LIST_URL = '/getnearbypoilist?';
    const WXA_DEL_NEARBYPOI_URL = '/delnearbypoi?';
    const WXA_SET_NEARBYPOI_SHOW_STATUS_URL = '/setnearbypoishowstatus?';
    const WXA_PLUGIN_URL = '/plugin?';
    const WXA_DEVPLUGIN_URL = '/devplugin?';
    const WXA_IMG_SEC_CHECK_URL = '/img_sec_check?';
    const WXA_MSG_SEC_CHECK_URL = '/msg_sec_check?';

    // 小程序数据API
    const DATACUBE_API_URL_PREFIX = 'https://api.weixin.qq.com/datacube';
    const DATACUBE_GET_PROFILE_TREND_URL = '/getweanalysisappiddailysummarytrend?';
    const DATACUBE_GET_DAILY_TREND_URL = '/getweanalysisappiddailyvisittrend?';
    const DATACUBE_GET_WEEKLY_TREND_URL = '/getweanalysisappidweeklyvisittrend?';
    const DATACUBE_GET_MONTHLY_TREND_URL = '/getweanalysisappidmonthlyvisittrend?';
    const DATACUBE_GET_ACCESS_DISTRIBUTION_URL = '/getweanalysisappidvisitdistribution?';
    const DATACUBE_GET_DAILY_RETENTION_URL = '/getweanalysisappiddailyretaininfo?';
    const DATACUBE_GET_WEEKLY_RETENTION_URL = '/getweanalysisappidweeklyretaininfo?';
    const DATACUBE_GET_MONTHLY_RETENTION_URL = '/getweanalysisappidmonthlyretaininfo?';
    const DATACUBE_GET_ACCESS_PAGE_URL = '/getweanalysisappidvisitpage?';
    const DATACUBE_GET_USER_PORTRAIT_URL = '/getweanalysisappiduserportrait?';

    private $user_session_key = '';
    /**
     * [getSessionKey 获取小程序中用户的sessionkey]
     * @Author    ZiShang520@gmail.com
     * @DateTime  2017-10-19T14:45:18+0800
     * @copyright (c)                      ZiShang520 All           Rights Reserved
     * @param     string                   $code      [description]
     * @return    [type]                              [description]
     */
    public function getSessionKey($code = '')
    {
        if (empty($code)) {
            return false;
        }
        $result = $this->http_get(self::API_BASE_URL_PREFIX . self::SESSION_KEY_URL . 'appid=' . $this->appid . '&secret=' . $this->appsecret . '&js_code=' . $code . '&grant_type=authorization_code');
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            $this->user_session_key = $json['session_key'];
            return $json;
        }
        return false;
    }

    /**
     * [getBizdecryptData 获取小程序加被加密的用户数据]
     * @Author    ZiShang520@gmail.com
     * @DateTime  2017-10-19T15:39:29+0800
     * @copyright (c)                      ZiShang520     All           Rights Reserved
     * @param     [type]                   $encryptedData [description]
     * @param     [type]                   $iv            [description]
     * @param     string                   $session_key   [description]
     * @return    [type]                                  [description]
     */
    public function getBizdecryptData($encryptedData, $iv, $session_key = '')
    {
        $session_key = empty($session_key) ? $this->user_session_key : $session_key;
        if (empty($session_key)) {
            return false;
        }
        if (strlen($session_key) != 24) {
            $this->errCode = '-41001';
            $this->errMsg = 'encodingAesKey invalid';
            return false;
        }
        if (strlen($iv) != 24) {
            $this->errCode = '-41002';
            $this->errMsg = 'encodingAesIv invalid';
            return false;
        }
        $result = openssl_decrypt(base64_decode($encryptedData), "AES-128-CBC", base64_decode($session_key), OPENSSL_RAW_DATA, base64_decode($iv));
        $json = json_decode($result, true);
        if (!$json) {
            $this->errCode = '-41004';
            $this->errMsg = 'Decrypt the buffer obtained after the illegal';
            return false;
        }
        return $json;
    }
    /**
     * [getTemplateTitleList 获取小程序模板库标题列表]
     * @Author    ZiShang520@gmail.com
     * @DateTime  2017-10-20T14:41:03+0800
     * @copyright (c)                      ZiShang520 All           Rights Reserved
     * @param     [type]                   $data      [description]
     * @return    [type]                              [description]
     */
    public function getTemplateTitleList($data)
    {
        if (!$this->access_token && !$this->checkAuth()) {
            return false;
        }

        $result = $this->http_post(self::API_URL_PREFIX . self::WXS_TEMPLATE_TITLE_LIST_URL . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }
    /**
     * [getTemplateKeywordList 获取模板库某个模板标题下关键词库]
     * @Author    ZiShang520@gmail.com
     * @DateTime  2017-10-20T14:50:39+0800
     * @copyright (c)                      ZiShang520 All           Rights Reserved
     * @param     [type]                   $data      [description]
     * @return    [type]                              [description]
     */
    public function getTemplateKeywordList($data)
    {
        if (!$this->access_token && !$this->checkAuth()) {
            return false;
        }

        $result = $this->http_post(self::API_URL_PREFIX . self::WXS_TEMPLATE_KEYWORD_LIST_URL . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * [addTemplate 组合模板并添加至帐号下的个人模板库]
     * @Author    ZiShang520@gmail.com
     * @DateTime  2017-10-20T14:51:40+0800
     * @copyright (c)                      ZiShang520 All           Rights Reserved
     * @param     [type]                   $data      [description]
     */
    public function setTemplateAddTpl($data)
    {
        if (!$this->access_token && !$this->checkAuth()) {
            return false;
        }

        $result = $this->http_post(self::API_URL_PREFIX . self::WXS_TEMPLATE_ADD_TPL_URL . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * [getTemplateList 获取帐号下已存在的模板列表]
     * @Author    ZiShang520@gmail.com
     * @DateTime  2017-10-20T14:52:53+0800
     * @copyright (c)                      ZiShang520 All           Rights Reserved
     * @param     [type]                   $data      [description]
     * @return    [type]                              [description]
     */
    public function getTemplateList($data)
    {
        if (!$this->access_token && !$this->checkAuth()) {
            return false;
        }

        $result = $this->http_post(self::API_URL_PREFIX . self::WXS_TEMPLATE_LIST_URL . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * [setTemplateDelTpl 删除帐号下的某个模板]
     * @Author    ZiShang520@gmail.com
     * @DateTime  2017-10-20T14:53:49+0800
     * @copyright (c)                      ZiShang520 All           Rights Reserved
     * @param     [type]                   $data      [description]
     */
    public function setTemplateDelTpl($data)
    {
        if (!$this->access_token && !$this->checkAuth()) {
            return false;
        }

        $result = $this->http_post(self::API_URL_PREFIX . self::WXS_TEMPLATE_DEL_TPL_URL . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * [sendTemplateMsg 发送小程序模版消息]
     * @Author    ZiShang520@gmail.com
     * @DateTime  2017-10-20T14:55:12+0800
     * @copyright (c)                      ZiShang520 All           Rights Reserved
     * @param     [type]                   $data      [description]
     * @return    [type]                              [description]
     */
    public function sendTemplateMsg($data)
    {
        if (!$this->access_token && !$this->checkAuth()) {
            return false;
        }

        $result = $this->http_post(self::API_URL_PREFIX . self::WXS_TEMPLATE_SEND_URL . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }
    /**
     * log overwrite
     * @see Wechat::log()
     */
    protected function log($log)
    {
        if ($this->debug) {
            if (function_exists($this->logcallback)) {
                if (is_array($log)) {
                    $log = print_r($log, true);
                }
                return call_user_func($this->logcallback, $log);
            } elseif (class_exists('Log')) {
                Log::debug('wechat：' . $log);
                return true;
            }
        }
        return false;
    }

    /**
     * 重载设置缓存
     * @param string $cachename
     * @param mixed $value
     * @param int $expired
     * @return boolean
     */
    protected function setCache($cachename, $value, $expired)
    {
        return Cache::put($cachename, $value, $expired);
    }

    /**
     * 重载获取缓存
     * @param string $cachename
     * @return mixed
     */
    protected function getCache($cachename)
    {
        return Cache::get($cachename);
    }

    /**
     * 重载清除缓存
     * @param string $cachename
     * @return boolean
     */
    protected function removeCache($cachename)
    {
        return Cache::forget($cachename);
    }

    public function getError()
    {
        return Arr::get(['errCode' => $this->errCode, 'errMsg' => $this->errMsg, 'errText' => ErrCode::getErrText($this->errCode)], $key);
    }
}
