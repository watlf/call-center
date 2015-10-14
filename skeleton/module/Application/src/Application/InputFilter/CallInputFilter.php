<?php
/**
 * Created by PhpStorm.
 * User: <andrey.lyahovski@gmail.com>
 * Date: 6/27/15
 * Time: 9:04 PM
 */

namespace Application\InputFilter;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Factory as InputFactory;

class CallInputFilter implements InputFilterAwareInterface
{
    /**
     * @var InputFilter $inputFilter
     */
    protected $inputFilter;

    /**
     * Set input filter
     *
     * @param  InputFilterInterface $inputFilter
     *
     * @return InputFilterAwareInterface
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        // TODO: Implement setInputFilter() method.
    }

    /**
     * Retrieve input filter
     *
     * @return InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add(
                $factory->createInput(array(
                    'name'     => 'callId',
                    'required' => true,
                    'filters'  => array(
                        array('name' => 'Int'),
                    ),
                ))
            );

            $inputFilter->add(
                $factory->createInput(array(
                    'name'     => 'customerId',
                    'required' => true,
                    'filters'  => array(
                        array('name' => 'Int'),
                    ),
                ))
            );

            $inputFilter->add(
                $factory->createInput(array(
                    'name'     => 'subject',
                    'required' => true,
                    'filters'  => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        array(
                            'name'    => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min'      => 1,
                                'max'      => 255,
                            ),
                        ),
                    ),
                ))
            );

            $inputFilter->add(
                $factory->createInput(array(
                    'name'     => 'content',
                    'required' => true,
                    'filters'  => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        array(
                            'name'    => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min'      => 1,
                            ),
                        ),
                    ),
                ))
            );

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}