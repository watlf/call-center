<?php
/**
 * Created by PhpStorm.
 * User: <andrey.lyahovski@gmail.com>
 * Date: 6/27/15
 * Time: 9:28 PM
 */

namespace Application\Controller;

use Doctrine\ORM\EntityRepository;
use Zend\Form\Form as ZendForm;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\Mvc\Controller\AbstractActionController;

abstract class AbstractExtendedController extends AbstractActionController
{
    const MESSAGE_SUCCESSFUL = 'The %s operation completed successfully.';
    const MESSAGE_FAILED = 'Something went wrong in %s operation, try again.';

    const ACTION_ADD  = 'add';
    const ACTION_EDIT = 'edit';

    /**
     * @param ZendForm $form
     * @param EntityRepository $repository
     * @param InputFilterAwareInterface $filter
     * @param array $request
     *
     * @return array
     */
    protected function runEdit(
        ZendForm $form,
        EntityRepository $repository,
        InputFilterAwareInterface $filter,
        array $request
    ) {
        $form->setInputFilter(
            $filter->getInputFilter()
        );

        $form->setData($request);

        $response = [];

        if ($form->isValid()) {
            $isUpdated = $repository->editRow(
                (array)$form->getData()
            );

            if (!$isUpdated) {
                $response['error'] = sprintf(self::MESSAGE_FAILED, self::ACTION_EDIT);
            } else {
                $response['status'] = sprintf(self::MESSAGE_SUCCESSFUL, self::ACTION_EDIT);
            }

        } else {
            $response['error'] = $form->getMessages();
        }

        return $response;
    }

    /**
     * @param ZendForm $form
     * @param EntityRepository $repository
     * @param InputFilterAwareInterface $filter
     * @param array $request
     *
     * @return array
     */
    protected function runAdd(
        ZendForm $form,
        EntityRepository $repository,
        InputFilterAwareInterface $filter,
        array $request
    ) {
        $form->setInputFilter(
            $filter->getInputFilter()
        );

        $form->setData($request);

        $response = [];

        if ($form->isValid()) {
            $isAdded = $repository->addRow(
                (array)$form->getData()
            );

            if (!$isAdded) {
                $response['error'] = sprintf(self::MESSAGE_FAILED, self::ACTION_ADD);
            } else {
                $response['status'] = sprintf(self::MESSAGE_SUCCESSFUL, self::ACTION_ADD);
            }

        } else {
            $response['error'] = $form->getMessages();
        }

        return $response;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        return $em;
    }
}