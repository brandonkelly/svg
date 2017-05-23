<?php
/**
 * Svg plugin for Craft CMS 3.x
 *
 * Convert SVG Images
 *
 * @link      http://www.fractorr.com
 * @copyright Copyright (c) 2017 Trevor Orr
 */

namespace fractorr\svg;

use fractorr\svg\services\SvgService as SvgServiceService;
use fractorr\svg\variables\SvgVariable;
use fractorr\svg\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;

use craft\base\Element;
use craft\services\Elements;
use craft\events\ElementEvent;


use yii\base\Event;

/**
 * Craft plugins are very much like little applications in and of themselves. We’ve made
 * it as simple as we can, but the training wheels are off. A little prior knowledge is
 * going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL,
 * as well as some semi-advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://craftcms.com/docs/plugins/introduction
 *
 * @author    Trevor Orr
 * @package   Svg
 * @since     1.0.0
 *
 * @property  SvgServiceService $svgService
 */
class Svg extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * Svg::$plugin
     *
     * @var Svg
     */
    public static $plugin;

    // Public Methods
    // =========================================================================

    /**
     * Set our $plugin static property to this class so that it can be accessed via
     * Svg::$plugin
     *
     * Called after the plugin class is instantiated; do any one-time initialization
     * here such as hooks and events.
     *
     * If you have a '/vendor/autoload.php' file, it will be loaded for you automatically;
     * you do not need to load it in your init() method.
     *
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        // Do something after we're installed
        Event::on(
            Plugins::className(),
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                    // We were just installed
                }
            }
        );

		Event::on(
			Elements::class, 
			Elements::EVENT_AFTER_SAVE_ELEMENT, 
            function (ElementEvent $event) {
            	/*
            	echo "<pre>";
            	echo "<textarea>";
            	echo $event->element->productSvg;
            	echo "</textarea>";
            	//print_r($event);
            	echo "</pre>";
            	die();
                */
                
                if (!empty($event->element->productSvg)) {
                	$settings = new Settings();
                	/*
                	echo "<pre>";
                	print_r($this->getSettings()->pathFull);
                	echo "</pre>";
                	die();
                	*/
                	$res = 150;
                	
                	// Generate PDF
	                $im = new \Imagick();
	                $im->setResolution($res, $res);
	                $im->readImageBlob($event->element->productSvg);
	                $im->trimImage(20000);
	                $im->setImageFormat("pdf");
	                $im->setPage($im->getImageWidth(), $im->getImageHeight(), 0, 0);
	                $im->setImageUnits(\Imagick::RESOLUTION_PIXELSPERINCH);
	                $raw_data = $im->getImageBlob();
	                $im->writeImage($this->getSettings()->pathPdf . '/' .  $event->element->slug .  '.pdf');
					$im->clear();
					$im->destroy();
                	
                	// Generate Full Size
	                $im = new \Imagick();
	                $im->setResolution($res, $res);
	                $im->readImageBlob($event->element->productSvg);
	                $im->setImageFormat("png");
	                $im->setImageUnits(\Imagick::RESOLUTION_PIXELSPERINCH);
	                $im->trimImage(20000);
	                $raw_data = $im->getImageBlob();
	                $im->writeImage($this->getSettings()->pathFull . '/' .  $event->element->slug .  '.png');
					$im->clear();
					$im->destroy();

                	// Generate PDP
	                $im = new \Imagick();
	                $im->setResolution($res, $res);
	                $im->readImageBlob($event->element->productSvg);
	                $im->setImageFormat("png");
	                $im->setImageUnits(\Imagick::RESOLUTION_PIXELSPERINCH);
	                $im->trimImage(20000);
	                $im->resizeImage(200, 0, \Imagick::FILTER_LANCZOS, 1);
	                $raw_data = $im->getImageBlob();
	                $im->writeImage($this->getSettings()->pathWall . '/' .  $event->element->slug .  '.png');
					$im->clear();
					$im->destroy();

                	// Generate PDP
	                $im = new \Imagick();
	                $im->setResolution($res, $res);
	                $im->readImageBlob($event->element->productSvg);
	                $im->setImageFormat("png");
	                $im->setImageUnits(\Imagick::RESOLUTION_PIXELSPERINCH);
	                $im->trimImage(20000);
	                $im->resizeImage(400, 0, \Imagick::FILTER_LANCZOS, 1);
	                $raw_data = $im->getImageBlob();
	                $im->writeImage($this->getSettings()->pathPdp . '/' .  $event->element->slug .  '.png');
					$im->clear();
					$im->destroy();

                	// Generate PDP
	                $im = new \Imagick();
	                $im->setResolution($res, $res);
	                $im->readImageBlob($event->element->productSvg);
	                $im->setImageFormat("png");
	                $im->setImageUnits(\Imagick::RESOLUTION_PIXELSPERINCH);
	                $im->trimImage(20000);
	                $im->resizeImage(100, 0, \Imagick::FILTER_LANCZOS, 1);
	                $raw_data = $im->getImageBlob();
	                $im->writeImage($this->getSettings()->pathCart . '/' .  $event->element->slug .  '.png');
					$im->clear();
					$im->destroy();
                }
            }
        );

/**
 * Logging in Craft involves using one of the following methods:
 *
 * Craft::trace(): record a message to trace how a piece of code runs. This is mainly for development use.
 * Craft::info(): record a message that conveys some useful information.
 * Craft::warning(): record a warning message that indicates something unexpected has happened.
 * Craft::error(): record a fatal error that should be investigated as soon as possible.
 *
 * Unless `devMode` is on, only Craft::warning() & Craft::error() will log to `craft/storage/logs/web.log`
 *
 * It's recommended that you pass in the magic constant `__METHOD__` as the second parameter, which sets
 * the category to the method (prefixed with the fully qualified class name) where the constant appears.
 *
 * To enable the Yii debug toolbar, go to your user account in the AdminCP and check the
 * [] Show the debug toolbar on the front end & [] Show the debug toolbar on the Control Panel
 *
 * http://www.yiiframework.com/doc-2.0/guide-runtime-logging.html
 */
        Craft::info(
            Craft::t(
                'svg',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    /**
     * Returns the component definition that should be registered on the
     * [[\craft\web\twig\variables\CraftVariable]] instance for this plugin’s handle.
     *
     * @return mixed|null The component definition to be registered.
     * It can be any of the formats supported by [[\yii\di\ServiceLocator::set()]].
     */
    public function defineTemplateComponent()
    {
        return SvgVariable::class;
    }

    // Protected Methods
    // =========================================================================

    /**
     * Creates and returns the model used to store the plugin’s settings.
     *
     * @return \craft\base\Model|null
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * Returns the rendered settings HTML, which will be inserted into the content
     * block on the settings page.
     *
     * @return string The rendered settings HTML
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'svg/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
