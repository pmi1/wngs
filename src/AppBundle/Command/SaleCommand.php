<?php

namespace AppBundle\Command;

use AppBundle\Entity\ItemSelection;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * SaleCommand
 *
 * Класс для очистки устаревших записей сравнения
 */
class SaleCommand extends ContainerAwareCommand
{
    /**
     * Конфигурация
     *
     * @return null
     */
    protected function configure()
    {
        $this
            ->setName('app:sale')
            ->setDescription('Перевод товаров Flash-Sale \ Sale Predictor')
        ;
    }

    /**
     * Механика Flash-Sale \ Sale Predictor
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $qb = $this->getContainer()->get('doctrine')->getManager()->createQueryBuilder();
        $q = $qb->update(ItemSelection::class, 't')
                ->set('t.selection', $this->getContainer()->getParameter('flash_sale_id'))
                ->set('t.createdAt', 'CURRENT_TIMESTAMP()')
                ->where('CURRENT_TIMESTAMP() >= DATE_ADD(t.createdAt, 3, \'DAY\') and t.selection = ?1')
                ->setParameter(1, $this->getContainer()->getParameter('sale_predictor_id'))
                ->getQuery()
                ->execute();

        $q = $qb->update(ItemSelection::class, 't')
                ->set('t.selection', $this->getContainer()->getParameter('sale_predictor_id'))
                ->set('t.createdAt', 'CURRENT_TIMESTAMP()')
                ->where('CURRENT_TIMESTAMP() >= DATE_ADD(t.createdAt, 3, \'DAY\') and t.selection = ?1')
                ->setParameter(1, $this->getContainer()->getParameter('flash_sale_id'))
                ->getQuery()
                ->execute();
    }
}
