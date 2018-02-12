<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Vote;
use App\Post;
use Auth;
use DB;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $views = Post::find($request->post_id);
        $views->post_votes += 1;
        $views->update();

        $userId = Auth::user()->id;
        $postId = $request->post_id;
        $vote =  Vote::where('user_id', $userId)
            ->where('post_id', $postId)
            ->get();
        if (isset($vote[0]) && !empty($vote[0])){
        if (isset($vote[0]->vote) && !empty($vote[0]->vote)){
            if($vote[0]->vote==1){
                $delete = Vote::find($vote[0]->id);
                $delete->delete();
                $voteNumber =  DB::table('votes')
                    ->where('post_id', $postId)
                    ->sum('vote');
                return response()->json(['stauts'=>'deleted','voteNumber' => $voteNumber]);
            }elseif ($vote[0]->vote==-1){
                $update = Vote::find($vote[0]->id);
                $update->vote = 1;
                $update->update();
                $voteNumber =  DB::table('votes')
                    ->where('post_id', $postId)
                    ->sum('vote');
                return response()->json(['status'=>'upvoted','voteNumber' => $voteNumber]);
            }
        }
        }else{
            $vote = new Vote();
            $vote->vote = 1;
            $vote->post_id = $postId;
            $vote->user_id = $userId;
            $vote->save();
            $voteNumber =  DB::table('votes')
                ->where('post_id', $postId)
                ->sum('vote');
            return response()->json(['status'=>'upvoted','voteNumber' => $voteNumber]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function downVote(Request $request)
    {
        $views = Post::find($request->post_id);
        $views->post_votes -= 1;
        $views->update();

        $userId = Auth::user()->id;
        $postId = $request->post_id;
        $vote =  Vote::where('user_id', $userId)
            ->where('post_id', $postId)
            ->get();

        if (isset($vote[0]) && !empty($vote[0])){
            if (isset($vote[0]->vote) && !empty($vote[0]->vote)){
                if($vote[0]->vote==-1){
                    $delete = Vote::find($vote[0]->id);
                    $delete->delete();
                    $voteNumber =  DB::table('votes')
                        ->where('post_id', $postId)
                        ->sum('vote');
                    return response()->json(['status'=>'deleted','voteNumber' => $voteNumber]);
                }elseif ($vote[0]->vote==1){
                    $update = Vote::find($vote[0]->id);
                    $update->vote = -1;
                    $update->update();
                    $voteNumber =  DB::table('votes')
                        ->where('post_id', $postId)
                        ->sum('vote');
                    return response()->json(['status'=>'downvoted','voteNumber' => $voteNumber]);
                }
            }
        }else{
            $vote = new Vote();
            $vote->vote = -1;
            $vote->post_id = $postId;
            $vote->user_id = $userId;
            $vote->save();
            $voteNumber =  DB::table('votes')
                ->where('post_id', $postId)
                ->sum('vote');
            return response()->json(['status'=>'downvoted','voteNumber' => $voteNumber]);
        }
    }
}
