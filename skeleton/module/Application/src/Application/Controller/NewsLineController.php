<?php
/**
 * Created by PhpStorm.
 * User: <andrey.lyahovski@gmail.com>
 * Date: 6/28/15
 * Time: 2:32 PM
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Parser\Xml\ParserXML;
use Application\Helper\DateHelper;

class NewsLineController extends AbstractActionController
{
    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        $result = [];
        $url = 'http://feeds.skynews.com/feeds/rss/technology.xml';
       // $url = 'http://feeds.skynews.com/feeds/rss/strange.xml';

        try {
            $xml = new ParserXML($url);

            $data = $xml->getAssocResult();

            $result['newsline'] = $this->prepareNewsData($data);
        } catch (\InvalidArgumentException $exc) {
            $result['error'] = $exc->getMessage();
        }

        return new ViewModel(
            $result
        );
    }

    /**
     * @param array $newsline
     *
     * @return array
     */
    private function prepareNewsData(array $newsline)
    {
        foreach ($newsline as $num => $article) {
            if (isset($newsline[$num][ParserXML::FIELD_DATE_PUBLICATION])) {
                $newsline[$num][ParserXML::FIELD_DATE_PUBLICATION] = DateHelper::dateFormat(
                    $newsline[$num][ParserXML::FIELD_DATE_PUBLICATION]
                );
            }
        }

        return $newsline;
    }
}