<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use frontend\modules\plugins\models\PluginsAutolinker;

class CronController extends Controller
{
    /**
     * Checks if url in auto-links are valid or not
     */
    public function actionCheckUrl()
    {
        $validResponses = [200, 301, 302];
        $result = "All links are fine";
        $autoLinkerRows = PluginsAutolinker::find()
            ->where(['status' => PluginsAutolinker::STATUS_ENABLED])
            ->all();
        
        foreach ($autoLinkerRows as $row) {
            $id = $row->id;
            $link = $row->url;
            if (filter_var($link, FILTER_VALIDATE_URL) === false) {
                echo "Url is not valid: {$link}". PHP_EOL;
                PluginsAutolinker::changeStatus($id, 0, 'Url is not valid');
                continue;
            }
            $header = get_headers($link, 1);
            $response = explode(' ', $header[0])[1];
            if (!in_array($response, $validResponses)) {
                $result = "Some links was broken";
                echo "Illegal url: {$link}, code: {$response}". PHP_EOL;
                PluginsAutolinker::changeStatus($id, 0, 'Illegal url');
            } else if ($response == '301' || $response == '302') {
                echo "Moved link: {$link}, code: {$response}". PHP_EOL;
                if (is_array($header['Location'])) {
                    $newlink = array_values(array_slice($header['Location'], -1))[0];
                } else {
                    $newlink = $header['Location'];
                }
                PluginsAutolinker::changeLink($id, $newlink, 'link was changed');
            }
        }

        echo "{$result}\nEnd procedure\n";
    }
}