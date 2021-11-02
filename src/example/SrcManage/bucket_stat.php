<?php
require_once __DIR__ . '/../common.php';
use Wcs\SrcManage\FileManager;
use Wcs\Config;
use Wcs\MgrAuth;

$config = new Config();
$ak = $config->wcs_access_key();
$sk = $config->wcs_secret_key();

$auth = new MgrAuth($ak, $sk);

$client = new FileManager($auth);

$res = $client->bucketStat('bucketName', 'startDate', 'endDate');
print_r($res->code." ".$res->respBody);
print("\n");
