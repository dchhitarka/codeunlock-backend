<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\models\Post;
use App\models\Comment;
use App\User;
use App\models\Tag;
use App\models\PostTag;
use App\models\PostEngagement;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        // $key = $req->query("s");
        // if($key == "latest"){
        $posts = Post::where("post_status", 1)->orderBy("published_on", 'desc')->get();
        $posts->each->tags;
        foreach($posts as $post){
            $post->comments_count = $post->comments->count();
            $post->interactions = $post->post_engagements->count();
            $post->post_engagements;
        }
        // }
        // else if($key  == "oldest"){
        //     $posts = Post::where("post_status", 1)->orderBy("created_at", 'asc')->get();
        //     $posts->each->tags;
        //     foreach($posts as $post){
        //         $post->comments_count = $post->comments->count();
        //         $post->interactions = $post->post_engagements->count();
        //         $post->post_engagements;
        //     }
        // }
        // else{
        //     $posts = Post::where("post_status", 1)->get();
        //     $posts->each->tags;
        //     foreach($posts as $post){
        //         $post->comments_count = $post->comments->count();
        //         $post->interactions = $post->post_engagements->count();
        //         $post->post_engagements;
        //     }
        //     return $posts->sortBy('interactions');
        // }
        return $posts;
    }

    public function admin_index()
    {
        $posts = Post::orderBy("created_at", 'desc')->get();
        $posts->each->tags;
        foreach($posts as $post){
            $post->comments_count = $post->comments->count();
            $post->interactions = $post->post_engagements->count();
            $post->post_engagements->each->user;
        }
        return $posts;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        try{
            if($req->user()->isAdmin)
            {
                $request = $req->validate([
                    'post_title' => 'required|string',
                    'post_body' => 'required|string',
                    // 'post_image' => 'string',
                    // 'post_status' => 'string',
                    // 'tags' => 'array'
                ]);
                $data = $req->all();
                $post = new Post;
                $post->user_id = $req->user()->id;
                $post->post_title = $data['post_title'];
                $post->post_body = $data['post_body'];
                $post->post_image = $data['post_image'] || null;

                if($data['post_status'] == '1'){
                    $post->published_on = Carbon::now();
                } else{
                    $post->published_on = null;
                }
                $post->post_status = $data['post_status'];
                $post->post_slug = Str::slug($data['post_title']);
                $tags = array();
                $post_tags = $data['tags']; 
                foreach ($post_tags as $tag) {
                    $tempTag = Tag::firstWhere('tag', $tag);
                    if(empty($tempTag)){
                        $newtag = new Tag;
                        $newtag->user_id = $req->user()->id;
                        $newtag->tag = $tag;
                        $newtag->tag_slug = Str::slug($tag);
                        $newtag->save();
                        $tags[$newtag->id] = $newtag->tag;
                    }
                    else{
                        $tags[$tempTag->id] = $tempTag->tag;
                    }
                }
                $post->save();                
                foreach ($tags as $id => $t) {
                    $post->tags()->attach($id);
                }
                // $post->message = "Post created successfully!";
                return $response(["post" => $post, "message" => "Post created successfully!"]);
            }
            return response(["error" => "You are not allowed to create a new post."], 403);
        }
        catch(Exception $e){
            return response(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $postSlug
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $postSlug)
    {
        $post = Post::firstWhere('post_slug', $postSlug);
        $post->tags;
        // return response(["user" => $request->user()]);
        // $post->post_engagements->where("user_id", $request->user());    
        // if($request->user() != null){
        //     $post->post_engagements->where("user_id", $request->user()->id);    
        // }else{
        //     $post->engaged = array('like' => false, 'bookmark' => false);
        // }
        return $post;
    }

    public function showPost(Request $request, $postSlug)
    {
        if($request->user()){
            $post = Post::firstWhere('post_slug', $postSlug);
            $post->tags;
            $post->post_engagements->where("user_id", $request->user()->id);
            return $post;    
        }
        return response(["message"=> "You are not authenticated!"], 400);
    }

    public function bookmarks(Request $request, $userId)
    {
        try{
            $posts = PostEngagement::where("user_id", Auth::user()->id)->where("bookmark", 1)->get();
            $saved = array();
            foreach ($posts as $p => $post) {
                $temp = Post::find($post->post_id);
                if($temp != null && $temp->post_status == 1)
                {
                    $temp->tags;
                    $temp->post_engagements->where("user_id", Auth::user()->id);
                    array_push($saved, $temp);
                }
            }
            return $saved;
        }
        catch(Exception $e){
            return response(["message" => $e->getMessage()], 500);
        }
    }

    public function likes(Request $request, $userId)
    {
        try{
            $posts = PostEngagement::where("user_id", Auth::user()->id)->where("like", 1)->get();
            $saved = array();
            foreach ($posts as $p => $post) {
                $temp = Post::find($post->post_id);
                if($temp != null && $temp->post_status == 1){
                    $temp->tags;
                    $temp->post_engagements->where("user_id", $request->user()->id);
                    array_push($saved, $temp);
                }
            }
            return $saved;
        }
        catch(Exception $e){
            return response(["message" => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $postId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $postId)
    {
        if($request->user()->isAdmin)
        {
            $post = Post::find($postId);
            $data = $request->all();
            $prevTags = array();
            foreach($post->tags as $t){
                $post->tags()->detach($t->id);
            }
            $post->post_title = $data['post_title'];
            $post->post_body = $data['post_body'];
            $post->post_image = $data['post_image'];
            if($data['post_status'] == '1' && $post->post_status == '0'){
                $post->published_on = Carbon::now();
            }
            $post->post_status = $data['post_status'];
            $post->post_slug = Str::slug($data['post_title']);
            $updatedTags = array();
            $post_tags = $data['tags'];
            foreach ($post_tags as $tag) {
                $tempTag = Tag::firstWhere('tag', $tag);
                if(empty($tempTag)){
                    $newtag = new Tag;
                    $newtag->user_id = $request->user()->id;
                    $newtag->tag = $tag;
                    $newtag->tag_slug = Str::slug($tag);
                    $newtag->save();
                    $updatedTags[$newtag->id] = $newtag->tag;
                }
                else{
                    $updatedTags[$tempTag->id] = $tempTag->tag;
                }
            }

            foreach ($updatedTags as $id => $t) {
                $post->tags()->attach($id);
            }
            $post->save();
            $post->load('tags');
            $post->message = "Post updated successfully!";
            return $post; 
            // return response(["post" => $post, "message" => "Post updated successfully!"]);
        }
        return response(["error"=>"User not allowed to edit this post."], 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $postSlug
     * @return \Illuminate\Http\Response
     */
    public function destroy($postId)
    {
        Comment::where("post_id", $postId)->delete();
        PostTag::where("post_id", $postId)->delete();
        Post::find($postId)->delete();
        return response(["message" => "Post deleted successfully"]);
    }

    // Like/Bookmarks
    public function likePost(Request $reqeust, $postId, $userId)
    {
        try{
            $postEngagement = PostEngagement::where("user_id", $userId)->firstWhere("post_id", $postId);
            $post = Post::find($postId);
            if(empty($postEngagement)){
                $postEngagement = new PostEngagement;
                $postEngagement->user_id = $userId;
                $postEngagement->post_id = $postId;
                $postEngagement->like = true;
                $postEngagement->save();
                $post->post_likes += 1;
                $post->save();
                return response(["likes" => $post->post_likes, "bookmarks" => $post->post_bookmarks, "message" => "Successfully Liked"]);
            }
            elseif(!$postEngagement->like){
                $postEngagement->like = true;
                $postEngagement->save();
                $post->post_likes += 1;
                $post->save();
                return response(["likes" => $post->post_likes, "bookmarks" => $post->post_bookmarks, "message" => "Successfully Liked"]);
            }
            else{
                $postEngagement->like = false;
                $postEngagement->save();
                $post->post_likes -= 1;
                $post->save();
                return response(["likes" => $post->post_likes, "bookmarks" => $post->post_bookmarks, "message" => "Successfully Unliked"]);
            }
            // return response(["likes" => $post->post_likes, "bookmarks" => $post->post_bookmarks, "message" => "Already Liked"]);
        }
        catch(Exception $e){
            return response(["message" => $e->getMessage()], 500);
        }
    }
    
    public function bookmarkPost($postId, $userId)
    {
        try{
            $postEngagement = PostEngagement::where("user_id", $userId)->firstWhere("post_id", $postId);
            $post = Post::find($postId);
            if(empty($postEngagement)){
                $postEngagement = new PostEngagement;
                $postEngagement->user_id = $userId;
                $postEngagement->post_id = $postId;
                $postEngagement->bookmark = true;
                $postEngagement->save();    
                $post->post_bookmarks += 1;
                $post->save();
                return response(["likes" => $post->post_likes, "bookmarks" => $post->post_bookmarks, "message" => "Successfully Bookmarked"]);
            }
            elseif(!$postEngagement->bookmark){
                $postEngagement->bookmark = true;
                $postEngagement->save();
                $post->post_bookmarks += 1;
                $post->save();
                return response(["likes" => $post->post_likes, "bookmarks" => $post->post_bookmarks, "message" => "Successfully Bookmarked"]);
            }
            else{
                $postEngagement->bookmark = false;
                $postEngagement->save();
                $post->post_bookmarks -= 1;
                $post->save();
                return response(["likes" => $post->post_likes, "bookmarks" => $post->post_bookmarks, "message" => "Successfully Unbookmarked"]);    
            }
            // return response(["likes" => $post->post_likes, "bookmarks" => $post->post_bookmarks, "message" => "Already Bookmarked"]);
        }
        catch(Exception $e){
            return response(["message" => $e->getMessage()], 500);
        }
    }

    public function search(Request $request){
        $query = '%'.$request->input('q').'%';
        $posts = Post::where('post_title', 'LIKE', $query)->orWhere('post_body', 'LIKE', $query)->where('post_status', 1)->limit(5)->get(array('post_title', 'post_slug'));
        return response()->json($posts);
    }

    public function admin_dashboard(Request $request){
        if($request->user() && $request->user()->isAdmin){
            $post_count = Post::count();
            $tag_count = Tag::count();
            $user_count = User::count();
            return response(["post_count" => $post_count, "tag_count" => $tag_count, "user_count" => $user_count]);
        }
        return response(["message"=> "You are not allowed to access this resource"], 401);
    }

}
