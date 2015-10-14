<?php
/**
 * Created by PhpStorm.
 * User: <andrey.lyahovski@gmail.com>
 * Date: 6/27/15
 * Time: 6:58 PM
 */

namespace Application\Form;

class CallsForm extends AbstractExtendedForm
{
    const NAME_FORM = 'call';

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
                'name' => 'callId',
                'attributes' => array(
                    'type' => 'hidden',
                    'id' => 'inputCallId',
                )
            )
        );

        $this->add(
            array(
                'name' => 'customerId',
                'attributes' => array(
                    'type' => 'hidden',
                    'id' => 'inputCustomerId',
                )
            )
        );

        $this->add(
            array(
                'name' => 'action',
                'attributes' => array(
                    'type' => 'hidden',
                    'id' => 'inputAction',
                )
            )
        );

        $this->add(
            array(
                'name' => 'subject',
                'attributes' => array(
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => 'inputSubject',
                ),
                'options' => array(
                    'label' => 'Subject',
                )
            )
        );

        $this->add(
            array(
                'name' => 'content',
                'attributes' => array(
                    'type' => 'textarea',
                    'class' => 'form-control',
                    'id' => 'inputContent',
                ),
                'options' => array(
                    'label' => 'Content',
                )
            )
        );

        $this->add(
            array(
                'name' => 'button',
                'attributes' => array(
                    'type' => 'button',
                    'class' => 'submitCall btn btn-warning',
                )
            )
        );
    }
}