<?php

namespace App\Http\Controllers;

use App\Score;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     * @throws \Exception
     */
    public function index()
    {
        $repos = (new GitServiceController())->getUserRepo();
        $repos = $this->getScore($repos);
        return view('home', compact('repos'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function search(Request $request)
    {
        $repos = (new GitServiceController())->searchByName($request->get('search'));
        $repos = $this->getScore($repos['items']);
        return view('home', compact('repos'));
    }

    /**
     * @param $repos
     * @return array
     */
    private function getScore($repos)
    {
        $res = [];
        foreach ($repos as $repo){
            $score = Score::select('score')->where('user_id', Auth::user()->id)->where('repo_id', $repo['id'])->first();
            $res[] = array_merge($repo, ['score' => $score ? $score->score : -1]);
        }
        return $res;
    }

    /**
     * @param $repo
     * @return array
     */
    private function getScoreForDetails($repo)
    {
        $like = Score::where('repo_id', $repo['id'])->where('score', 1)->count();
        $dislike = Score::where('repo_id', $repo['id'])->where('score', 0)->count();
        return array_merge($repo, ['like' => $like, 'dislike' => $dislike]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function details($id)
    {
        $repo = (new GitServiceController())->getOneRepo($id);
        $repo = $this->getScoreForDetails($repo);
        return view('details', compact('repo'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function score(Request $request)
    {
        /**
         * @var User $user
         */
        $user = Auth::user();
        $score = Score::where('user_id', $user->id)->where('repo_id', $request->get('repo_id'))->first();
        if($score){
            $score->update([
                'score'   => $request->get('score')
            ]);
        }else{
            $user->score()->create([
                'user_id' => $user->id,
                'repo_id' => $request->get('repo_id'),
                'score'   => $request->get('score')
            ]);
        }
        return response()->json([]);
    }
}
