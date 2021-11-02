<?php
require '../../vendor/autoload.php';
use Wcs\Http\PutPolicy;
use Wcs\Utils;

$pp = new PutPolicy();

print_r($pp);
// 网宿的视频存储空间
$bucketName = 'cstvmgr-vod';

//转码格式
$vod = '';

$key = 'MjAyMS8xMC8yNi82NDc4MTQ4MzE2ODU0M2YxOWEyNjZlNDYwMzYyY2MyMy5tcDQ=';

$expire = '1635319817611';



// 视频存储名字base64加密后结果
$fileKey = Utils::url_safe_base64_decode($key);

/**重新更新文件名字 start*/
$file     = explode('/',$fileKey);
$fileName = explode('.',$file[count($file) - 1]);
$prefix   = md5($fileName[0] .time());
$suffix   = '.'.$fileName[1];
$fileName = $file[0].'/'.$file[1].'/'.$file[2].'/'.$prefix.$suffix;


/**重新更新文件名字 end*/

/**
 * 设置转码模板等持久化操作指令列表<br />
 * 转换为flv指令：avthumb/flv/vb/1.25m<br />
 * 视频截图指令：vframe/jpg/offset/1<br />
 * 使用分号";"分隔
 */

switch ($vod) {
    case 'sd':
        $fileNameTransCode = $file[0].'/'.$file[1].'/'.$file[2].'/'.$prefix.'_sd'.$suffix;
        $pp->persistentOps = "avthumb/mp4/vb/800k/vcodec/libx264/acodec/libfaac/s/640x480|saveas/".Utils::url_safe_base64_encode($bucketName.':'.$fileNameTransCode);
        break;
    case 'hd':
        $fileNameTransCode = $file[0].'/'.$file[1].'/'.$file[2].'/'.$prefix.'_hd'.$suffix;
        $pp->persistentOps = "avthumb/mp4/vb/1200k/vcodec/libx264/acodec/libfaac/s/720x480|saveas/".Utils::url_safe_base64_encode($bucketName.':'.$fileNameTransCode);
        break;
    case 'fhd':
        $fileNameTransCode = $file[0].'/'.$file[1].'/'.$file[2].'/'.$prefix.'_fhd'.$suffix;
        $pp->persistentOps = "avthumb/mp4/vb/1200k/vcodec/libx264/acodec/libfaac/s/1280x720|saveas/".Utils::url_safe_base64_encode($bucketName.':'.$fileNameTransCode);
        break;
    case 'low':
        $fileNameTransCode = $file[0].'/'.$file[1].'/'.$file[2].'/'.$prefix.'_low'.$suffix;
        $pp->persistentOps = "avthumb/mp4/vb/800k/vcodec/libx264/acodec/libfaac/s/640x480|saveas/".Utils::url_safe_base64_encode($bucketName.':'.$fileNameTransCode);
        break;
    default:

}

// 指定上传的目标资源空间（bucektName）和资源名（fileName）
$pp->scope = $bucketName . ':' . $fileName;

//名字相同是否覆盖  1 覆盖 0 不覆盖
$pp->overwrite = 1;

// 返回需要携带的参数
$pp->returnBody = "url=$(url)&persid=$(persistentId)&avinfo=$(avinfo)";

//        $pp->persistentNotifyUrl = 'http://www.cditv.cn/api.php?op=ws_notify&act=notify';
$pp->persistentNotifyUrl = '';
// 上传请求授权的截止时间戳, 单位为毫秒
$pp->deadline = $expire;

// 获取计算后的token
$token = $pp->get_token();

echo $token;