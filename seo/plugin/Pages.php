<?php
/**
 */
namespace execut\cms\seo\plugin;
use execut\navigation\Page;
use execut\pages\models\FrontendPage;
use execut\pages\Plugin;
use execut\seo\models\Keyword;
use execut\seo\models\KeywordVsPage;
use yii\base\Module;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Pages implements Plugin
{
    public $keywordReplacePattern = '/(?!<([ab]|(h\d))[^>]*?>)(?<=[^a-z])({word})(?=[^a-z])(?!([^<]*?<\/([ab]|(h\d)))>)/i';
    public function getPageFieldsPlugins() {
        return [
            [
                'class' => \execut\seo\crudFields\Fields::class,
            ],
            [
                'class' => \execut\seo\crudFields\Keywords::class,
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
            ->with('pages')
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
        $callback = function ($keywordString) use ($keywordModel) {
            if (!empty($keywordModel->pages)) {
                $page = $keywordModel->pages[0];
                $pageId = $page->id;
                if (!empty($this->_targetPages[$pageId])) {
                    return $keywordString;
                }

                $this->_targetPages[$pageId] = true;

                return Html::a($keywordString, $page->getUrl(), [
                    'title' => $page->header,
                ]);
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
        $callback = function ($keyword) {
            return '<b>' . $keyword . '</b>';
        };

        $text = $this->replaceKeyword($keywordModel->name, $callback, $text);

        $navigationPage->setText($text);
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
        foreach ($pageModel->seoKeywords as $keyword) {
            if ($keywordModel->id === $keyword->id) {
                $isHas = true;
                break;
            }
        }

        return $isHas;
    }
}
