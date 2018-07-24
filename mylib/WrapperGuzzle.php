<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 23.07.2018
 * Time: 16:23
 */
namespace mylib;

class WrapperGuzzle
{
    private $apiKey;
    protected $arrayBody = NULL;
    private $idLab;
    private $countPages;
    const API_URL_GET_LABRATORIES = 'https://mylab.report/api/v1/mis/lab/getall';
    const API_URL_GET_ANALISES = 'https://mylab.report/api/v1/mis/labtest/getall';
    private $idLabaratories;

    public static function array_key_search($value, $key) {
        $result = false;
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $result = $k === $key ? $v : self::array_key_search($v, $key);
                if ($result) {
                    break;
                }
            }
        }
        return $result;
    }

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->idLabaratories = $this->getLaboratories();
    }

    public function getIdLabaratories(){
        return $this->idLabaratories;
    }

    public function setGuzzleClient(){
        return $client = new \GuzzleHttp\Client([
            'headers' => [ 'Content-Type' => 'application/json', 'X-ApiKey' => $this->apiKey ]
        ]);
    }


    /**
     * Имя или краткое описание объекта
     *
     * Отримати перелік лабораторій, в які можливо здійснити направлення
     *
     * @params array $arrayBody
     * @return array
     */

    private function getPosts($pageno=0,$limit=100,$url=''){
        //self::API_URL_GET_LABRATORIES;
        return $response = $this->setGuzzleClient()->post($url,
            ['body' => json_encode(
                [
                    'page' =>
                        ['pageno'=>$pageno,'limit'=>$limit]
                ]
            )]
        );
    }

    public function getLaboratories(){
        $response = $this->getPosts(0,100,self::API_URL_GET_LABRATORIES);

        if($response->getStatusCode()===200)
                {
                    $res = json_decode($response->getBody()->getContents(), True);
                    return $res['data']['labs'][0];

                }
        else    {return '{"error":"'.$response->getStatusCode().'"}';}
    }



    public function getAnalises(){
        $this->idLab = self::array_key_search($this->getIdLabaratories(),'id');

        $response = $this->setGuzzleClient()->post(self::API_URL_GET_ANALISES,
            ['body' => json_encode(
                [
                    'labid' =>$this->idLab,
                    'page' =>
                        ['pageno'=>0,'limit'=>100]
                ]
            )]
        );
        $res = json_decode($response->getBody()->getContents(), True);
        $this->countPages=self::array_key_search($res,'pages');



        //return $res['data']['page'][0]['pages'];
    }




}