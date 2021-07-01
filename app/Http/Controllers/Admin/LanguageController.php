<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class LanguageController extends Controller
{
    public function list()
    {
        $pageTitle = "Language Lists";
        $pageSubTitle = "Languages";
        $items = Language::orderBy('id', 'desc')->get();

        return view('admin.language.list', \compact('pageTitle', 'pageSubTitle', 'items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:languages',
            'text_align' => 'required|in:0,1'
        ], [
            'text_align.in' => "Invalid Text Alignment"
        ]);

        try {
            $data = file_get_contents(resource_path('lang/') . 'en.json');
        } catch (\Throwable $th) {
            $data = '{"Dashboard":"Dashboard"}';
        }

        $json_file = strtoupper($request->code) . '.json';
        $path = resource_path('lang/') . $json_file;

        File::put($path, $data);


        $language = new  Language();
        $language->name = $request->name;
        $language->code = strtoupper($request->code);
        $language->text_align = $request->text_align;
        $language->save();

        return back()->with('success', 'Create successfully');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:languages,code,' . $request->languageId,
            'text_align' => 'required|in:0,1'
        ], [
            'text_align.in' => "Invalid Text Alignment"
        ]);

        $language = Language::findOrFail($request->languageId);

        $language->name = $request->name;
        $language->code = strtoupper($request->code);
        $language->text_align = $request->text_align;
        $language->update();

        return back()->with('success', 'Update successfully');
    }

    public function destroy(Request $request)
    {
        $lang = Language::findOrFail($request->languageId);
        removeFile(resource_path('lang/') . $lang->code . '.json');
        $lang->delete();

        return back()->with('success', 'Language deleted successfully');
    }

    public function translateCreate($id)
    {
        $lang = Language::findOrFail($id);

        $pageTitle = "Translate Language - " . $lang->name;
        $pageSubTitle = "Language Manager";
        $json = file_get_contents(resource_path('lang/') . $lang->code . '.json');
        $languages = Language::all();

        if (empty($json)) {
            return back()->with('error', 'File not found');
        }
        $translates = json_decode($json, true);

        return view('admin.language.translate.create', compact('pageTitle', 'pageSubTitle', 'translates', 'lang', 'languages'));
    }

    public function translateUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'key' => 'required',
            'translate' => 'required'
        ]);

        $language = Language::findOrFail($id);
        $items = json_decode(file_get_contents(resource_path('lang/') . $language->code . '.json'), true);

        if (array_key_exists($request->key, $items)) {
            return back()->with('error', "$request->key Already Exists");
        } else {
            $data[$request->key] = $request->translate;
            $new = \array_merge($items, $data);
        }

        file_put_contents(resource_path('lang/') . $language->code . '.json', json_encode($new));

        return \back()->with('success', "$request->key has been added");
    }

    public function translateUpdateByKey(Request $request, $id)
    {
        $this->validate($request, [
            'key' => 'required',
            'translate' => 'required'
        ]);

        $language = Language::findOrFail($id);
        $items = json_decode(file_get_contents(resource_path('lang/') . $language->code . '.json'), true);

        if (array_key_exists($request->key, $items)) {
            $items[$request->key] = $request->translate;
        } else {
            return back()->with('error', "$request->key Invalid");
        }

        file_put_contents(resource_path('lang/') . $language->code . '.json', json_encode($items));

        return \back()->with('success', "$request->key has been updated");
    }

    public function translateDestroyByKey(Request $request, $id)
    {
        $this->validate($request, [
            'key' => 'required',
        ]);

        $language = Language::findOrFail($id);
        $items = json_decode(file_get_contents(resource_path('lang/') . $language->code . '.json'), true);

        if (array_key_exists($request->key, $items)) {
            unset($items[$request->key]);
        } else {
            return back()->with('error', "$request->key Invalid");
        }

        file_put_contents(resource_path('lang/') . $language->code . '.json', json_encode($items));

        return \back()->with('success', "$request->key has been deleted");
    }


    public function default($id)
    {
        $language = Language::findOrFail($id);

        Language::where('id', '!=', $id)->update([
            'status' => 0
        ]);

        $language->status = 1;
        $language->update();

        \session()->put('lang', $language->code);
        return back()->with('success', 'Set as default');
    }
}
