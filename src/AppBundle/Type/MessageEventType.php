<?php

namespace AppBundle\Type;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Типы сообщений
 */
class MessageEventType extends AbstractType
{
    const _CHANGE_ORDER_STATUS_NEW = 1;
    const _CHANGE_ORDER_STATUS_PROGRESS = 2;
    const _CHANGE_ORDER_STATUS_CANCEL = 3;
    const _CHANGE_ORDER_STATUS_DONE = 4;
    const _CHANGE_ORDER_DELIVERY_ADDR = 5;
    const _ADD_NEW_ORDER = 6;
    const _ADD_NEW_MESSAGE = 7;
    const _ADD_ITEM_TO_FAVORITE = 8;
    const _CHANGE_ORDER_DISCOUNT = 9;
    const _CHANGE_ORDER_DELIVERY = 10;
    const _ADD_REVIEW = 11;

    /**
     * Массив событий
     *
     * @return array
     */
    private function choices()
    {
        return [
            self::_CHANGE_ORDER_STATUS_NEW => 'change_order_status_new',
            self::_CHANGE_ORDER_STATUS_PROGRESS => 'change_order_status_progress',
            self::_CHANGE_ORDER_STATUS_CANCEL => 'change_order_status_cancel',
            self::_CHANGE_ORDER_STATUS_DONE => 'change_order_status_done',
            self::_CHANGE_ORDER_DELIVERY_ADDR => 'change_order_delivery_addr',
            self::_ADD_NEW_ORDER => 'add_new_order',
            self::_ADD_NEW_MESSAGE => 'add_new_message',
            self::_ADD_ITEM_TO_FAVORITE => 'add_item_to_favorite',
            self::_CHANGE_ORDER_DISCOUNT => 'change_order_discount',
            self::_CHANGE_ORDER_DELIVERY => 'change_order_delivery',
            self::_ADD_REVIEW => 'add_review',
        ];
    }
    
    /**
     * Получить массив типов сообщений
     *
     * @return ArrayCollection
     */
    public static function getChoices(): ArrayCollection
    {
        return new ArrayCollection(self::choices());
    }
    
    /**
     * Получить массив типов сообщений в формате Sonata Admin
     *
     * @return ArrayCollection
     */
    public static function getChoicesSonata($locale = 'ru_Ru'): ArrayCollection
    {
        return new ArrayCollection(array_flip(self::choices()));
    }
}
