<?php

namespace App\Http\Controllers;

use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use Illuminate\Support\Facades\File;


class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        return response()->json($sliders);
    }

    public function create()
    {
        dd('hello');
    }

    public function store(SliderRequest $request)
    {
        $slider = Slider::create($request->validated());
        if ($request->hasFile('slider_pic')) {
            $this->unlink($request->slider_pic);
            $image_title = $this->uploadFile($request->slider_pic,  $request->id);
        }
        $slider->images()->create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'title' => $image_title,
            'path' => 'uploads/sliders/'.$image_title
        ]);
        return response()->json($slider, 201);
    }

    public function show(Slider $slider)
    {
        return response()->json($slider);
    }

    public function update(SliderRequest $request, Slider $slider)
    {
        $slider->update($request->validated());
        return response()->json($slider);
    }

    public function destroy(Slider $slider)
    {
        $slider->delete();
        return response()->json(null, 204);
    }

    private function uploadFile($file, $name)
    {
        $folder = storage_path('/app/public/sliders/');
        if (!File::exists($folder)) {
            $folderCreate = File::makeDirectory($folder, 0775, true, true);
            if (!isset($folderCreate))
                throw new \Exception("Could not permission for creating folder on storage path.", 1);
        }
        $timestamp = str_replace([' ', ':', '-'], '', now());
        $file_name = $timestamp . '_' . $name . '.' . $file->getClientOriginalExtension();
        $file->move($folder, $file_name);

        return $file_name;
    }

    private function unlink($file)
    {
        $pathToUpload = storage_path() . '/app/public/sliders/';
        if ($file != '' && file_exists($pathToUpload . $file)) {
            @unlink($pathToUpload . $file);
        }
    }

}
