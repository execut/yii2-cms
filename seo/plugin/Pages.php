<?php
/**
 */
/**We often get asked if there is a good place to buy Clenbuterol Clen. on the internet, and certainly this is an important issue, as there are many places that are just trying to rip you off.*/
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

        $this->replaceText($navigationPage, $pageModel);
        $this->addLinks($navigationPage, $pageModel);
    }

    protected function addLinks(Page $navigationPage, \execut\pages\models\Page $pageModel) {
        $allKeywords = Keyword::find()
            ->with('pages')
            ->andWhere([
                'id' => KeywordVsPage::find()
                    ->select('seo_keyword_id')
                    ->andWhere('pages_page_id<>' . $pageModel->id)
                    ->andWhere([
                        'pages_page_id' => FrontendPage::find()->select('id')
                    ])
            ])->all();
        $allKeywords = ArrayHelper::map($allKeywords, function ($row) {
            return $row->name;
        }, function ($row) {
            return $row;
        });

        $text = $navigationPage->getText();
        $callback = function ($keyword) use ($allKeywords) {
            $keywordModel = $allKeywords[mb_strtolower($keyword)];
            if (!empty($keywordModel->pages)) {
                $page = $keywordModel->pages[0];
                return Html::a($keyword, $page->getUrl(), [
                    'title' => $page->header,
                ]);
            } else {
                return $keyword;
            }
        };
        $text = $this->replaceKeywords($allKeywords, $callback, $text);
        $navigationPage->setText($text);
    }

    /**
     * @param Page $navigationPage
     * @param \execut\pages\models\Page $pageModel
     * @return mixed
     */
    protected function replaceText(Page $navigationPage, \execut\pages\models\Page $pageModel)
    {
        $text = $navigationPage->getText();
        $keywords = $pageModel->seoKeywords;
        $callback = function ($keyword) {
            return '<b>' . $keyword . '</b>';
        };

        $text = $this->replaceKeywords($keywords, $callback, $text);

        $navigationPage->setText($text);
        return $keywords;
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
    protected function replaceKeywords($keywords, $callback, $text)
    {
        $result = [];
        foreach ($keywords as $keyword) {
            $result[] = $keyword->name;
        }

        uasort($result, function ($a, $b) {
            return mb_strlen($b) > mb_strlen($a);
        });

        foreach ($result as $keyword) {
            $pattern = $this->keywordReplacePattern;
            $pattern = str_replace('{word}', preg_quote($keyword), $pattern);
            $text = preg_replace_callback($pattern, function ($matches) use ($callback) {
                return $callback($matches[0]);
            }, $text);
        }
        return $text;
    }
}