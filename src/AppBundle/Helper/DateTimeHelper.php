<?php

namespace AppBundle\Helper;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Класс с полезными функциями для типа DateTime
 *
 *
 */
class DateTimeHelper extends AbstractHelper
{
    /**
     * Метод возвращает интервал годов от и до
     *
     * @param \DateTime $from от какого года
     * @param \DateTime $to до какого года
     * @return ArrayCollection Коллекция годов
     * @throws \Exception
     */
    public static function getYearsIntervalCollection(\DateTime $from, \DateTime $to): ArrayCollection
    {
        if ($from > $to) {
            throw new \Exception('Интервал ОТ не может быть больше чем ДО');
        }

        $collection = new ArrayCollection();

        for ($year = $to->format('Y'); $year > $from->format('Y'); $year--) {
            $collection->set($year, $year);
        }

        return $collection;
    }
}
