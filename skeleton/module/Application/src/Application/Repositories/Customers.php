<?php

namespace Application\Repositories;

use Doctrine\ORM\EntityRepository;
use Application\Entity\Customers as CustomersEntity;

/**
 * Customers
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Customers extends EntityRepository
{
    /**
     * @return array
     */
    public function getAllCustomers()
    {
       return $this->createQueryBuilder('c')
           ->select('c')
           ->getQuery()
           ->getArrayResult();
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $orderBy
     * @param string $sort
     *
     * @return array
     */
    public function getLimitCustomersOrderByColumn($offset, $limit, $orderBy, $sort)
    {
        return $this->createQueryBuilder('c')
            ->select('c')
            ->orderBy('c.'.$orderBy, $sort)
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @return int
     */
    public function getCountCustomers()
    {
        return $this->createQueryBuilder('c')
            ->select('count(c.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Get all info about customer and him calls by customer id.
     * @param int $id
     *
     * @return array
     */
    public function getAllInfoByCustomerId($id)
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('calls', 'customer')
            ->from('Application\Entity\Customers', 'customer')
            ->leftJoin(
                'Application\Entity\Calls',
                'calls',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'customer.id = calls.customerId'
            )
            ->where('customer = :id')
            ->setParameter('id', $id);

        $customer = $qb->getQuery()->getArrayResult();

        $result = array();

        foreach ($customer as $calls) {
            if (isset($calls['firstName'])) {
                $result['customer'] = $calls;
            } elseif(!is_null($calls)) {
                $result['customer']['calls'][] = $calls;
            }
        }

        return $result;
    }

    /**
     * @param array $data
     *
     * @return boolean
     */
    public function addRow(array $data)
    {
        $result = true;

        try {
            $customer = new CustomersEntity();

            $customer
                ->setFirstName($data['firstName'])
                ->setLastName($data['lastName'])
                ->setPhone($data['phone'])
                ->setAddress($data['address'])
                ->setStatus($data['status']);

            $this->_em->persist($customer);
            $this->_em->flush();
        } catch (\Exception $exc) {
            $result = false;
        }

        return $result;
    }

    /**
     * @param array $data
     *
     * @return boolean
     */
    public function editRow(array $data)
    {
        $result = true;

        try {
            $customer = new CustomersEntity();

            $customer
                ->setFirstName($data['firstName'])
                ->setLastName($data['lastName'])
                ->setPhone($data['phone'])
                ->setAddress($data['address'])
                ->setStatus($data['status'])
                ->setId($data['id']);

            $this->_em->merge($customer);
            $this->_em->flush();
        } catch (\Exception $exc) {
            $result = false;
        }

        return $result;
    }

    /**
     * @param string $phone
     *
     * @return array
     */
    public function getCustomerByPhoneNumber($phone)
    {
        $dql = "SELECT c FROM {$this->_entityName} c WHERE c.phone = :phone";

        return $this->_em
            ->createQuery($dql)
            ->setParameter('phone', $phone)
            ->getArrayResult();
    }

    /**
     * @param int $id
     *
     * @return \ArrayObject
     */
    public function getCustomerArrayObjectById($id)
    {
        $result = new \ArrayObject();

        /**
         * @var $customer CustomersEntity
         */
        $customer = $this->findOneById(
            array('id' => $id)
        );

        if (!is_null($customer)) {
            $result['firstName'] = $customer->getFirstName();
            $result['lastName']  = $customer->getLastName();
            $result['address']   = $customer->getAddress();
            $result['phone']     = $customer->getPhone();
            $result['status']    = $customer->getStatus();
            $result['id']        = $customer->getId();
        }

        return $result;
    }
}
