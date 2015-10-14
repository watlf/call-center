<?php
/**
 * Created by PhpStorm.
 * User: <andrey.lyahovski@gmail.com>
 * Date: 6/28/15
 * Time: 4:36 PM
 */

namespace Application\Parser\Xml;

class ParserXML extends \XMLReader
{
    /**
     * @var array
     */
    private $assocResult;

    /**
     * @var array
     */
    private $needFields = array(
        'title',
        'link',
        'description',
        'pubDate',
    );

    const FIELD_DATE_PUBLICATION = 'pubDate';
    
    const KEY_VALUE = 'value';
    const KEY_NAME  = 'name';
    const KEY_ATR   = 'attribute';
    const KEY_ITEM  = 'item';

    /**
     * @param string $url
     */
    public function __construct($url)
    {
        if ($this->open($url, 'UTF-8')) {
            $this->assocResult = $this->parseXmlToAssoc();
            $this->close();
        } else {
            throw new \InvalidArgumentException(
                sprintf('Unable to open the link: %s', $url)
            );
        }
    }

    /**
     * @return array
     */
    public function getAssocResult()
    {
        $assocResult = current($this->assocResult);

        return $this->extract($assocResult);
    }

    /**
     * @param array $assocResult
     *
     * @return array
     */
    public function extract(array $assocResult)
    {
        $result = [];

        foreach ($assocResult as $key => $element) {
            if (isset($element[self::KEY_NAME], $element[self::KEY_VALUE]) &&
                $element[self::KEY_NAME] === self::KEY_ITEM
            ) {
                foreach ($element[self::KEY_VALUE] as $value) {
                    if (in_array($value[self::KEY_NAME], $this->needFields)) {
                        $result[$key][$value[self::KEY_NAME]] = $value[self::KEY_VALUE];
                    }
                }
            } else if(is_array($element)) {
                $result = $this->extract($element);
            }
        }
        return $result;
    }

    /**
     * @return array
     */
    private function parseXmlToAssoc()
    {
        $result = [];
        $n = 0;
        while($this->read()){
            if($this->nodeType == \XMLReader::END_ELEMENT) {
                break;
            }

            if($this->nodeType == \XMLReader::ELEMENT && !$this->isEmptyElement){
                $result[$n][self::KEY_NAME] = $this->name;
                if($this->hasAttributes) {
                    while($this->moveToNextAttribute()) {
                        $result[$n][self::KEY_ATR][$this->name] = $this->value;
                    }
                }
                $result[$n][self::KEY_VALUE] = $this->parseXmlToAssoc($this);
                $n++;
            } else if($this->isEmptyElement){
                $result[$n][self::KEY_NAME] = $this->name;
                if($this->hasAttributes) {
                    while($this->moveToNextAttribute()) {
                        $result[$n][self::KEY_ATR][$this->name] = $this->value;
                    }
                }
                $result[$n][self::KEY_VALUE] = "";
                $n++;
            } else if($this->nodeType == \XMLReader::TEXT) {
                $result = $this->value;
            }
        }
        return $result;
    }
}