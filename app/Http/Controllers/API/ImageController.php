<?php

namespace App\Http\Controllers\API;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Image[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request)
    {
        $q = Image::query();

        foreach ($request->all() as $key => $value) {
            $q->where($key, 'LIKE', "%$value%");
        }

        return $q->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return Image
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        abort_if(!$request->hasFile('file'), 400);

        $image = new Image($request->all());
        $image->path = config('images.path');
        $image->name = $request->file('file')->getClientOriginalName();
        $image->extension = $request->file('file')->getClientOriginalExtension();

        $image->saveOrFail();

        $imageName = "{$image->id}.{$image->extension}";

        $request->file('file')->storeAs(config('images.path'), $imageName);

        return $image;
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

    public function render(Image $image) {
        return response()->file(storage_path( "app/{$image->path}/{$image->id}.{$image->extension}"));
    }
}
