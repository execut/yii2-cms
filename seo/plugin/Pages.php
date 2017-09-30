<?php
/**
 */
namespace execut\cms\seo\plugin;
use execut\navigation\Page;
use execut\pages\models\FrontendPage;
use execut\pages\Plugin;
use execut\seo\models\Keyword;
use execut\cms\seo\models\KeywordVsPage;
use yii\base\Module;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

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
            if ($this->keywordModelIsHas($pageModel, $keyword)) {
                $this->replaceText($navigationPage, $pageModel, $keyword);
            } else {
                $this->addLinks($navigationPage, $pageModel, $keyword);
            }
        }
    }

    protected $_targetPages = [];
    protected function addLinks(Page $navigationPage, \execut\pages\models\Page $pageModel, $keywordModel) {
        $text = $navigationPage->getText();
        $images = $keywordModel->filesFiles;
        $callback = function ($keywordString) use ($keywordModel, $images, $pageModel) {
            if (!empty($keywordModel->pages)) {
                /**
                 * @var \execut\pages\models\Page $page
                 */
                $page = $keywordModel->pages[0];
                $pageId = $page->id;
                if (!empty($this->_targetPages[$pageId])) {
                    return $keywordString;
                }

                $this->_targetPages[$pageId] = true;
                $img = $this->renderBestImage($images, $pageModel, $keywordString, false);
                if ($img) {
                    $img = Html::a($img, $page->getUrl(), [
                        'title' => $page->header
                    ]);
                }

                return Html::a($keywordString, $page->getUrl(), [
                    'title' => $page->header,
                ]) . $img;
            } else {
                return $keywordString;
            }
        };
        $text = $this->replaceKeyword($keywordModel->name, $callback, $text);
        $navigationPage->setText($text);
    }

    /**
     * @param Page $navigationPage
     * @param \execut\pages\models\Page $pageModel
     * @return mixed
     */
    protected function replaceText(Page $navigationPage, \execut\pages\models\Page $pageModel, $keywordModel)
    {
        $text = $navigationPage->getText();
        $images = $keywordModel->filesFiles;
        $renderedKeywordsImages = [];
        $callback = function ($keyword) use ($images, $pageModel, &$renderedKeywordsImages) {
            $img = $this->renderBestImage($images, $pageModel, $keyword);

            return '<b>' . $keyword . '</b>' . $img;
        };

        $text = $this->replaceKeyword($keywordModel->name, $callback, $text);

        $navigationPage->setText($text);
    }

    protected $usedImages = [];
    protected $renderedKeywordsImages = [];
    protected function renderBestImage($images, $pageModel, $keyword, $isRenderLink = true) {
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

            $url = [
                '/files/frontend',
                'alias' => $bestImage->alias,
                'extension' => $bestImage->extension,
            ];

            $image = Html::img([
                '/images/frontend',
                'alias' => $bestImage->alias,
                'extension' => $bestImage->extension,
                'dataAttribute' => 'size_m',
            ], [
                'alt' => $bestImage->alt,
            ]);
            if ($isRenderLink) {
                $image = Html::a($image, $url, [
                    'title' => $bestImage->title,
                ]);
            }

            return $image;
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
     * @param $keywords
     * @param $callback
     * @param $text
     * @return mixed
     */
    protected function replaceKeyword($keyword, $callback, $text)
    {
        $pattern = $this->keywordReplacePattern;
        $pattern = str_replace('{word}', preg_quote($keyword), $pattern);
        $text = preg_replace_callback($pattern, function ($matches) use ($callback) {
            return $callback($matches[0]);
        }, $text);
        return $text;
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
