<?php
/**
 */

namespace execut\cms\seo\models;


use yii\db\ActiveRecord;

class KeywordVsFile extends ActiveRecord
{
    public static function tableName()
    {
        return 'seo_keywords_vs_files_files';
    }

    public function rules()
    {
        return [
            [['files_file_id', 'seo_keyword_id'], 'safe']
        ];
    }
}