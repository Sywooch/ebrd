<?php

namespace frontend\modules\forms\models;

use frontend\modules\translation\models\SourceMessage;
use Yii;

/**
 * This is the model class for table "form".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $description
 * @property string $answer
 * @property string $mail_to
 * @property string $fields
 * @property string $rules
 * @property string $submit
 * @property string $extra_actions
 * @property string $action
 * @property string $method
 * @property string $class
 * @property string $form_id
 * @property string $script_on_submit
 */
class Form extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fields'], 'required'],
            [['description', 'answer', 'mail_to', 'fields', 'rules', 'submit', 'extra_actions', 'script_on_submit'], 'string'],
            [['name', 'class', 'form_id', 'hubspot_form_guid'], 'string', 'max' => 45],
            [['title', 'action', 'attach_file'], 'string', 'max' => 255],
            [['method'], 'string', 'max' => 4],
            [['form_id'], 'unique'],
			[['attach_file','hubspot_form_guid'],'trim'],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('forms', 'ID'),
            'name' => Yii::t('forms', 'Name'),
            'title' => Yii::t('forms', 'Title'),
            'description' => Yii::t('forms', 'Description'),
            'answer' => Yii::t('forms', 'Answer'),
            'mail_to' => Yii::t('forms', 'Mail To'),
            'fields' => Yii::t('forms', 'Fields'),
            'rules' => Yii::t('forms', 'Rules'),
            'submit' => Yii::t('forms', 'Submit'),
            'extra_actions' => Yii::t('forms', 'Extra Actions'),
            'action' => Yii::t('forms', 'Action'),
            'method' => Yii::t('forms', 'Method'),
            'class' => Yii::t('forms', 'Class'),
            'form_id' => Yii::t('forms', 'Form ID'),
			'hubspot_form_guid' => Yii::t('forms', 'Hubspot Form Guid'),
			'attach_file' => Yii::t('forms', 'Attach File'),
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $fields = json_decode($this->fields);
        foreach ($fields as $field) {
            $checker = $this->checkExistence($field->label);
            if (empty($checker)) {
                $const = new SourceMessage();
                $const->category = 'forms';
                $const->message = $field->label;
                $const->save();
            }
        }

        return true;
    }

    public function checkExistence($constant)
    {
        $messageModel = new SourceMessage();
        return $messageModel->find()
            ->where(['category' => 'forms'])
            ->andWhere(['message' => $constant])
            ->one();
    }
}
