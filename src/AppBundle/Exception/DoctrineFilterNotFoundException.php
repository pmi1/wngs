<?php

namespace AppBundle\Exception;

use Symfony\Component\HttpFoundation\Response;

/**
 * Исключение, если фильтр доктрины не найден
 *
 *
 */
class DoctrineFilterNotFoundException extends \UnexpectedValueException
{
    /**
     * FilterNotFoundException constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        parent::__construct(
            sprintf('Фильтр с именем %s не найден', $name),
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}
