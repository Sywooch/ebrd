<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\modules\blog\models\BlogCategory;
use frontend\modules\blog\models\BlogGroup;
use yii\helpers\Url;
use frontend\modules\blog\components\widgets\grouped_menu\BlogGroupedMenu;

class HtmlSitemap extends Model
{

    public function htmlSitemapGenerator()
    {  
        $langArray = Yii::$app->params['settings']['supportedLanguages'];
        
        $html = '';
        
        $currentLangStructure = BlogGroupedMenu::getMultilangStructure()[Yii::$app->language]['items'];
        
        $html .= '<div class="main_sitemap_container">';
        
        foreach ($currentLangStructure as $currentLangLink){
            $html .= '<div class="main_sitemap_block">';
			if(BlogCategory::getCategory($currentLangLink['categoryId'])[0]->status_id == 11){
				$html .= '<a class="main_sitemap_category" href='.Url::to(['/blog/category/front-view', 'id' => $currentLangLink['categoryId']]).'>'.BlogCategory::getCategory($currentLangLink['categoryId'])[0]->menu_section.'</a>';
			}
            foreach ($currentLangLink['menuColumns'] as $groupId){
                foreach (BlogGroup::getGroup($groupId) as $groupCategories){
					if($groupCategories->status_id == 11){
						foreach ($groupCategories->categories as $groupCategory){
							if($groupCategory->status_id == 11){
								$html .= '<a class="secondary_sitemap" href='.Url::to(['/blog/category/front-view', 'id' => $groupCategory->id]).'>'.$groupCategory->menu_section.'</a>';
							}
						}
					}
                }
            }
            $html .= '</div>';
        }
        
        $html .= '</div>';
        
        return $html;
    }
    
}
