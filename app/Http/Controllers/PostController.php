<?php

namespace App\Http\Controllers;
use auth;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Rules\CheckUserCreateExceed3Posts;
use function PHPUnit\Framework\fileExists;

use App\Http\Requests\posts\StorePostRequest;
use App\Http\Requests\posts\UpdatePostRequest;
use Carbon\Carbon;

class PostController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

            $todayDate = Carbon::now()->format('Y-m-d');
            // $posts = DB::table('posts')->get();
            $users = User::all();
            // $posts = Post::when($request->date !=null ,function($q) use ($request){
            //                         return $q->whereDate('created_at',$request->date);
            //                     },function($q) use ($todayDate){
            //                         $q->whereDate('created_at',$todayDate);
            //                     })
            //                     ->when($request->user_id !=null ,function($q) use ($request){
            //                         return $q->where('user_id',$request->user_id);
            //                     })

            //                     ->paginate(4);
            $posts = Post::paginate(4);
            return view('posts.list',['posts'=>$posts,'users'=>$users]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('posts.create',['users'=>$users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request,Post $post)

    {

        $id =auth()->id();

        // create if more than 3 post
        $numberCretor =  Post::where('post_creator', $id)->count();
        // dd($numberCretor);
        if($numberCretor > 2 ){
            return redirect()->route('posts.all')->with('fail', 'You cant create more than 3 posts!');

        }
        $postValidated = $request->validated();
        $post = new Post();
        if($request->hasFile('image')){
             $imagename=uploadImage($request->file('image'),'posts');
             $post->image = $imagename;
        }
        $post->name = $postValidated['name'];
        $post->description = $postValidated['description'];
        $post->user_id = $postValidated['user_id'];
        $post->post_creator = $id;
        // $post->created_at = Carbon::now()->format('Y-m-d');
        $post->save();
        return redirect()->route('posts.all')->with('success', 'Your Post has been added successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // $post = DB::table('posts')
        $post = Post::find($id);
         return view('posts.show',['post'=>$post]);
        //
    }
    public function show_modal($id)
    {

        // $post = DB::table('posts')
        $post = Post::find($id);
        $user = User::find($post->user_id);
        //  return view('posts.show',['post'=>$post]);
        return response()->json([
            'data' => $post,
            'user' =>$user,

          ]);
        //
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $users = User::all();
         return view('posts.edit',['post'=>$post,'users'=>$users]);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, $id)
    {
        $post = Post::find($id);
        $validated = $request->validated();
        // dd($post);
        // $request->validate()
        if($request->hasFile('image')){
            if($post->image !=NULL){
                // File::delete('images/' .$post->image);
                unlink('storage/' . $post->image);
                $post->image = uploadImage($request->file('image'),'posts');
            }else{
                $post->image = uploadImage($request->file('image'),'posts');
            }
        }


        $post->name = $validated['name'];
        $post->description = $validated['description'];
        $post->user_id = $validated['user_id'];
        $post->save();

        // $data= request()->all();
        //  array_shift($data);
        // dd($data);
        // Post::update($post);
        return redirect()->route('posts.all')->with('success', 'Your Post has been updated successfully!');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->delete_post_id;
        // DB::table('posts')->where('id', $id)->delete();
        $post = Post::find($id);
        // dd($post);
        if($post->image != null){
            unlink('storage/' .$post->image);
            $post->image = null;
            $post->save();

        }

        $post->delete();
        // $post->forceDelete();
        return redirect()->route('posts.all')->with('success', 'Your Post has been deleted successfully!');;

    }

    public function forceDelete(Request $request)
    {
        $id = $request->delete_post_id;
        // DB::table('posts')->where('id', $id)->delete();
        $post = Post::withTrashed()->find($id);
        $post->forceDelete();
        // $post->forceDelete();
        return redirect()->route('posts.all')->with('success', 'Your Post has been deleted permnant successfully!');;

    }

    public function restore($id)
    {

        // DB::table('posts')->where('id', $id)->delete();
        $post = Post:: withTrashed()->find($id)->restore();
        // $post->forceDelete();
        return redirect()->route('posts.all')->with('success', 'Your Post has been restored successfully!');;

    }


    public function deleted(){

        $posts = Post::onlyTrashed()->paginate(3);
        return view('posts.deleted',['posts'=>$posts]);
    }




    public function getPostsByUser(Request $request){
        $users = User::all();
        $posts = Post::paginate(4);
        if($request->ajax()){
            $posts = Post::where('user_id',$request->user_id)->paginate(4);
            return response()->json(['posts'=>$posts]);
        }
        return view('posts.list',['posts'=>$posts,'users'=>$users]);

    }
}