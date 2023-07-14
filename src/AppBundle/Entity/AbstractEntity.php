<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Field\IdField;

/**
 * Класс, содержащий общие методы для Entity классов
 */
abstract class AbstractEntity
{
    use IdField;

    /**
     * Метод позволяет создавать объект с помощью фабрики
     *
     * @return static
     */
    public static function create()
    {
        return new static();
    }
    
    /**
     * Convert to translit
     *
     * @param string $cyrStr
     *
     * @return string
     */
    public function translit($cyrStr)
    {
        $translitMap = array(
            "А" => "A", "Б" => "B", "В" => "V", "Г" => "G",
            "Д" => "D", "Е" => "E", "Ё" => "YO", "Ж" => "ZH", "З" => "Z", "И" => "I",
            "Й" => "Y", "К" => "K", "Л" => "L", "М" => "M", "Н" => "N",
            "О" => "O", "П" => "P", "Р" => "R", "С" => "S", "Т" => "T",
            "У" => "U", "Ф" => "F", "Х" => "H", "Ц" => "TS", "Ч" => "CH",
            "Ш" => "SH", "Щ" => "SCH", "Ъ" => "'", "Ы" => "YI", "Ь" => "",
            "Э" => "E", "Ю" => "YU", "Я" => "YA", "а" => "a", "б" => "b",
            "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ё" => "yo", "ж" => "zh",
            "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l",
            "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
            "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h",
            "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "'",
            "ы" => "yi", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya", " " => '-'
            );
        
        $string = strtr($cyrStr, $translitMap);
        
        $string = preg_replace("~[^0-9a-zA-Z\']+~", '-', $string);
        
        return $string;
    }
    
    /**
     * Convert name to url
     *
     * @param string $cyrStr
     *
     * @return string
     */
    public function nameToLink($cyrStr)
    {
        return '/' . $this->translit($cyrStr) . '/';
    }
}
