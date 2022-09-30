<?php

namespace App\Http\Controllers\API\V1\Blog;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Requests\BlogRequest;
use App\Http\Resources\BlogResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\V1\BaseController;

class BlogController extends BaseController
{
    private $blogPath = 'blogs';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = BlogResource::collection(Blog::latest()->paginate(2))->response()->getData(true);
        return $this->sendSuccessResponse($blogs, 'Blog Lists');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $request)
    {
        $image_path = null;
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store($this->blogPath);
        }

        Blog::create(array_merge($request->validated(), [
            'image' =>  $image_path,
        ]));
        return $this->respondCreated('Blog Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        return $this->sendSuccessResponse($blog, 'Blog Data');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(blogRequest $request, Blog $blog)
    {
        $image_path = null;
        if ($request->hasFile('image')) {
            if($blog->image != '' && Storage::exists($blog->image))
            {
                Storage::delete($blog->image);
            }
            $image_path = $request->file('image')->store($this->blogPath);
        }

        $blog = Blog::create(array_merge($request->validated(), [
            'image' =>  $image_path,
        ]));
        return $this->sendSuccessResponse($blog, 'Blog Lists');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        if($blog->image != '' && Storage::exists($blog->image))
        {
            Storage::delete($blog->image);
        }
        $blog->delete();
        return $this->sendSuccessResponse('', 'Blog Deleted');
    }
}
