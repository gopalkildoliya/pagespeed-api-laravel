<?php

namespace GopalKildoliya\PageSpeedApi;

class PageSpeedTest
{
    protected $confg = array(
        'url' => 'https://www.google.com',
        'filter_third_party_resources' => 'false',
        'screenshot' => 'true',
        'strategy' => 'desktop',
        'key' => 'key'
    );
    protected $apiDomain = 'https://www.googleapis.com/pagespeedonline/v2/runPagespeed';
    public $jsonResult;
    public $id;
    public $title;
    public $responseCode;
    public $speedScore;
    public $stats;

    public function testUrl($targetUrl)
    {
        $this->confg['url'] = $targetUrl;
        $this->jsonResult = $this->callApi();
        $resultObject = json_decode($this->jsonResult);
        $this->responseCode = $resultObject->responseCode;
        if($this->responseCode==200)
            $this->formatResult($resultObject);
    }

    protected function callApi()
    {
        $url = $this->apiDomain.'?'.http_build_query($this->confg);;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    protected function formatResult($resultObject)
    {
        $this->title = $resultObject->title;
        $this->id = $resultObject->id;
        $this->speedScore = $resultObject->ruleGroups->SPEED->score;
    }
}
