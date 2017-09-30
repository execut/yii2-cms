<?php
/**
 */

namespace execut\cms\seo\plugin;


use execut\files\Plugin;

class Files implements Plugin
{
    public function getFileFieldsPlugins()
    {
        return [
            [
                'class' => \execut\seo\crudFields\Keywords::class,
                'linkAttribute' => 'files_file_id',
                'vsModelClass' => \execut\cms\seo\models\KeywordVsFile::class,
            ],
        ];
    }

    public function getAttachedModels() {
        return [];
    }

    public function getDataColumns()
    {
        return [];
    }
}