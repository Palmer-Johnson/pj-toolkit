<?php
/**
 * PJ Toolkit plugin for Craft CMS 3.x
 *
 * Tools shared across PJ Power's Craft properties
 *
 * @link      https://astuteo.com
 * @copyright Copyright (c) 2020 Astuteo
 */

namespace palmerjohnson\pjtoolkit\services;

use GuzzleHttp\Exception\ClientException;
use palmerjohnson\pjtoolkit\PjToolkit;

use Craft;
use craft\base\Component;
use yii\base\Event;
use GuzzleHttp\Client;
use Ramsey\Uuid\Uuid;


/**
 * @author    Astuteo
 * @package   PjToolkit
 * @since     1.0.0
 */
class Ga extends Component
{
    // Public Methods
    // =========================================================================

    /**
 *     PjToolkit::$plugin->ga->submitted()
     * @param $event
     * @return mixed
     */
    public function submitted($event)
    {
        if(PjToolkit::$plugin->getSettings()->excludeSpam && $event->getSubmission()->isSpam){
            return false;
        }
        if (PjToolkit::$plugin->getSettings()->gaTrackingId) {
            $trackingid = PjToolkit::$plugin->getSettings()->gaTrackingId;
            $action = PjToolkit::$plugin->getSettings()->successAction;
            $form = $event->getForm();
            $category = $form->getName();
            $label = Craft::$app->request->getFullPath();
            $uuid4 = Uuid::uuid4();
            $client = new Client();
            try {
                $client->post('https://www.google-analytics.com/collect', [
                    'headers' => [
                        'User-Agent' => Craft::$app->request->getUserAgent(),
                    ],
                    'query' => [
                        'v' => 1,
                        'tid' => $trackingid,   // Tracking ID from GA
                        'cid' => $uuid4->toString(),
                        't'   => 'event',
                        'ec'  =>  $category,    // Event Category
                        'ea'  =>  $action,      // Event Action
                        'el'  =>  $label,       // Event Label
                    ]
                ]);}
            catch (ClientException $e){
                Craft::info($e->getMessage(),'pjTool');
            }

            return true;
        }
    }
}
