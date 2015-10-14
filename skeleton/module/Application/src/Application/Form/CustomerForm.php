<?php
/**
 * Created by PhpStorm.
 * User: <andrey.lyahovski@gmail.com>
 * Date: 6/26/15
 * Time: 3:39 PM
 */

namespace Application\Form;

class CustomerForm  extends AbstractExtendedForm
{
    const NAME_FORM = 'customer';

    /**
     * @param null $name
     */
    public function __construct($name = null)
    {
        parent::__construct(self::NAME_FORM);

        $this->init();
    }

    /**
     * @return void
     */
    public function init()
    {
        $this->add(
            array(
                'name' => 'id',
                'attributes' => array(
                    'type'   => 'hidden',
                    'id'     => 'inputId',
                )
            )
        );

        $this->add(
            array(
                'name' => 'action',
                'attributes' => array(
                    'type'  => 'hidden',
                    'id'    => 'inputAction',
                )
            )
        );

        $this->add(
            array(
                'name' => 'firstName',
                'attributes' => array(
                    'type'  => 'text',
                    'class' => 'form-control',
                    'id'    => 'inputFirstName',
                ),
                'options' => array(
                    'label' => 'First Name',
                )
            )
        );

        $this->add(
            array(
                'name' => 'lastName',
                'attributes' => array(
                    'type'  => 'text',
                    'class' => 'form-control',
                    'id'    => 'inputLastName',
                ),
                'options' => array(
                    'label' => 'Last Name',
                )
            )
        );

        $this->add(
            array(
                'name' => 'phone',
                'attributes' => array(
                    'type'  => 'text',
                    'class' => 'form-control',
                    'id'    => 'inputPhone',
                ),
                'options' => array(
                    'label' => 'Phone number',
                )
            )
        );

        $this->add(
            array(
                'name' => 'address',
                'attributes' => array(
                    'type'  => 'text',
                    'class' => 'form-control',
                    'id'    => 'inputAddress',
                ),
                'options' => array(
                    'label' => 'Address',
                )
            )
        );

        $this->add(
            array(
                'name' => 'status',
                'attributes' => array(
                    'type'  => 'text',
                    'class' => 'form-control',
                    'id'    => 'inputStatus',
                ),
                'options' => array(
                    'label' => 'Status',
                )
            )
        );

        $this->add(
            array(
                'name' => 'button',
                'attributes' => array(
                    'type'  => 'button',
                    'class' => 'submitCustomer  btn btn-warning',
                )
            )
        );
    }
}