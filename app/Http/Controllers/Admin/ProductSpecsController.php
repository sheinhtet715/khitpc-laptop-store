<?php

namespace App\Http\Controllers\Admin;

use App\Models\Products_specs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog; 
use Illuminate\Support\Facades\Auth; 

class ProductSpecsController extends Controller
{
    public function list()
    {
        $productspecs = Products_specs::select('spec_id', 'Model', 'Processor', 'Ram', 'Graphics_Card', 'System_type', 'Display', 'Battery', 'Pen_and_touch', 'Storage', 'Warranty', 'created_at')
            ->when(request('searchKey'), function ($query) {
                $query->whereAny(['Model', 'Processor', 'Ram', 'Graphics_Card', 'System_type', 'Display', 'Battery', 'Pen_and_touch', 'Storage', 'Warranty'], 'like', '%' . request('searchKey') . '%');
            })
            ->orderBy('created_at', 'desc')->paginate(5);

        return view('admin.product_specs.list', compact('productspecs'));
    }

    public function create(Request $request)
    {
        $this->validateData($request);
        Products_specs::create([
            'Model' => $request->model,
            'Processor' => $request->processor,
            'Ram' => $request->ram,
            'Graphics_Card' => $request->graphicsCard,
            'System_type' => $request->systemType,
            'Display' => $request->display,
            'Battery' => $request->battery,
            'Pen_and_touch' => $request->penandTouch,
            'Storage' => $request->storage,
            'Warranty' => $request->warranty,
        ]);

       
        ActivityLog::log(
            'Specification Created',
            Auth::user()->name . " created a new product specification profile for '{$request->model}'."
        );

        return back()->with('success', 'Specification created successfully!');
    }

    public function delete($id)
    {
        
        $attachedProducts = \App\Models\Products::where('spec_id', $id)->count();
        if ($attachedProducts > 0) {
            return back()->with('error', "Cannot delete! There are currently {$attachedProducts} product(s) using this specification profile.");
        }

       
        $spec = Products_specs::where('spec_id', $id)->first();
        if ($spec) {
            $modelName = $spec->Model;

          
            $spec->delete();
            ActivityLog::log(
                'Specification Deleted',
                Auth::user()->name . " deleted the product specification profile for '{$modelName}'."
            );
        }

        return back()->with('success', 'Specification deleted successfully!');
    }

    public function edit($id)
    {
        $productspec = Products_specs::where('spec_id', $id)->first();
        return view('admin.product_specs.edit', compact('productspec'));
    }

    public function update($id, Request $request)
    {
        $request['spec_id'] = $id;
        $this->validateData($request);

        Products_specs::where('spec_id', $id)->update([
            'Model' => $request->model,
            'Processor' => $request->processor,
            'Ram' => $request->ram,
            'Graphics_Card' => $request->graphicsCard,
            'System_type' => $request->systemType,
            'Display' => $request->display,
            'Battery' => $request->battery,
            'Pen_and_touch' => $request->penandTouch,
            'Storage' => $request->storage,
            'Warranty' => $request->warranty,
        ]);

        ActivityLog::log(
            'Specification Updated',
            Auth::user()->name . " updated the product specification profile for '{$request->model}'."
        );

        return to_route('productspecs#list')->with('success', 'Specification updated successfully!');
    }

    public function validateData($request)
    {
        $request->validate([
            'model'         => 'required|string|max:255',
            'processor'     => 'required|string|max:255',
            'ram'           => 'required|string|max:255',
            'graphicsCard'  => 'required|string|max:255',
            'systemType'    => 'required|string|max:255',
            'display'       => 'required|string|max:255',
            'battery'       => 'required|string|max:255',
            'penandTouch'   => 'required|string|max:255',
            'storage'       => 'required|string|max:255',
            'warranty'      => 'required|string|max:255',
        ], [
            'model.required'         => 'Model နေရာကို ဖြည့်ရန် လိုအပ်သည်',
            'processor.required'     => 'Processor နေရာကို ဖြည့်ရန် လိုအပ်သည်',
            'ram.required'           => 'RAM နေရာကို ဖြည့်ရန် လိုအပ်သည်',
            'graphicsCard.required'  => 'Graphics နေရာကို ဖြည့်ရန် လိုအပ်သည်',
            'systemType.required'    => 'System type နေရာကို ဖြည့်ရန် လိုအပ်သည်',
            'display.required'       => 'Display နေရာကို ဖြည့်ရန် လိုအပ်သည်',
            'battery.required'       => 'Battery နေရာကို ဖြည့်ရန် လိုအပ်သည်',
            'penandTouch.required'   => 'Pen and touch နေရာကို ဖြည့်ရန် လိုအပ်သည်',
            'storage.required'       => 'Storage နေရာကို ဖြည့်ရန် လိုအပ်သည်',
            'warranty.required'      => 'Warranty နေရာကို ဖြည့်ရန် လိုအပ်သည်',
        ]);
    }
}
