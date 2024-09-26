<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\models\Tag;
use App\models\Post;
use App\models\TagEngagement;
use App\models\PostTag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::orderBy("followers", 'desc')->get();
        foreach($tags as $tag){
            $posts = DB::table("post_tag")->select('post_id')->where('tag_id', $tag->id)->get();
            $ids = array();
            foreach($posts as $post){
                array_push($ids, $post->post_id);
            }
            $post = Post::whereIn('id', $ids)->where('post_status', 1)->get();
            $tag->post_count = $post->count();
            $tag->followers;
            $tag->engagements = TagEngagement::where('tag_id', $tag->id)->where("follow", 1)->get();
        }
        // $tags = $tags->sortBy('post_count');
        return $tags;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($tagSlug)
    {
        $tag = Tag::firstWhere("tag_slug", $tagSlug);
        
        $posts = DB::table("post_tag")->select('post_id')->where('tag_id', $tag->id)->get();
        $ids = array();
        foreach($posts as $post){
            array_push($ids, $post->post_id);
        }
        $post = Post::whereIn('id', $ids)->where('post_status', 1)->get();
        $tag->post_count = $post->count();
        $tag->posts = $post;
        $tag->posts->each->post_engagements;
        $tag->posts->each->tags;
        $tag->user;
        $tag->followers;
        $tag->engagements = TagEngagement::where('tag_id', $tag->id)->where("follow", 1)->get();
        return $tag;
    }


    // $posts = PostTag::select('post_id')->where('tag_id', $tag->id);
    // $tag->posts = Post::whereIn('id', $posts)->where("post_status",1)->get();
    // $tag->posts->each->post_engagements;
    // $tag->user;
    // $tag->post_count = $tag->posts->where("post_status", 1)->count();
    // $tag->followers;
    // $tag->engagements = TagEngagement::where('tag_id', $tag->id)->where("follow", 1)->get();


    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $tag = Tag::firstOrCreate(["tag" => $req->tag], ["description" => $req->description, "user_id" => $req->user()->id, "tag_slug" => Str::slug($req->tag)]);
        $tag->user;
        $tag->posts;
        return $tag;
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
        $tag = Tag::find($id);
        $tag->tag = $request->tag;
        $tag->description = $request->description;
        $tag->save();
        $tag->posts;
        $tag->user;
        return $tag;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $postSlug
     * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        PostTag::where('tag_id', $id)->delete();
        Tag::destroy($id);
        return response(["message" => "Tag deleted successfully"]);
    }

    public function engage(Request $request, $tagId, $userId)
    {
        try{
            $tagEngagement = TagEngagement::where("user_id", $userId)->firstWhere("tag_id", $tagId);
            $tag = Tag::find($tagId);
            if(empty($tagEngagement)){
                $tagEngagement = new TagEngagement;
                $tagEngagement->user_id = $userId;
                $tagEngagement->tag_id = $tagId;
                $tagEngagement->follow = true;
                $tagEngagement->save();
                $tag->followers += 1;
                $tag->save();
                return response(["follows"=> $tagEngagement->follow, "followers" => $tag->followers, "message" => "Successfully Following"]);
            }
            elseif(!$tagEngagement->follow){
                $tagEngagement->follow = true;
                $tagEngagement->save();
                $tag->followers += 1;
                $tag->save();
                return response(["follows"=> $tagEngagement->follow, "followers" => $tag->followers, "message" => "Successfully Following"]);
            }
            else{
                $tagEngagement->follow = false;
                $tagEngagement->save();
                $tag->followers -= 1;
                $tag->save();
                return response(["follows"=> $tagEngagement->follow, "followers" => $tag->followers, "message" => "Successfully Unfollowed"]);    
            }
        }
        catch(Exception $e){
            return response(["message" => $e->getMessage()], 500);
        }
    }

}
