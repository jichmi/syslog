<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
    */
    public $xmlFile;

    public function rules()
    {
        return [
            [['xmlFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xml'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $path='../uploads/' . $this->xmlFile->baseName . '.' . $this->xmlFile->extension;
            //$this->xmlFile->saveAs('../uploads/' . $this->xmlFile->baseName . '.' . $this->xmlFile->extension);
            $this->xmlFile->saveAs($path);
            return $path;
        } else {
            return false;
        }
    }
}
?>
