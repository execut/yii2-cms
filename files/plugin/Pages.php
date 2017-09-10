<?php
/**
 */
namespace execut\cms\files\plugin;
use execut\navigation\Page;
use execut\pages\models\FrontendPage;
use execut\pages\Plugin;
use execut\seo\models\Keyword;
use execut\seo\models\KeywordVsPage;
use yii\base\Module;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class Pages implements Plugin
{
    public $keywordReplacePattern = '/(?!<([ab]|(h\d))[^>]*?>)(?<=[^a-z])({word})(?=[^a-z])(?!([^<]*?<\/([ab]|(h\d)))>)/i';
    public function getPageFieldsPlugins() {
        return [
            [
                'class' => \execut\files\crudFields\Plugin::class,
            ],
        ];
    }

    public function getCacheKeyQueries() {
        return [];
    }

    public function initCurrentNavigationPage(Page $navigationPage, \execut\pages\models\Page $pageModel) {
        $this->replaceText($navigationPage, $pageModel);
    }


    /**
     * @param Page $navigationPage
     * @param \execut\pages\models\Page $pageModel
     * @return mixed
     */
    protected function replaceText(Page $navigationPage, \execut\pages\models\Page $pageModel)
    {
        $text = $navigationPage->getText();
        if ($filesFile = $pageModel->filesFile) {
            $url = [
                '/files/frontend',
                'id' => $filesFile->id,
                'extension' => $filesFile->extension,
            ];

            $image = Html::a(Html::img([
                '/images/frontend',
                'id' => $filesFile->id,
                'extension' => $filesFile->extension,
                'dataAttribute' => 'size_m',
            ], [
                'alt' => $filesFile->alt,
            ]), $url, [
                'title' => $filesFile->title,
            ]);
            $text = $image . $text;
        }

        $navigationPage->setText($text);
    }
}