<?php
/**
 */

namespace execut\cms\seo\models;


use yii\db\ActiveRecord;

class KeywordVsPage extends ActiveRecord
{
    public static function tableName()
    {
        return 'seo_keywords_vs_pages_pages';
    }

    public function rules()
    {
        return [
            [['pages_page_id', 'seo_keyword_id'], 'safe']
        ];
    }
}