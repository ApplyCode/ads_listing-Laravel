<?php

namespace Modules\CustomField\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\Category\Entities\Category;
use Modules\CustomField\Entities\CustomField;
use Modules\CustomField\Entities\CustomFieldGroup;
use Modules\CustomField\Entities\CustomFieldValue;

class CustomFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $fields_query = CustomField::query()
                ->with('customFieldGroup:id,name', 'values:id,custom_field_id,value')
                ->oldest('order');

            if ($request->has('category') && $request->category != 'all') {
                $fields_query->whereHas('categories', function ($q) use ($request) {
                    $q->where('category_id', $request->category);
                });
            }

            if ($request->has('group') && $request->group != 'all') {
                $fields_query->where('custom_field_group_id', $request->group);
            }

            $groups = CustomFieldGroup::latest()->get();
            $categories = Category::active()->get();
            $fields = $fields_query->get();

            return view('customfield::index', compact('fields', 'groups', 'categories'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        try {
            $categories = Category::active()
                ->latest()
                ->get();
            $groups = CustomFieldGroup::latest()->get(['id', 'name']);

            return view('customfield::create', compact('categories', 'groups'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Show the specified resource.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('customfield::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function edit(CustomField $custom_field)
    {
        try {
            $custom_field->load('categories', 'values:id,custom_field_id,value');
            $categories = Category::active()
                ->latest()
                ->get();
            $groups = CustomFieldGroup::latest()->get(['id', 'name']);

            return view('customfield::edit', compact('categories', 'custom_field', 'groups'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2',
            'type' => 'required',
            'group' => 'required',
            'icon' => 'required',
            'categories.*' => 'required',
        ]);
        try {
            if ($request->type == 'select' || $request->type == 'radio' || $request->type == 'checkbox_multiple') {
                $request->validate([
                    'values' => 'required',
                ]);
            } elseif ($request->type == 'checkbox') {
                $request->validate([
                    'value' => 'required',
                ]);
            }

            $custom_field = CustomField::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'type' => $request->type,
                'required' => $request->required ? true : false,
                'filterable' => $request->filterable ? true : false,
                'listable' => $request->listable ? true : false,
                'custom_field_group_id' => $request->group,
                'icon' => $request->icon,
            ]);

            if ($request->categories) {
                $custom_field->categories()->attach($request->categories);
            }

            if ($request->type == 'select' || $request->type == 'radio' || $request->type == 'checkbox_multiple') {
                foreach ($request->values as $value) {
                    $custom_field->values()->create([
                        'value' => $value,
                    ]);
                }
            } elseif ($request->type == 'checkbox') {
                $custom_field->values()->create(['value' => $request->value]);
            }

            flashSuccess('Custom Field Created Successfully !');

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function update(Request $request, CustomField $custom_field)
    {
        $request->validate([
            'name' => 'required|min:2',
            'type' => 'required',
            'group' => 'required',
            'icon' => 'required',
            'categories.*' => 'required',
        ]);
        try {
            if ($request->type == 'select' || $request->type == 'radio' || $request->type == 'checkbox_multiple') {
                $request->validate([
                    'values' => 'required',
                ]);
            } elseif ($request->type == 'checkbox') {
                $request->validate([
                    'value' => 'required',
                ]);
            }

            $custom_field->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'type' => $request->type,
                'required' => $request->required ? true : false,
                'filterable' => $request->filterable ? true : false,
                'listable' => $request->listable ? true : false,
                'custom_field_group_id' => $request->group,
                'icon' => $request->icon,
            ]);

            if ($request->categories) {
                $custom_field->categories()->sync($request->categories);
            }

            if ($request->type == 'select' || $request->type == 'radio' || $request->type == 'checkbox_multiple') {
                $custom_field->values()->delete();
                foreach ($request->values as $value) {
                    $custom_field->values()->create([
                        'value' => $value,
                    ]);
                }
            } elseif ($request->type == 'checkbox') {
                $custom_field->values()->delete();
                $custom_field->values()->create(['value' => $request->value]);
            } else {
                $custom_field->values()->delete();
            }

            flashSuccess('Custom Field Updated Successfully !');

            return redirect()->route('module.custom.field.index');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function destroy(CustomField $custom_field)
    {
        try {
            $custom_field->delete();
            flashSuccess('Custom Field Deleted');

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function sorting(Request $request)
    {
        try {
            $fields = CustomField::all();

            foreach ($fields as $field) {
                $field->timestamps = false;
                $id = $field->id;

                foreach ($request->order as $order) {
                    if ($order['id'] == $id) {
                        $field->update(['order' => $order['position']]);
                    }
                }
            }

            return response()->json(['message' => 'Custom Field Sorted Successfully!']);
        } catch (\Throwable $th) {
            flashError();

            return back();
        }
    }

    public function addValue(CustomField $field)
    {
        try {
            $fields = CustomField::with('customFieldGroup:id,name')
                ->latest()
                ->withCount('values')
                ->get()
                ->groupBy('custom_field_group_id');
            $values = $field->values;

            return view('customfield::index', compact('fields', 'field', 'values'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function storeValue(Request $request, CustomField $field)
    {
        $request->validate([
            'option_name' => 'required',
        ]);
        try {
            $field->values()->create([
                'value' => Str::ucfirst($request->option_name),
            ]);

            flashSuccess('Field value added !');

            return redirect()->back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function editValue(CustomFieldValue $value)
    {
        try {
            $fields = CustomField::with('customFieldGroup:id,name')
                ->latest()
                ->withCount('values')
                ->get()
                ->groupBy('custom_field_group_id');
            $field = $value->field;
            $values = $field->values;

            return view('customfield::index', compact('fields', 'value', 'values', 'field'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function updateValue(Request $request, CustomFieldValue $value)
    {
        try {
            $value->update([
                'value' => $request->option_name,
            ]);

            flashSuccess('Value edited !');

            return redirect()->back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function destroyValue(CustomFieldValue $value)
    {
        try {
            $value->delete();

            return redirect()->back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function StoreCategories(Request $request, CustomField $field)
    {
        try {
            $field->categories()->sync($request->categories);
            flashSuccess('Custom field attached to categories !');

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }
}
