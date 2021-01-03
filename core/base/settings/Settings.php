<?php


namespace core\base\settings;


class Settings
{
    /**
     * @var
     */
    static private $instance;

    private $routes = [
        'admin' => [
            'name' => 'admin',
            'path' => 'core/admin/controller/',
            'hrUrl' => false
        ],
        'settings' => [
            'path' => 'core/base/settings/'
        ],
        'plugins' => [
            'path' => 'core/plugins/',
            'hrUrl' => false
        ],
        'user' => [
            'path' => 'core/user/controller/',
            'hrUrl' => true,
            'routes' => [

            ]
        ],
        'default' => [
            'controller' => 'IndexController',
            'inputMethod' => 'inputData',
            'outputMethod' => 'outputData'
        ]
    ];

    private $templateArr = [
        'text' => [
            'name',
            'phone',
            'address'
        ],
        'textarea' => [
            'content',
            'keywords'
        ]
    ];


    /**
     * @param $property
     * @return mixed
     */
    public static function get($property)
    {
        return self::getInstance()->$property;
    }

    /**
     * @return Settings
     */
    public static function getInstance(): Settings
    {
        if (self::$instance instanceof self) {

            return self::$instance;
        }

        return self::$instance = new self();
    }

    /**
     * @param $class
     * @return array
     */
    public static function clueProperties($class): array
    {
        $baseProperties = [];
        foreach (self::$instance as $name => $item) {
            $property = $class::get($name);
            if (is_array($property) && is_array($item)) {
                $baseProperties[$name] = self::$instance->arrayMergeRecursive($item, $property);
                continue;
            }
            if (! $property) $baseProperties[$name] = self::$instance->$name;

        }

        return $baseProperties;
    }

    /**
     * @return mixed
     */
    public function arrayMergeRecursive(): array
    {
        $arrays = func_get_args();
        $base = array_shift($arrays);

        foreach ($arrays as $array) {
            foreach ($array as $key => $value) {
                if (is_array($value) && is_array($base[$key])) {
                    $base[$key] = $this->arrayMergeRecursive($base[$key], $value);
                } else {
                    if (is_int($key)) {
                        if (! in_array($value, $base)) {
                            array_push($base, $value);
                            continue;
                        }
                        $base[$key] = $value;
                    }
                }
            }
        }

        return $base;
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }
}