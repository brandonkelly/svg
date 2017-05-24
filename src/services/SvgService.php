<?php
/**
 * Svg plugin for Craft CMS 3.x
 *
 * Convert SVG Images
 *
 * @link      http://www.fractorr.com
 * @copyright Copyright (c) 2017 Trevor Orr
 */

namespace fractorr\svg\services;

use fractorr\svg\Svg;

use Craft;
use craft\base\Component;

/**
 * SvgService Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Trevor Orr
 * @package   Svg
 * @since     1.0.0
 */
class SvgService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * This function can literally be anything you want, and you can have as many service
     * functions as you want
     *
     * From any other plugin file, call it like this:
     *
     *     Svg::$plugin->svgService->exampleService()
     *
     * @return mixed
     */
    public function exampleService()
    {
        $result = 'something';

        if (Svg::$plugin->getSettings()->pathFiles) {
        }

        if (Svg::$plugin->getSettings()->entryTypeHandle) {
        }

        return $result;
    }
}
