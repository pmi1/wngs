<?php

namespace AppBundle\Type;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Временные интервалы
 */
class TimeIntervalType extends AbstractType
{
    const UP_TO_HOURS_1 = 0;
    const UP_TO_HOURS_3 = 1;
    const UP_TO_HOURS_6 = 2;
    const UP_TO_HOURS_12 = 3;
    const HOURS_24 = 4;
    const DAYS_2 = 5;
    const DAYS_3 = 6;
    const DAYS_4 = 7;
    const GREATER_DAYS_4 = 8;
    
    /**
     * Массив временных интервалов
     *
     * @return array
     */
    private function choices()
    {
        return [
            self::UP_TO_HOURS_1 => 'time_interval_up_to_hours_1',
            self::UP_TO_HOURS_3 => 'time_interval_up_to_hours_3',
            self::UP_TO_HOURS_6 => 'time_interval_up_to_hours_6',
            self::UP_TO_HOURS_12 => 'time_interval_up_to_hours_12',
            self::HOURS_24 => 'time_interval_hours_24',
            self::DAYS_2 => 'time_interval_up_to_days_2',
            self::DAYS_3 => 'time_interval_up_to_days_3',
            self::DAYS_4 => 'time_interval_up_to_days_4',
            self::GREATER_DAYS_4 => 'time_interval_greater_days_4',
        ];
    }
    
    /**
     * Получить массив временных интервалов
     *
     * @return ArrayCollection
     */
    public static function getChoices(): ArrayCollection
    {
        return new ArrayCollection(self::choices());
    }
    
    /**
     * Получить массив временных интервалов в формате Sonata Admin
     *
     * @return ArrayCollection
     */
    public static function getChoicesSonata($locale = 'ru_Ru'): ArrayCollection
    {
        return new ArrayCollection(array_flip(self::choices()));
    }
}
