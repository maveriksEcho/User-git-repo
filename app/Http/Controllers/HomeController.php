<?php

namespace App\Http\Controllers;

use App\Contract\GitService;
use App\Score;
use App\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /*
     * GitService
     */
    private $service;

    /**
     * Create a new controller instance.
     *
     * @param GitService $service
     */
    public function __construct(GitService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     * @throws \Exception
     */
    public function index()
    {
        $repos = $this->service->getUserRepo();
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
        $this->validate($request,[
            'search' => 'required|string'
        ]);
        $repos = $this->service->searchByName($request->get('search'));
        $repos = $this->getScore($repos['items']);
        return view('home', compact('repos'));
    }

    /**
     * @param $repos
     * @return array
     */
    private function getScore($repos)
    {
        /*$res = [];
        foreach ($repos as $repo){
            $score = Score::select('score')->where('user_id', Auth::user()->id)->where('repo_id', $repo['id'])->first();
            $res[] = array_merge($repo, ['score' => $score ? $score->score : -1]);
        }*/

        $collection = collect($repos);

        $list = $collection->map(function ($repo){
                    return $repo['id'];
              });

        /**
         * @var Score $scores
         */
        $scores = Score::select(['repo_id','score'])
            ->whereIn('repo_id',$list)
            ->where('user_id', Auth::user()->id)
            ->get();

        $res = $collection->transform(function ($repo) use ($scores) {
            foreach ($scores as $score){
                if($repo['id'] == $score['repo_id']){
                    return array_merge($repo, [
                        'score' => $score['score']
                    ]);
                }
            }
            return $repo;
        });
        return $res;
    }

    /**
     * @param $repo
     * @return array
     */
    private function getScoreForDetails($repo)
    {
        /**
         * @var Builder $query
         */
        $query = Score::where('repo_id', $repo['id']);
        $_query = clone $query;
        $like = $query->where('score', 1)->count();
        $dislike = $_query->where('score', 0)->count();
        return array_merge($repo, [
            'like' => $like,
            'dislike' => $dislike
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function details($id)
    {
        $repo = $this->service->getOneRepo($id);
        $repo = $this->getScoreForDetails($repo);
        $score = Score::where('user_id', Auth::user()->id)
            ->where('repo_id', $repo['id'])
            ->first(['score'])->toArray();

        $repo = array_merge($repo,$score );
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
