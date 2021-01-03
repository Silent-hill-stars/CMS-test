<?php


namespace core\base\settings;

use core\base\settings\Settings;

class ShopSettings
{
    /**
     * @var
     */
    static private $instance;

    private $baseSettings;

    private $templateArr = [
        'text' => [
            'price',
            'shop'
        ],
        'textarea' => [
            'goodsContent'
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
     * @return ShopSettings
     */
    public static function getInstance()
    {
        if (self::$instance instanceof self) {

            return self::$instance;
        }
        self::$instance = new self();
        self::$instance->baseSettings = Settings::getInstance();
        $baseProperties = self::$instance->baseSettings::clueProperties(get_class());
        self::$instance->setProperty($baseProperties);
        return self::$instance;
    }

    public function setProperty($properties)
    {
        if (is_array($properties) && $properties != null) {
            foreach ($properties as $name => $property) {
                self::$instance->$name = $property;
            }
        }
    }
    private function __construct()
    {
    }

    private function __clone()
    {
    }
}