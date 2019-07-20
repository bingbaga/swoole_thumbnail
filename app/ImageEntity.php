<?php

namespace app;

class ImageEntity {
    const CACHE = 'cache/';
    private $config = [];

    public function __construct() {

    }

    public function setConfig(array $config) {
        $this->config = $config;
    }

    public function getConfig(): array {
        return $this->config;
    }

    public function resize(): string {

// 缩放
        $dst_w = $this->getConfig()['w'];
        $dst_h = $this->getConfig()['h'];
// 创建目标画布资源
        $dst_image = imagecreatetruecolor($dst_w, $dst_h);
        $src_image = imagecreatefromstring(file_get_contents($this->getConfig()['src']));
        $src_width = imagesx($src_image);
        $src_height = imagesy($src_image);
// 通过图片文件创建画布资源

        imagecopyresampled($dst_image, $src_image, 0, 0, 0, 0, $dst_w, $dst_h, $src_width, $src_height);

        $key = md5($this->getConfig()['src']);
        imagejpeg($dst_image, self::CACHE . $key . '.jpg');

        imagedestroy($dst_image);
        return self::CACHE . $key . '.jpg';
    }

    //返回的是文件完整路径
    public function getPicByKey(): string {
        $key = md5($this->getConfig()['src']);
        if (file_exists(self::CACHE . $key . '.jpg')) {
            return self::CACHE . $key . '.jpg';
        }
        return $this->resize();
    }

}
