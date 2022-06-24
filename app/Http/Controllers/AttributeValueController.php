<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\AttributeValueTranslation;
use CoreComponentRepository;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$attribute_value                = new AttributeValue;
		$attribute_value->attribute_id  = $request->attribute_id;
		$attribute_value->name          = $request->name;
		$attribute_value->save();

		$attribute_value_translation = AttributeValueTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'attribute_value_id' => $attribute_value->id]);
		$attribute_value_translation->name = $request->name;
		$attribute_value_translation->save();

		flash(translate('Attribute value has been added successfully'))->success();
		return back();
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit(Request $request, $id)
     {
		$lang              = $request->lang;
		$attributes        = Attribute::all();
		$attribute_value  = AttributeValue::findOrFail($id);
		return view('backend.product.attribute.attribute_values.edit', compact('attributes','attribute_value','lang'));
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
		$attribute_value = AttributeValue::findOrFail($id);
		if($request->lang == env("DEFAULT_LANGUAGE")){
			$attribute_value->name = $request->name;
		}
		$attribute_value->save();

		$attribute_value_translation = AttributeValueTranslation::firstOrNew(['lang' => $request->lang, 'attribute_value_id' => $attribute_value->id]);
		$attribute_value_translation->name = $request->name;
		$attribute_value_translation->save();

		flash(translate('Attribute Value has been updated successfully'))->success();
		return back();
    }

}
