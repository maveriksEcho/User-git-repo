<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GitServiceController extends Controller
{
    private $url;
    private $per_page;

    public function __construct ()
    {
        $this->url      = config('git.url');
        $this->per_page = config('git.per_page');
    }

    /**
     * @throws \Exception
     */
    public function getUserRepo()
    {
        $url = 'users/' . Auth::user()->name . '/repos?per_page=' . $this->per_page;
        return $this->request($url);
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function getOneRepo($id)
    {
        $url = 'repositories/' . $id;
        return $this->request($url);
    }

    /**
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function searchByName($name)
    {
        $url = 'search/repositories?q=' . $name . '+in:name&order=desc&per_page='. $this->per_page;
        return $this->request($url);
    }

    /**
     * @param $url
     * @return mixed
     * @throws \Exception
     */
    private function request($url){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url . $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Accept: application/vnd.github.v3+json',
            'User-Agent: Awesome-Octocat-App']
        );
        $response = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
     /*   if ($http_status !== 200)
        {
            logger($url, [$response]);
            throw new \Exception('fail');
        }*/
        curl_close($curl);
        return json_decode($response, true);
    }
}
