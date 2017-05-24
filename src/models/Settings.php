<?php
/**
 * Svg plugin for Craft CMS 3.x
 *
 * Convert SVG Images
 *
 * @link      http://www.fractorr.com
 * @copyright Copyright (c) 2017 Trevor Orr
 */

namespace fractorr\svg\models;

use fractorr\svg\Svg;

use Craft;
use craft\base\Model;

use craft\base\Section;
use craft\services\Sections;
use craft\events\SectionEvent;

/**
 * Settings Model
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    Trevor Orr
 * @package   Svg
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * Some model attribute
     *
     * @var string
     */
    
    public $pathFiles = '';
    public $entryTypeHandle = '';
	
    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * More info: http://www.yiiframework.com/doc-2.0/guide-input-validation.html
     *
     * @return array
     */
    public function rules()
    {
       return [
            ['entryTypeHandle', 'string'],
            ['entryTypeHandle', 'default', 'value' => 'Name'],
        ];
    }

	
    public function getSections()
    {
    	$ret = array();
    	$secs = Craft::$app->sections->getAllSections();
    	
		foreach($secs as $sec) {
			array_push($ret, ['label' => $sec['name'], 'value' => $sec['handle']]);
		}
		
		return $ret;
    }
    
}
