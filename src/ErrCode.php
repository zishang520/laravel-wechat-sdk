<?php
namespace luoyy\Wechat;

/**
 *    微信公众平台PHP-SDK, 全局返回码类
 *  @author  binsee <binsee@163.com>
 *  @link https://github.com/binsee/wechat-php-sdk
 *  @version 1.0
 *  usage:
 *      $ret=ErrCode::getErrText(40001); //错误码可以通过公众号类库的公开变量errCode得到
 *      if ($ret)
 *          echo $ret;
 *      else
 *          echo "未找到对应的内容";
 */
class ErrCode
{
    public static $errCode = array(
        '-1' => '系统繁忙',
        '0' => '请求成功',
        '20002' => 'POST参数非法',
        '40001' => '获取access_token时AppSecret错误，或者access_token无效',
        '40002' => '不合法的凭证类型',
        '40003' => '不合法的OpenID',
        '40004' => '不合法的媒体文件类型',
        '40005' => '不合法的文件类型',
        '40006' => '不合法的文件大小',
        '40007' => '不合法的媒体文件id',
        '40008' => '不合法的消息类型',
        '40009' => '不合法的图片文件大小',
        '40010' => '不合法的语音文件大小',
        '40011' => '不合法的视频文件大小',
        '40012' => '不合法的缩略图文件大小',
        '40013' => '不合法的APPID',
        '40014' => '不合法的access_token',
        '40015' => '不合法的菜单类型',
        '40016' => '不合法的按钮个数',
        '40017' => '不合法的按钮类型',
        '40018' => '不合法的按钮名字长度',
        '40019' => '不合法的按钮KEY长度',
        '40020' => '不合法的按钮URL长度',
        '40021' => '不合法的菜单版本号',
        '40022' => '不合法的子菜单级数',
        '40023' => '不合法的子菜单按钮个数',
        '40024' => '不合法的子菜单按钮类型',
        '40025' => '不合法的子菜单按钮名字长度',
        '40026' => '不合法的子菜单按钮KEY长度',
        '40027' => '不合法的子菜单按钮URL长度',
        '40028' => '不合法的自定义菜单使用用户',
        '40029' => '不合法的oauth_code',
        '40030' => '不合法的refresh_token',
        '40031' => '不合法的openid列表',
        '40032' => '不合法的openid列表长度',
        '40033' => '不合法的请求字符，不能包含\uxxxx格式的字符',
        '40035' => '不合法的参数',
        '40038' => '不合法的请求格式',
        '40039' => '不合法的URL长度',
        '40050' => '不合法的分组id',
        '40051' => '分组名字不合法',
        '40099' => '该 code 已被核销',
        '41001' => '缺少access_token参数',
        '41002' => '缺少appid参数',
        '41003' => '缺少refresh_token参数',
        '41004' => '缺少secret参数',
        '41005' => '缺少多媒体文件数据',
        '41006' => '缺少media_id参数',
        '41007' => '缺少子菜单数据',
        '41008' => '缺少oauth code',
        '41009' => '缺少openid',
        '42001' => 'access_token超时',
        '42002' => 'refresh_token超时',
        '42003' => 'oauth_code超时',
        '42005' => '调用接口频率超过上限',
        '43001' => '需要GET请求',
        '43002' => '需要POST请求',
        '43003' => '需要HTTPS请求',
        '43004' => '需要接收者关注',
        '43005' => '需要好友关系',
        '44001' => '多媒体文件为空',
        '44002' => 'POST的数据包为空',
        '44003' => '图文消息内容为空',
        '44004' => '文本消息内容为空',
        '45001' => '多媒体文件大小超过限制',
        '45002' => '消息内容超过限制',
        '45003' => '标题字段超过限制',
        '45004' => '描述字段超过限制',
        '45005' => '链接字段超过限制',
        '45006' => '图片链接字段超过限制',
        '45007' => '语音播放时间超过限制',
        '45008' => '图文消息超过限制',
        '45009' => '接口调用超过限制',
        '45010' => '创建菜单个数超过限制',
        '45015' => '回复时间超过限制',
        '45016' => '系统分组，不允许修改',
        '45017' => '分组名字过长',
        '45018' => '分组数量超过上限',
        '45024' => '账号数量超过上限',
        "45047" => '客服接口下行条数超过上限',
        '46001' => '不存在媒体数据',
        '46002' => '不存在的菜单版本',
        '46003' => '不存在的菜单数据',
        '46004' => '不存在的用户',
        '47001' => '解析JSON/XML内容错误',
        '48001' => 'api功能未授权',
        '50001' => '用户未授权该api',
        '61450' => '系统错误',
        '61451' => '参数错误',
        '61452' => '无效客服账号',
        '61453' => '账号已存在',
        '61454' => '客服帐号名长度超过限制(仅允许10个英文字符，不包括@及@后的公众号的微信号)',
        '61455' => '客服账号名包含非法字符(英文+数字)',
        '61456' => '客服账号个数超过限制(10个客服账号)',
        '61457' => '无效头像文件类型',
        '61458' => '客户正在被其他客服接待',
        '61459' => '客服不在线',
        '61500' => '日期格式错误',
        '61501' => '日期范围错误',
        '87014' => '内容含有违法违规内容',
        '89236' => '该插件不能申请',
        '89237' => '已经添加该插件',
        '89238' => '申请或使用的插件已经达到上限',
        '89239' => '该插件不存在',
        '89240' => '无法进行此操作，只有“待确认”的申请可操作通过/拒绝',
        '89241' => '无法进行此操作，只有“已拒绝/已超时”的申请可操作删除',
        '89242' => '该appid不在申请列表内',
        '89243' => '“待确认”的申请不可删除',
        '89044' => '不存在该插件appid',
        '92000' => '该经营资质已添加，请勿重复添加',
        '92002' => '附近地点添加数量达到上线，无法继续添加',
        '92003' => '地点已被其它小程序占用',
        '92004' => '附近功能被封禁',
        '92005' => '地点正在审核中',
        '92007' => '地点审核失败',
        '92008' => '程序未展示在该地点',
        '93009' => '小程序未上架或不可见',
        '93010' => '地点不存在',
        '93011' => '个人类型小程序不可用',
        '93012' => '非普通类型小程序（门店小程序、小店小程序等）不可用',
        '93013' => '从腾讯地图获取地址详细信息失败',
        '93014' => '同一资质证件号重复添加',
        '7000000' => '请求正常，无语义结果',
        '7000001' => '缺失请求参数',
        '7000002' => 'signature 参数无效',
        '7000003' => '地理位置相关配置 1 无效',
        '7000004' => '地理位置相关配置 2 无效',
        '7000005' => '请求地理位置信息失败',
        '7000006' => '地理位置结果解析失败',
        '7000007' => '内部初始化失败',
        '7000008' => '非法 appid（获取密钥失败）',
        '7000009' => '请求语义服务失败',
        '7000010' => '非法 post 请求',
        '7000011' => 'post 请求 json 字段无效',
        '7000030' => '查询 query 太短',
        '7000031' => '查询 query 太长',
        '7000032' => '城市、经纬度信息缺失',
        '7000033' => 'query 请求语义处理失败',
        '7000034' => '获取天气信息失败',
        '7000035' => '获取股票信息失败',
        '7000036' => 'utf8 编码转换失败',
        '-41001' => 'encodingAesKey 非法',
        '-41002' => 'encodingAesIv 非法',
        '-41003' => 'aes 解密失败',
        '-41004' => '解密后得到的buffer非法',
        '-41005' => 'base64加密失败',
        '-41006' => 'base64解密失败'
    );

    public static function getErrText($err)
    {
        if (isset(self::$errCode[$err])) {
            return self::$errCode[$err];
        } else {
            return false;
        }
    }
}