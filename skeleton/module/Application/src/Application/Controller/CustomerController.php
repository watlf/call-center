<?php
/**
 * Created by PhpStorm.
 * User: <andrey.lyahovski@gmail.com>
 * Date: 6/24/15
 * Time: 8:32 PM
 */

namespace Application\Controller;

use Application\Form\CustomerForm;
use Application\InputFilter\CustomerInputFilter;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class CustomerController extends AbstractExtendedController
{
    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        /**
         * @var $customersRepository \Application\Repositories\Customers
         */
        $customersRepository = $this->getEntityManager()->getRepository('Application\Entity\Customers');

        $result = $customersRepository->getAllCustomers();

        return new ViewModel(
            array(
                'customers' => $result
            )
        );
    }

    /**
     * @return ViewModel|JsonModel
     */
    public function editAction()
    {
        $id = $this->params()->fromRoute('id');

        if (!$id) {
            return $this->redirect()->toRoute('customer');
        }

        /**
         * @var $customersRepository \Application\Repositories\Customers
         */
        $customersRepository = $this->getEntityManager()->getRepository('Application\Entity\Customers');

        /**
         * @var $customer \ArrayObject
         */
        $customer = $customersRepository->getCustomerArrayObjectById($id);

        if (!$customer->count()) {
            return $this->redirect()->toRoute('customer');
        }

        $form = new CustomerForm();

        $form->bind($customer);

        $form->get('button')->setAttribute('value', 'Edit customer');
        $form->get('action')->setAttribute('value', (int)$id);

        $request = $this->params()->fromPost('manageCustomer');

        if ($request) {
            $customerInputFilter = new CustomerInputFilter();
            $response = $this->runEdit($form, $customersRepository, $customerInputFilter, $request);

            $return = new JsonModel(
                $response
            );
        } else {

            $return = new ViewModel(
                array(
                    'form' => $form
                )
            );
        }

        return $return;
    }

    /**
     * @return ViewModel|JsonModel
     */
    public function addAction()
    {
        $response = [];

        $form = new CustomerForm();

        $form->get('button')->setAttribute('value', 'Add customer');
        $form->get('action')->setAttribute('value', 'add');

        $request = $this->params()->fromPost('manageCustomer');

        if ($request) {
            /**
             * @var $customersRepository \Application\Repositories\Customers
             */
            $customersRepository = $this->getEntityManager()->getRepository('Application\Entity\Customers');

            $isIssetPhone = $customersRepository->getCustomerByPhoneNumber(
                $request['phone']
            );

            if (!$isIssetPhone) {
                $customerInputFilter = new CustomerInputFilter();

                $response = $this->runAdd($form, $customersRepository, $customerInputFilter, $request);
            } else {
                $response['error'] = sprintf('This phone number %s already exists.', $request['phone']);
            }

            $result = new JsonModel(
                $response
            );

        } else {
            $result = new ViewModel(
                array(
                    'form' => $form
                )
            );
        }

        return $result;
    }

    /**
     * @return ViewModel
     */
    public function infoAction()
    {
        $id = $this->params()->fromRoute('id');

        if (!$id) {
            return $this->redirect()->toRoute('customer');
        }

        /**
         * @var $customersRepository \Application\Repositories\Customers
         */
        $customersRepository = $this->getEntityManager()->getRepository('Application\Entity\Customers');

        $result = $customersRepository->getAllInfoByCustomerId($id);

        return new ViewModel(
            array(
                'customerInfo' => $result,
                'customerId'   => (int)$id
            )
        );
    }
}