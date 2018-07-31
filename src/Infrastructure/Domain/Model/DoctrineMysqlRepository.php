<?php
declare(strict_types=1);

namespace Planet\Infrastructure\Domain\Model;

use Doctrine\ORM\EntityManagerInterface;

class DoctrineMysqlRepository
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * @inheritdoc
     */
    public function beginTransaction()
    {
        return $this->em->beginTransaction();
    }
    
    /**
     * @inheritdoc
     */
    public function commit()
    {
        $this->em->flush();
        return $this->em->commit();
    }
    
    /**
     * @inheritdoc
     */
    public function rollback()
    {
        return $this->em->rollback();
    }
}
