<?php

namespace AppBundle\Twig;

use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Type\TimeIntervalType;
use Twig_Extension;
use Twig_SimpleFilter;


/**
 * Расширяем стандартные фильтры для твига
 */
class AppExtension extends Twig_Extension
{
    /**
     * {@inheritDoc}
     */
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('main', [$this, 'mainFilter']),
            new Twig_SimpleFilter('url', [$this, 'urlFilter']),
            new Twig_SimpleFilter('dateFormatter', [$this, 'dateFormatterFilter']),
            new Twig_SimpleFilter('rating', [$this, 'ratingFilter']),
            new Twig_SimpleFilter('timeInterval', [$this, 'timeIntervalFilter']),
        ];
    }

    /**
     * Выбираем основное медиа из массива
     *
     * @param ArrayCollection $collection
     *
     * @return Media
     */
    public function mainFilter($collection)
    {
        $images = $collection->toArray();
        
        $enabledImages = [];
        
        foreach ($images as $image) {
            if ($image->getEnabled() && $image->getMedia() && $image->getMedia()->getEnabled()) {
                $enabledImages[] = $image;
            }
        }
        
        usort($enabledImages, [$this, "mainSort"]);
        
        return array_shift($enabledImages);
    }
    
    /**
     * Сортируем массив медиа
     *
     * @param Media $a
     * @param Media $b
     *
     * @return int
     */
    public function mainSort($a, $b)
    {
        if ($a->getMain() === $b->getMain()) {
            if ($a->getPosition() === $b->getPosition()) {
                return 0;
            } elseif ($a->getPosition() > $b->getPosition()) {
                return 1;
            } else {
                return -1;
            }
        } elseif ($a->getMain() < $b->getMain()) {
            return 1;
        } else {
            return -1;
        }
    }
        
    /**
     * Форматируем дату с учетом локали
     *
     * @param \Datetime $datetime дата
     * @param string $locale локаль
     * @param string $pattern формат даты для вывода
     *
     * @return string
     */
    public function dateFormatterFilter(\Datetime $datetime, $locale, $pattern = 'LLLL Y')
    {
        $formatter = new \IntlDateFormatter($locale, \IntlDateFormatter::LONG, \IntlDateFormatter::LONG);
        $formatter->setPattern($pattern);

        return $formatter->format($datetime);
    }
    
    /**
     * Удаляем из урла двойные слэши
     *
     * @param string $url
     *
     * @return string
     */
    public function urlFilter($url)
    {
        return preg_replace('/([^:])(\/{2,})/', '$1/', $url);
    }
    
    /**
     * Возвращаем алиас временного интевала по ключу
     *
     * @param int $key ключ
     *
     * @return string|null
     */
    public function timeIntervalFilter($key)
    {
        $choices = TimeIntervalType::getChoices();
        
        if (isset($choices[$key])) {
            return $choices[$key];
        }
        
        return null;
    }
}
