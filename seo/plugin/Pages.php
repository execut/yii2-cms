<?php
/**
 */
namespace execut\cms\seo\plugin;
use execut\navigation\Page;
use execut\pages\models\FrontendPage;
use execut\pages\Plugin;
use execut\seo\models\Keyword;
use execut\cms\seo\models\KeywordVsPage;
use execut\seo\TextReplacer;
use yii\base\Module;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class Pages implements Plugin
{
    public $keywordReplacePattern = '/(?!<(([ab]|(h\d))[^>]*?>)|(img[^>]*?))(?<=[^a-z])({word})(?=[^a-z])(?!(([^<]*?<\/([ab]|(h\d)))>)|([^<]*?>))/i';
    public function getPageFieldsPlugins() {
        return [
            [
                'class' => \execut\seo\crudFields\Fields::class,
            ],
            [
                'class' => \execut\seo\crudFields\Keywords::class,
                'linkAttribute' => 'pages_page_id',
                'vsModelClass' => \execut\cms\seo\models\KeywordVsPage::class,
            ],
        ];
    }

    public function getCacheKeyQueries() {
        return [
            'keyword' => KeywordVsPage::find()
                ->select([
                    'key' => new Expression('COALESCE(updated,created)')
                ])
                ->orderBy(new Expression('COALESCE(updated,created) DESC'))
                ->limit(1)
        ];
    }

    public function initCurrentNavigationPage(Page $navigationPage, \execut\pages\models\Page $pageModel) {
        if (!$navigationPage->getKeywords()) {
            $this->setKeywords($navigationPage, $pageModel);
        }

        $allKeywords = Keyword::find()
            ->with(['pages' => function ($q) {
                $q->forLinks();
            }, 'filesFiles' => function ($q) {
                $q->withoutData();
            }])
            ->andWhere([
                'id' => KeywordVsPage::find()
                    ->select('seo_keyword_id')
                    ->andWhere([
                        'pages_page_id' => FrontendPage::find()->select('id')
                    ])
            ])
            ->orderBy('length(name) DESC')
            ->all();

        $this->_targetPages = [];
        $this->usedImages = [];
        $this->renderedKeywordsImages = [];

        foreach ($allKeywords as $keyword) {
            $this->replaceText($navigationPage, $pageModel, $keyword);
        }
    }

    protected $_targetPages = [];
    /**
     * @param Page $navigationPage
     * @param \execut\pages\models\Page $pageModel
     * @return mixed
     */
    protected function replaceText(Page $navigationPage, \execut\pages\models\Page $pageModel, $keywordModel)
    {
        if (empty($keywordModel->pages)) {
            return;
        }

        $textReplacer = new TextReplacer([
            'text' => $navigationPage->getText(),
            'keyword' => $keywordModel->name,
        ]);

        $keywordPageModel = false;
        if (!$this->keywordModelIsHas($pageModel, $keywordModel)) {
            $keywordPageModel = current($keywordModel->pages);
            $textReplacer->href = Url::to($keywordPageModel->getUrl());
            if (!empty($this->_targetPages[$keywordPageModel->id])) {
                return;
            }

            $textReplacer->title = $keywordPageModel->header;
            $textReplacer->limit = 1;
        }

        if ($img = $this->findBestImage($keywordModel->filesFiles, $pageModel, $keywordModel->name)) {
            $textReplacer->img = Url::to([
                '/files/frontend',
                'alias' => $img->alias,
                'extension' => $img->extension,
                'dataAttribute' => 'size_m',
            ]);
            $textReplacer->imgAlt = $img->alt;
            $textReplacer->limit = 1;
            $textReplacer->text = $textReplacer->replace();
            $textReplacer->img = null;
        }

        $navigationPage->setText($textReplacer->replace());
        if ($textReplacer->replacedCount > 0 && $keywordPageModel) {
            $this->_targetPages[$keywordPageModel->id] = true;
        }
    }

    protected $usedImages = [];
    protected $renderedKeywordsImages = [];
    protected function findBestImage($images, $pageModel, $keyword) {
        if (isset($this->renderedKeywordsImages[strtolower($keyword)])) {
            return;
        }

        $this->renderedKeywordsImages[strtolower($keyword)] = true;

        $cache = \yii::$app->cache;
        $bestImage = null;
        $bestCount = null;
        foreach ($images as $image) {
            if (in_array($image->id, $this->usedImages)) {
                continue;
            }

            $cacheKey = __CLASS__ . '_best_images_' . $image->id;
            $pagesIds = $cache->get($cacheKey);
            if (!is_array($pagesIds)) {
                $pagesIds = [];
            }

            $count = count($pagesIds);

            if (in_array($pageModel->id, $pagesIds)) {
                $count--;
            }

            if ($bestCount === null || $count < $bestCount) {
                $bestCount = $count;
                $bestImage = $image;
            }
        }

        if ($bestImage) {
            $cacheKey = __CLASS__ . '_best_images_' . $bestImage->id;
            $pagesIds = $cache->get($cacheKey);
            if (!is_array($pagesIds)) {
                $pagesIds = [];
            }
            $this->usedImages[] = $bestImage->id;
            if (!in_array($pageModel->id, $pagesIds)) {
                $pagesIds[] = $pageModel->id;
                $cache->set($cacheKey, $pagesIds);
            }

            return $bestImage;
        }
    }

    /**
     * @param Page $navigationPage
     * @param \execut\pages\models\Page $pageModel
     */
    protected function setKeywords(Page $navigationPage, \execut\pages\models\Page $pageModel): void
    {
        $keywords = $pageModel->seoKeywords;
        $result = [];
        foreach ($keywords as $keyword) {
            $result[] = $keyword->name;
        }
        $navigationPage->setKeywords(implode(', ', $keywords));
    }

    /**
     * @param \execut\pages\models\Page $pageModel
     * @param $keywordModel
     */
    protected function keywordModelIsHas(\execut\pages\models\Page $pageModel, $keywordModel)
    {
        $isHas = false;
        foreach ($keywordModel->vsPages as $vsPage) {
            if ($vsPage->pages_page_id === $pageModel->id) {
                $isHas = true;
                break;
            }
        }

        return $isHas;
    }

    public function applyCurrentPageScopes(ActiveQuery $q)
    {
        return $q;
    }
}
