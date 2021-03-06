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



class MassPublishTime extends MassPublish {

    public $type = 'time';

    public function getPackages () {
        return array_merge (parent::getPackages (), array (
            'MassPublishTime' => array(
                'baseUrl' => Yii::app()->request->baseUrl,
                'js' => array(
                    'js/X2GridView/MassPublishTime.js',
                ),
                'depends' => array ('MassPublish'),
            ),
        ));
    }

    /**
     * @return string label to display in the dropdown list
     */
    public function getLabel () {
        if (!isset ($this->_label)) {
            $this->_label = Yii::t('app', 'Log time');
        }
        return $this->_label;
    }


    /**
     * Renders the mass action dialog, if applicable
     * @param string $gridId id of grid view
     */
    public function renderDialog ($gridId, $modelName) {
        echo "
            <div class='mass-action-dialog' id='".$this->getDialogId ($gridId)."'
             style='display: none;'>
                <span>".
                    Yii::t('app', 'Log time on the selected records:')."
                </span>".self::getActionForm ()."
            </div>";
    }

    protected function getMessages () {
        return array (
            'failed' => function ($model) { 
                return array (
                    'message' => Yii::t(
                        'app', 'Failed to log time on to {record}', 
                        array ('{record}' => $model->link)),
                    'encode' => false
                );
            },
            'saved' => function ($saved) {
                return Yii::t(
                    'app', 'Time logged on {n} record|Time logged on {n} records',
                    array ($saved));
            },
            'unauthorized' => function ($unauthorized) {
                return Yii::t(
                    'app', 'You were not authorized to log time on {n} record|You were not authorized to log time on {n} records'
                    , array($unauthorized));
            },
        );
    }

}

?>
