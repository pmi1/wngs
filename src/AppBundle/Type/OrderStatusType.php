<?php

namespace AppBundle\Type;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Статусы заказов
 */
class OrderStatusType extends AbstractType
{
    const _NEW = 1;
    const _PROGRESS = 2;
    const _CANCEL = 3;
    const _DONE = 4;

    /**
     * Массив статусов
     *
     * @return array
     */
    private function choices()
    {
        return [
            self::_NEW => 'new_order',
            self::_PROGRESS => 'progress_order',
            self::_CANCEL => 'cancel_order',
            self::_DONE => 'done_order',
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
