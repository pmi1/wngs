<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Message;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query\Expr\Join;

/**
 * MessageRepository
 */
class MessageRepository extends AbstractListRepository
{
	/**
     * Добавить новое сообщение
     *
     * @param array $options
     *
     * @return Int
     */
    public function addMessage($options)
    {
        $message = new Message();
        if (isset($options['to'])) {
            $message->setTo($options['to']);
        }
        if (isset($options['from'])) {
            $message->setFrom($options['from']);
        }
        if (isset($options['order'])) {
            $message->setOrder($options['order']);
        }
        if (isset($options['name'])) {
            $message->setName($options['name']);
        }
        
        $message->setCdate(new \DateTime('now'));
        
        if (isset($options['description'])) {
            $message->setDescription($options['description']);
        }
        if (isset($options['eventType'])) {
            $message->setEventType($options['eventType']);
        }

        $em = $this->getEntityManager();

        $em->persist($message);
        $em->flush();

        return $message->getId();
    }

    /**
     * Удалить сообщение
     *
     * @param \AppBundle\Entity\Message $message
     *
     * @return void
     */
    public function removeMessage(Message $message)
    {
        $id = $message->getId();

        $em = $this->getEntityManager();

        $em->remove($message);
        $em->flush();
    }

	/**
     * Получить список сообщений
     *
     * @param array $options список 
     *
     * @return QueryBuilder
     */
    public function getItems($options)
    {
        $em = $this->getEntityManager();
        $select = $em->createQueryBuilder()
            ->select('c')
            ->from(Message::class, 'c')
            ->orderBy('c.cdate', 'DESC');

        if (isset($options['to'])) {
            $select = $select
                ->andWhere('c.to = :to')
                ->setParameter('to', $options['to']);
        }

        if (isset($options['isNew'])) {
            $select = $select
                ->andWhere('c.isNew = :isNew')
                ->setParameter('isNew', $options['isNew']);
        }

        if (isset($options['order_id'])) {
            $select = $select
                ->andWhere('c.order = :order_id')
                ->setParameter('order_id', $options['order_id']);
        }

        return $select;
    }

    /**
     * Получить количeство
     *
     * @return int
     */
    public function getCount($userId)
    {
        $count = $this->getItems(['to' => $userId, 'isNew' => 1])
            ->select('count(1)')
            ->getQuery()->getSingleScalarResult();
        
        return $count;
    }
}