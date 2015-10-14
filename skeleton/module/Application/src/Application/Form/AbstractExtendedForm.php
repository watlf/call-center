<?php
/**
 * Created by PhpStorm.
 * User: andrey.ly
 * Date: 6/29/15
 * Time: 3:55 AM
 */

namespace Application\Form;

use Zend\Form\Form as ZendForm;

class AbstractExtendedForm extends ZendForm
{
    /**
     * @return string
     */
    public function getMessages()
    {
        $result = '';

        foreach (parent::getMessages() as $fieldName => $error) {
            if (is_array($error)) {
                $result .= sprintf('Error in field %s: %s.', $fieldName, implode(' ' ,$error));
            }
        }

        return $result;
    }

}