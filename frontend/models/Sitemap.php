<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\modules\blog\models\BlogCategory;
use frontend\modules\blog\models\BlogPost;
use yii\helpers\Url;
use frontend\modules\blog\models\BlogMapEntityLang;
use frontend\models\HdbkLanguage;

class Sitemap extends Model
{

    public function sitemapGenerator()
    {  
        $langArray = Yii::$app->params['settings']['supportedLanguages'];
        
        $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . '://' . $_SERVER['HTTP_HOST'];
        
        $sitemapUrls = [];
        
        $html = '<?xml version="1.0" encoding="UTF-8"?>';
        
        $html .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">';
        
        $categories = BlogCategory::find()
                ->where(['!=', 'parent_category_id', 0])
                ->andWhere(['status_id' => BlogCategory::STATUS_PUBLISHED])
                ->all();
        
		$html .= '<url>';
		$html .= '<loc>'.$url.'</loc>';
		$html .= '<xhtml:link rel="alternate" hreflang="uk" href="'.$url.'/uk'.'"/>';
		$html .= '<xhtml:link rel="alternate" hreflang="en" href="'.$url.'"/>';
		$html .= '</url>';
		$html .= '<url>';
		
		$html .= '<loc>'.$url.'/uk'.'</loc>';
		$html .= '<xhtml:link rel="alternate" hreflang="uk" href="'.$url.'/uk'.'"/>';
		$html .= '<xhtml:link rel="alternate" hreflang="en" href="'.$url.'"/>';
		$html .= '</url>';
		
        foreach ($categories as $category){
            $translationRow = BlogMapEntityLang::getTranslationCatRow($category['id'], HdbkLanguage::getLanguageById($category['lang_id'])['code']);
            $html .= '<url>';
            $html .= '<loc>'.$url.Url::to(['/blog/category/front-view', 'id' => $category['id']]).'</loc>';
            foreach ($langArray as $lang){
                if(!empty($translationRow[$lang])){
                    $html .= '<xhtml:link rel="alternate" hreflang="'.$lang.'" href="'.$url.Url::to(['/blog/category/front-view','id' => $translationRow[$lang]]).'"/>';
                }
            }
            $html .= '</url>';
        }
        
        $posts = BlogPost::find()
                ->where(['blog_post.status_id' => BlogPost::STATUS_PUBLISHED])
                ->andWhere(['!=', 'blog_category.parent_category_id', 0])
                ->joinWith('category')
                ->all();
        
        foreach ($posts as $post){
            $translationRow = BlogMapEntityLang::getTranslationRow($post['id'], HdbkLanguage::getLanguageById($post['lang_id'])['code']); 
            $html .= '<url>';
            $html .= '<loc>'.$url.Url::to(['/blog/post/front-view','id' => $post['id']]).'</loc>';
            foreach ($langArray as $lang){
                if(!empty($translationRow[$lang])){
                    $html .= '<xhtml:link rel="alternate" hreflang="'.$lang.'" href="'.$url.Url::to(['/blog/post/front-view','id' => $translationRow[$lang]]).'"/>';
                }
            }
            $html .= '</url>';
        }
        
        $html .= '</urlset>';
        
        return $html;
    }
    
}
