<?php
/***********************************************************************************
 * X2CRM is a customer relationship management program developed by
 * X2Engine, Inc. Copyright (C) 2011-2016 X2Engine Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY X2ENGINE, X2ENGINE DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact X2Engine, Inc. P.O. Box 66752, Scotts Valley,
 * California 95067, USA. on our website at www.x2crm.com, or at our
 * email address: contact@x2engine.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * X2Engine" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by X2Engine".
 **********************************************************************************/

abstract class TwoColumnSortableWidgetManager extends SortableWidgetManager {

    public $layoutManager;

    public $widgetType = '';

    public $columnCount = 2;

    /**
     * @var string $JSClass
     */
    public $JSClass = 'TwoColumnSortableWidgetManager'; 

    public $connectedContainerClass = 'connected-sortable-widget-container';

    public function getWidgetLayoutName () {
        return $this->widgetType.'WidgetLayout';
    }

    /**
     * Magic getter. Returns this widget's packages. 
     */
    public function getPackages () {
        if (!isset ($this->_packages)) {
            $this->_packages = array_merge (parent::getPackages (), array (
                'TwoColumnSortableWidgetManagerJS' => array(
                    'baseUrl' => Yii::app()->request->baseUrl,
                    'js' => array(
				        'js/sortableWidgets/TwoColumnSortableWidgetManager.js',
                    ),
                    'depends' => array ('SortableWidgetManagerJS')
                ),
            ));
        }
        return $this->_packages;
    }

    public function getJSClassParams () {
        if (!isset ($this->_JSClassParams)) {
            $this->_JSClassParams = array_merge (parent::getJSClassParams (), array (
                'connectedContainerSelector' => '.'.$this->connectedContainerClass,
            ));
        }
        return $this->_JSClassParams;
    }

	public function displayWidgets ($containerNumber){
        $widgetLayoutName = $this->getWidgetLayoutName ();
		$layout = $this->model->$widgetLayoutName;

		foreach ($layout as $widgetClass => $settings) {
		    if ($settings['containerNumber'] == $containerNumber) {
		        SortableWidget::instantiateWidget ($widgetClass, $this->model);
		    }
		}
	}

	public function init() {
        if (!isset ($this->layoutManager)) {
            $this->layoutManager = new RecordViewLayoutManager (65);
        }

        $this->registerPackages ();
        $this->instantiateJSClass ();

		parent::init ();
	}

    public function run () {
        if ($this->columnCount === 2) {
            $this->render ('_twoColumnSortableWidgetLayout');
        } else {
            $this->render ('_singleColumnSortableWidgetLayout');
        }
    }

}

?>
