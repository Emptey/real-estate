<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PropertyListing;
use App\PropertyImages;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PropertyListingController extends Controller
{
    // get index page
    public function index(Request $request) {
        // get listed properties in a grouped format
        $chart_property = DB::table('property_listings')
                            ->orderBy('id', 'desc')
                            ->get()
                            ->groupBy(function($val){
                                return Carbon::parse($val->created_at)
                                    ->format('Y-m');
                            });
        $properties = PropertyListing::orderBy('id', 'desc')->limit(7)->get(); // recently listed properties
        $table_properties = PropertyListing::orderBy('id', 'desc')->paginate(10);  // all properties
        return view('v1.admin.authenticated.property.index', ['properties' => $properties, 
            'table_properties' => $table_properties, 'chart_property' => $chart_property]);
    }

    // change property status
    public function changeStatus(Request $request, $id) {
        // decrypt id
        $id = \Crypt::decrypt($id);

        // get property record
        $property = PropertyListing::where('id', $id);

        // check if property exist
        if ($property->count() > 0) {
            // property exist -  check if property is active
            if ($property->pluck('is_active')->first()) {
                // property is enabled - disable property
                $disable_property = [
                    'is_active' => 0,
                ];

                $update_property_record = $property->update($disable_property);  // update property record
                // check if property record was updated
                if ($update_property_record) {
                    // property record update - notify admin
                    $notification = [
                        'message' => 'Property disabled successfully.',
                        'alert-type' => 'success',
                    ];

                    return redirect()
                            ->back()
                            ->with($notification);
                } else {
                    // property record not update - notify admin
                    $notification = [
                        'message' => 'An error has occured, kindly try again.',
                        'alert-type' => 'error',
                    ];

                    return redirect()
                            ->back()
                            ->with($notification);
                }
            } else {
                // property is disabled - enable property
                $enbale_property = [
                    'is_active' => 1,
                ];

                $update_property_record = $property->update($enbale_property);  // update property record
                // check if property record was updated
                if ($update_property_record) {
                    // property record updated - notify admin
                    $notification = [
                        'message' => 'Property enabled successfully.',
                        'alert-type' => 'success',
                    ];

                    return redirect()
                            ->back()
                            ->with($notification);
                } else {
                    // property record not updated - notify admin
                    $notification = [
                        'message' => 'An error has occured, kindly try again.',
                        'alert-type' => 'error',
                    ];

                    return redirect()
                            ->back()
                            ->with($notification);
                }
            }

        } else {
            // property doesn't exit - notify admin
            $notification = [
                'message' => 'Invalid property supplied.',
                'alert-type' => 'error',
            ];

            return redirect()
                    ->back()
                    ->with($notification);
        }
    }

    // view specific property
    public function viewProperty(Request $request, $id) {
        // decrypt property id
        $id = \Crypt::decrypt($id);

        return 'Fuck em all';
    }

    // search property
    public function searchProperty(Request $request) {
        // validation
        $this->validate($request, [
            'search' => 'required|regex:/^[a-zA-Z\s]*$/'
        ]);

        $properties = PropertyListing::orderBy('id', 'desc')->limit(4)->get();  // recently added property
        
        $property = PropertyListing::where('title', 'LIKE', '%'.$request->search.'%')->paginate(10);  // get property record

        // getting chart data
        $chart_property = DB::table('property_listings')
        ->orderBy('id', 'desc')
        ->get()
        ->groupBy(function($val){
            return Carbon::parse($val->created_at)
                ->format('Y-m');
        });

        // check if property exist
        if ($property->count() > 0) {
            // property found - send record to view
            return view('v1.admin.authenticated.property.index', ['table_properties' => $property, 'properties' => $properties, 'chart_property' => $chart_property]);
        } else {
            // property not found - notify admin
            $notification = [
                'message' => 'Property not found.',
                'alert-type' => 'error',
            ];

            return redirect()
                    ->back()
                    ->with($notification);

        }
    }

    // get add property page
    public function add_property(Request $request, $id=null) {
        return view('v1.admin.authenticated.property.add');
    }

    // post first set of property details
    public function set_first_details(Request $request) {
        // validation
        $this->validate($request, [
            'title' => 'required|regex:/^[a-zA-Z\s]*$/',
            'address' => 'required|regex:/^[a-zA-Z\s\0-9]*$/',
            'description' => 'required|regex:/^[a-zA-Z\s]*$/',
            'bedroom' => 'required|numeric',
            'bathroom' => 'required|numeric',
            'toilet' => 'required|numeric',
            'slot' => 'required|numeric',
            'duration' => 'required|numeric',
        ]);

        // add request values to session for retrieval
        $request->session()->put('title', $request->title);  // property title
        $request->session()->put('address', $request->address); // property address
        $request->session()->put('description', $request->description); // property description
        $request->session()->put('bedroom', $request->bedroom);  // property bedroom
        $request->session()->put('bathroom', $request->bathroom);  // property bathroom
        $request->session()->put('toilet', $request->toilet);  // property toilet
        $request->session()->put('slot', $request->slot);  // property investent slots
        $request->session()->put('duration', $request->duration);  // property duration

        return redirect()
                ->route('get-step-two-property');
    }

    // get step 2 of add property page
    public function set_second_details(Request $request, $id=null) {
        // check if user already filled form in page one
        if (empty($request->session()->get('title')) || empty($request->session()->get('description')) || empty($request->session()->get('address')) 
            || empty($request->session()->get('bedroom')) || empty($request->session()->get('bathroom')) || empty($request->session()->get('toilet')) 
            || empty($request->session()->get('slot')) || empty($request->session()->get('duration'))) {
            // user failed to fill form on first page
            return redirect()
                    ->route('get-add-property');
        }
        return view('v1.admin.authenticated.property.step_two_add');
    }

    // post second set of property details
    public function post_second_details(Request $request) {
        // validation
        $this->validate($request, [
            'cost' => 'required|numeric',
            'mgnt_fee' => 'required|numeric',
            'sell_off_price' => 'required|numeric',
            'sell_off_roi' => 'required|numeric',
            'rentage_price' => 'numeric',
            'rentage_roi' => 'numeric',
            'is_rentable' => 'numeric',
        ]);

        // create a new property instance and add a new property listing
        $new_property = new PropertyListing();
        $new_property->title = strtolower($request->session()->get('title'));  // sets property title
        $new_property->description = strtolower($request->session()->get('description'));  // sets property description
        $new_property->address = strtolower($request->session()->get('address'));  // sets property address
        $new_property->bedroom = $request->session()->get('bedroom');  // sets property bedroom
        $new_property->bathroom = $request->session()->get('bathroom');  // sets property bathroom
        $new_property->toilet = $request->session()->get('toilet');  // sets property toilet
        $new_property->slot = $request->session()->get('slot');  // sets property investment slot
        $new_property->duration = $request->session()->get('duration');  // sets property investment duration
        $new_property->purchase_amount = $request->cost;  // sets property purchase cost
        $new_property->mngt_fee = $request->mgnt_fee;  // sets property management fee
        $new_property->sell_off_price = $request->sell_off_price;  // sets property sell off price
        $new_property->sell_off_profit_percent = $request->sell_off_roi;  // sets property sell of roi percentage
        $new_property->rentage_price = $request->rentage_price;  // sets property rentage price
        $new_property->rentage_profit_percent = $request->rentage_roi;  // sets property rentage
        $new_property->is_rentable = (!empty($request->is_rentable) ? 1 : 0);  // sets property rentage feature

        // save property
        $save_property = $new_property->save();

        // check if property record was saved
        if ($save_property) {
            // property saved successfully - delete session data
            $request->session()->forget('title');
            $request->session()->forget('description');
            $request->session()->forget('address');
            $request->session()->forget('bedroom');
            $request->session()->forget('bathroom');
            $request->session()->forget('toilet');
            $request->session()->forget('slot');
            $request->session()->forget('duration');

            $request->session()->put('add.property', $new_property->id);  // setup added property id for thumbnail upload

            // redirect user to property thumbnail upload page
            return redirect()
                      ->route('get-step-three-property');


        } else {
            // property not saved - notify admin
            $notification = [
                'message' => 'An error has occured, kindly try again.',
                'alert-type' => 'error',
            ];

            return redirect()
                    ->back()
                    ->with($notification);
        }
    }

    // get step 3 of add property page
    public function set_third_details(Request $request, $id=null) {
        // check if user filled form in step 1 and 2 of property listing
        if (empty($request->session()->get('add.property')) ) {
            // user didn't fill forms in step 1 and 2 - redirect user to step 1
            return redirect()
                    ->route('get-add-property');
        }
        return view('v1.admin.authenticated.property.step_three_add');
    }

    // post step 3 of add property page
    public function post_third_details(Request $request) {
        // validation
        $this->validate($request, [
            'front_view' => 'required|mimes:png,jpg,jpeg',
            'side_view'  => 'required|mimes:png,jpg,jpeg',
            'back_view'  => 'required|mimes:png,jpg,jpeg',
        ]);

        // save property images to property listing image table
        $new_property_images = new PropertyImages();  // create new propertyimages instace
        
        $new_property_images->property_listing_id = $request->session()->get('add.property');  // sets property listing id
        $new_property_images->front_view = $request->front_view->hashName();  // sets property listing front view image
        $new_property_images->side_view = $request->side_view->hashName();  // sets property listing side view image
        $new_property_images->back_view = $request->back_view->hashName();  // sets property listing side view image

        // move images to local storage
        $store_front_view = $request->file('front_view')->store('public/images');  // move front view image to local storage
        $store_side_view  = $request->file('side_view')->store('public/images');  // move side view image to local storage
        $store_back_view  = $request->file('back_view')->store('public/images');  // moves back view image to local storage

        // check if images were moved to local storage
        if (!is_null($store_front_view) || !is_null($store_side_view) || !is_null($store_back_view)) {
            // images moved to local storage - save images to database
            $save_property_images = $new_property_images->save();  // save property images to db

            // check if images were saved to db
            if ($save_property_images) {
                // images saved to db - delete session value for add.property - notify user
                $request->session()->forget('add.property');  // delete session
                $notification = [
                    'message' => 'Property listed successfully.',
                    'alert-type' => 'success',
                ];

                return redirect()
                        ->route('get-property-listing')
                        ->with($notification);

            } else {
                // images not saved to db - notify admin
                $notification = [
                    'message' => 'An error occured while saving property, kindly try again.',
                    'alert-type' => 'error',
                ];

                return redirect()
                        ->back()
                        ->with($notification);
            }
        } else {
            // images not moved to local storage - notify admin
            $notification = [
                'message' => 'An error has occured, kindly try again.',
                'alert-type' => 'error',
            ];

            return redirect()
                    ->back()
                    ->with($notification);
        }

    }

}
