<?php
/**
 * PJ Toolkit plugin for Craft CMS 3.x
 *
 * Tools shared across PJ Power's Craft properties
 *
 * @link      https://astuteo.com
 * @copyright Copyright (c) 2020 Astuteo
 */

namespace palmerjohnson\pjtoolkit\models;

use palmerjohnson\pjtoolkit\PjToolkit;

use Craft;
use craft\base\Model;

/**
 * PjToolkit Settings Model
 *
 * @author    Astuteo
 * @package   PjToolkit
 * @since     1.0.0
 */
class Settings extends Model
{
    public $gaTrackingId = '';
    public $successAction = 'Completed';
    public $excludeSpam = true;

    public function rules()
    {
        return [
            ['$gaTrackingId', 'string'],
            ['$gaTrackingId', 'default', 'value' => ''],
        ];
    }
}
