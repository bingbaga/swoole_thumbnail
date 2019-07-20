<?php
class Load
{
    /* 路径映射 */
    public static $vendorMap = array(
        'app' => __DIR__ . DIRECTORY_SEPARATOR . 'app',
    );

    /**
     * 自动加载器
     * @param $class
     */
    public static function autoload($class)
    {
        $file = self::findFile($class);
        if (file_exists($file)) {
            self::includeFile($file);
        }
    }

    /**
     * 解析文件路径
     * @param $class
     * @return string
     */
    private static function findFile($class)
    {
        $vendor = substr($class, 0, strpos($class, '\\')); // 顶级命名空间
        $vendorDir = self::$vendorMap[$vendor]; // 文件基目录
        $filePath = substr($class, strlen($vendor)) . '.php'; // 文件相对路径
        return str_replace('\\', DIRECTORY_SEPARATOR, $vendorDir . $filePath); // 文件标准路径
    }

    /**
     * 引入文件
     * @param $file
     */
    private static function includeFile($file)
    {
        if (!empty($file) && is_file($file)) {
            include $file;
        }
    }
}