<?php
/**
 * Created by PhpStorm.
 * User: <andrey.lyahovski@gmail.com>
 * Date: 6/25/15
 * Time: 8:18 PM
 */

namespace Application\Controller;

use Application\Form\CallsForm;
use Application\InputFilter\CallInputFilter;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class CallsController extends AbstractExtendedController
{
    /**
     * @return JsonModel|ViewModel
     */
    public function addAction()
    {
        $id = $this->params()->fromRoute('id');

        if (!$id) {
            return $this->redirect()->toRoute('customer');
        }

        $form = new CallsForm();

        $form->get('button')->setAttribute('value', 'Add call');
        $form->get('action')->setAttribute('value', (int)$id);
        $form->get('customerId')->setAttribute('value', (int)$id);

        $request = $this->params()->fromPost('manageCall');

        if ($request) {

            $callInputFilter = new CallInputFilter();

            /**
             * @var $callsRepository \Application\Repositories\Calls
             */
            $callsRepository = $this->getEntityManager()->getRepository('Application\Entity\Calls');

            $response = $this->runAdd($form, $callsRepository, $callInputFilter, $request);

            $result = new JsonModel(
                $response
            );
        } else {
            $result = new ViewModel(
                [
                    'form' =>$form,
                    'customerId' => (int)$id
                ]
            );
        }

        return $result;
    }

    /**
     * @return JsonModel|ViewModel
     */
    public function editAction()
    {
        $id = $this->params()->fromRoute('id');

        if (!$id) {
            return $this->redirect()->toRoute('customer');
        }

        /**
         * @var $callsRepository \Application\Repositories\Calls
         */
        $callsRepository = $this->getEntityManager()->getRepository('Application\Entity\Calls');

        /**
         * @var $calls \ArrayObject
         */
        $calls = $callsRepository->getCallsArrayObjectById($id);

        if (!$calls->count()) {
            return $this->redirect()->toRoute('customer');
        }

        $form = new CallsForm();

        $form->bind($calls);

        $form->get('button')->setAttribute('value', 'Edit call');
        $form->get('action')->setAttribute('value', (int)$id);

        $request = $this->params()->fromPost('manageCall');

        if ($request) {
            $callInputFilter = new CallInputFilter();

            $response = $this->runEdit($form, $callsRepository, $callInputFilter, $request);

            $return = new JsonModel(
                $response
            );
        } else {

            $return = new ViewModel(
                [
                    'form' => $form,
                    'customerId' => (int)$id
                ]
            );
        }

        return $return;
    }
}