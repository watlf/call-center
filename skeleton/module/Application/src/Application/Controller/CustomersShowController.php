<?php
/**
 * Created by PhpStorm.
 * User: <andrey.lyahovski@gmail.com>
 * Date: 6/28/15
 * Time: 2:21 AM
 */

namespace Application\Controller;

use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class CustomersShowController extends AbstractExtendedController
{
    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        $request = $this->params()->fromPost();


       if (isset($request['page'], $request['rows'], $request['sidx'], $request['sord'])
           && $request['page'] > 0
       ) {
           /**
            * @var $customersRepository \Application\Repositories\Customers
            */
           $customersRepository = $this->getEntityManager()->getRepository('Application\Entity\Customers');

           $offset  = ($request['page'] - 1) * $request['rows'];
           $limit   = (int)$request['rows'];
           $orderBy = $request['sidx'];
           $sort    = $request['sord'];

           try {
               $response = $customersRepository->getLimitCustomersOrderByColumn(
                   $offset,
                   $limit,
                   $orderBy,
                   $sort
               );
           } catch (\Exception $exc) {
               $response = [];
           }

           $rows = [];

           if ($response) {
               foreach ($response as $i => $row) {
                   $rows['rows'][$i]['id'] = $row['id'];
                   $rows['rows'][$i]['cell'] = $row;
               }

               $count = $customersRepository->getCountCustomers();

               $rows['records'] = $count;
               $rows['total'] = ceil($count / $limit);
               $rows['page'] = $request['page'];
           }

           $result = new JsonModel($rows);
       } else {
           $result = new ViewModel();
       }

        return $result;
    }
}