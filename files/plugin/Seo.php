<?php
/**
 */

namespace execut\cms\files\plugin;


use execut\files\models\File;
use execut\seo\Plugin;

class Seo implements Plugin
{
    public function getKeywordsModels()
    {
        return [
            File::class,
        ];
    }

    public function getFieldsModels()
    {
        return [];
    }

    public function getKeywordFieldsPlugins() {
        return [
            [
                'class' => \execut\files\crudFields\FilesPlugin::class,
                'linkAttribute' => 'seo_keyword_id',
                'vsModelClass' => \execut\cms\seo\models\KeywordVsFile::class,
            ],
        ];
    }
}