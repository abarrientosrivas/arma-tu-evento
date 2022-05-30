<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\PostImage;
use Image;
use Storage;

class PostImageController extends Controller
{
     /**
     * Add image to album
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addImage(Request $request)
    {
        // Get post
        $post = Post::with('postImages')->findOrFail($request->input('postId'));

        if($post->postImages()->count()>=6){
            return back()->withErrors('No puede cargar más imagenes');
        }

        $image = file_get_contents($request->input('dataURL'));
        $filename = date("Y-m-d_") . round(microtime(true) * 1000) . "-" . $request->input('postId') . ".jpg";
        $location = public_path('assets/post-album-images/' . $filename);
        Image::make($image)->encode('jpg')->save($location);

        $postImage = new PostImage;
        $postImage->filename = $filename;

        $post->postImages()->save($postImage);
        
        return response()->json(Post::with('postImages')->findOrFail($post->id)->toArray());
    }

       /**
     * Remove the specified image
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteImage($id)
    {
        // Get post
        $postImage = PostImage::findOrFail($id);

        Storage::delete('assets/post-album-images/' . $postImage->filename);

        if($postImage->delete()){
            return response()->json($postImage->toArray());
        }
    }
}
