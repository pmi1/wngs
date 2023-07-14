<?php

namespace AppBundle\Type;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Типы поступивших заявок
 */
class FormAnswerType extends AbstractType
{
    const BUY_FORM = 1;
    const MESSAGE_FORM = 2;
    const DISCOUNT_FORM = 3;
    const FAVORITE = 4;
    
    /**
     * Массив типов заявок
     *
     * @return array
     */
    private function choices()
    {
        return [
            self::BUY_FORM => 'buy_form',
            self::MESSAGE_FORM => 'message_form',
            self::DISCOUNT_FORM => 'discount_form',
            self::FAVORITE => 'favorite',
        ];
    }
    
    /**
     * Получить массив типов заявок
     *
     * @return ArrayCollection
     */
    public static function getChoices(): ArrayCollection
    {
        return new ArrayCollection(self::choices());
    }
    
    /**
     * Получить массив типов заявок в формате Sonata Admin
     *
     * @return ArrayCollection
     */
    public static function getChoicesSonata($locale = 'ru_Ru'): ArrayCollection
    {
        return new ArrayCollection(array_flip(self::choices()));
    }
}
