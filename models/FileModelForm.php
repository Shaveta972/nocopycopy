<?php
namespace app\models;

use yii\base\Model;

/**
 * Password reset form
 */
class FileModelForm extends Model
{

    public $file;
    public $process_type;
    public $subject_code;
    public function rules()
    {
        return [
            [
                [
                    'file'
                ],
                'file',
                'skipOnEmpty' => false,
                'extensions' => 'doc, docx, txt, pdf, pptx, ppt, xls, csv'
            ],
            [['subject_code'],'safe' ],
            [['process_type'],'string' ]
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $fileName = $this->file->baseName . '_' . time() . '.' . $this->file->extension;
            $path = \Yii::getAlias('@uploads').'/'. $fileName;
            if ($this->file->saveAs($path)) {
                return $fileName;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}