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

        // get property from db
        $property = PropertyListing::find($id);

        // check if property exist
        if ($property->count() > 0) {
            // property exist - return view with property
            return view('v1.admin.authenticated.property.view', ['property' => $property]);

        } else {
            // property doesn't exist - notify admin
            $notification = [
                'message' => 'Property not found.',
                'alert-type' => 'error',
            ];

            return redirect()
                    ->back()
                    ->with($notification);
        }

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
            'description' => 'required|regex:/^[a-zA-Z\s\.,]*$/',
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

    // get update property page 1
    public function update_property_step_one(Request $request, $id) {
        try {
            // decrypt id
            $id = \Crypt::decrypt($id);

            $property = PropertyListing::where('id', $id)->get();  // get property record

            // check if property exist
            if ($property->count() > 0) {
                // property found - put property in session - return view
                $request->session()->put('property.record', $property);
                return view('v1.admin.authenticated.property.update', ['property' => $property]);
            } else {
                // property not found
                $notification = [
                    'message' => 'property not found.',
                    'alert-type' => 'error',
                ];

                return redirect()
                        ->back()
                        ->with($notification);
            }

        } catch(Illuminate\Contracts\Encryption\DecryptException $e) {
            // payload error caught
            return redirect()
                    ->back()
                    ->with(
                        [
                            'message' => 'Property not found.',
                            'alert-type' => 'danger',
                        ]
                    );
        }
    }

    // post update property page 1
    public function post_update_property_step_one(Request $request){
        // validation
        $this->validate($request, [
            'id' => 'required|numeric',
            'title' => 'required|regex:/^[a-zA-Z\s]*$/',
            'address' => 'required|regex:/^[a-zA-Z\s\0-9]*$/',
            'description' => 'required|regex:/^[a-zA-Z\s\.,]*$/',
            'bedroom' => 'required|numeric',
            'bathroom' => 'required|numeric',
            'toilet' => 'required|numeric',
            'slot' => 'required|numeric',
            'duration' => 'required|numeric',
        ]);

        // get property record
        $property = PropertyListing::where('id', $request->id);

        // check if property record was found
        if ($property->count() > 0) {
            // property record found - assign values to session - send user to step 2
            $request->session()->put('id', $request->id);
            $request->session()->put('title', $request->title);
            $request->session()->put('address', $request->address);
            $request->session()->put('description', $request->description);
            $request->session()->put('bedroom', $request->bedroom);
            $request->session()->put('bathroom', $request->bathroom);
            $request->session()->put('toilet', $request->toilet);
            $request->session()->put('slot', $request->slot);
            $request->session()->put('duration', $request->duration);

            // redirect user to page fa-rotate-270
            return redirect()
                    ->route('get-update-property-step-two', \Crypt::encrypt($property->pluck('id')->first()));
            
        } else {
            // property record not found
        }
    }

    // get update property page 2
    public function get_update_property_step_two(Request $request, $id=null) {
        // check if page 1 was filled out
        if (!empty($request->session()->get('id'))) {
            try {
                // decrypt id
                $id = \Crypt::decrypt($id);

                // get property record
                $property = PropertyListing::where('id', $id)->get();

                // check if property record was found
                if ($property->count() > 0) {
                    // property found - return page 2 view
                    return view('v1.admin.authenticated.property.update_step_two', ['property' => $property]);
                } else {
                    // property not found - redirect user to previous page
                    return redirect()
                            ->back();
                }
            } catch (\Throwable $th) {
                // invalid payload provided
                return redirect()
                        ->back()
                        ->with([
                            'message' => 'Property not found.',
                            'alert-type' => 'error',
                        ]);
            }

        } else {
            // page 1 form not filled - redirect user to previous page
            return redirect()
                    ->back();
        }
    }

    // post update property page 2
    public function post_update_property_step_two(Request $request) {
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

        // saved entered form values in session
        $request->session()->put('cost', $request->cost);
        $request->session()->put('mngt_fee', $request->mgnt_fee);
        $request->session()->put('sell_off_price', $request->sell_off_price);
        $request->session()->put('sell_off_roi', $request->sell_off_roi);
        $request->session()->put('rentage_price', $request->rentage_price);
        $request->session()->put('rentage_roi', $request->rentage_roi);
        $request->session()->put('is_rentable', $request->is_rentable);

        // return user to page 3 view
        return redirect()
                ->route('get-update-property-step-three', \Crypt::encrypt($request->session()->get('id')));
    }

    // get update property page 3
    public function get_update_property_step_three(Request $request, $id=null) {
        // check if user had filled forms in page 1 and page 2
        if (!empty($request->session()->get('id')) || !empty($request->session()->get('cost'))) {
            // user filled forms in page 1 and page 2 - decrypt id
            try {
                // decrypt id
                $id = \Crypt::decrypt($id);

                // get property record
                $property = PropertyListing::find($id);

                // check if property was found
                if ($property->count() > 0) {
                    // property record found
                    return view('v1.admin.authenticated.property.update_step_three', ['property' => $property]);
                } else {
                    // property not found -  reidrect user to previous page
                    return redirect()
                            ->back();
                }

            } catch (\Throwable $th) {
                // invalid payload provided
                return redirect()
                        ->back();
            }
        } else {
            // user didn't fill forms in page 1 and page 2 - return user to previous page
            return redirect()
                    ->back();
        }
    }

    // post update property page 3
    public function post_update_property_step_three(Request $request) {
        // validation
        $this->validate($request, [
            'front_view' => 'required|mimes:png,jpg,jpeg',
            'side_view'  => 'required|mimes:png,jpg,jpeg',
            'back_view'  => 'required|mimes:png,jpg,jpeg',
        ]);

        // get property record
        $property = PropertyListing::where('id', $request->session()->get('id'));
        
        // check if property exit
        if ($property->count() > 0) {
            // property record found
            $new_property_record = [
                'title' => strtolower($request->session()->get('title')),
                'description' => strtolower($request->session()->get('description')),
                'address' => strtolower($request->session()->get('address')),
                'bedroom' => $request->session()->get('bedroom'),
                'bathroom' => $request->session()->get('bathroom'),
                'toilet' => $request->session()->get('toilet'),
                'slot' => $request->session()->get('slot'),
                'duration' => $request->session()->get('duration'),
                'purchase_amount' => $request->session()->get('cost'),
                'mngt_fee' => $request->session()->get('mngt_fee'),
                'sell_off_price' => $request->session()->get('sell_off_price'),
                'sell_off_profit_percent' => $request->session()->get('sell_off_roi'),
                'rentage_price' => $request->session()->get('rentage_price'),
                'rentage_profit_percent' => $request->session()->get('rentage_roi'),
                'is_rentable' => $request->session()->get('is_rentable'),
            ];

            // update property record
            $update_property_record = $property->update($new_property_record);

            // check if property record was updated
            if ($update_property_record) {
                // property record updated - update property listing image table
                $property_image_listing = PropertyImages::where('property_listing_id', $request->session()->get('id'));

                $new_property_images = [
                    'front_view' => $request->front_view->hashName(),
                    'side_view' => $request->side_view->hashName(),
                    'back_view' => $request->back_view->hashName(),
                ];

                $move_front_image = $request->file('front_view')->store('public/images');
                $move_side_image = $request->file('side_view')->store('public/images');
                $move_back_image = $request->file('back_view')->store('public/images');

                // check if images were moved to local storage
                if (!is_null($move_front_image) || !is_null($move_side_image) || !is_null($move_back_image)) {
                    // images moved to local storage update db record - notify admin
                    $update_property_image = $property_image_listing->update($new_property_images);

                    // check if property images were updated
                    if ($update_property_image) {
                        // property image listing record updated - notify admin
                        $notification = [
                            'message' => 'Property successfully updated.',
                            'alert-type' => 'success',
                        ];

                        // get updated property record id
                        $property_id = $request->session()->get('id');

                        // delete session data
                        $request->session()->forget('id');
                        $request->session()->forget('title');
                        $request->session()->forget('address');
                        $request->session()->forget('description');
                        $request->session()->forget('bedroom');
                        $request->session()->forget('bathroom');
                        $request->session()->forget('toilet');
                        $request->session()->forget('slot');
                        $request->session()->forget('duration');
                        $request->session()->forget('cost');
                        $request->session()->forget('mngt_fee');
                        $request->session()->forget('sell_off_price');
                        $request->session()->forget('sell_off_roi');
                        $request->session()->forget('rentage_price');
                        $request->session()->forget('rentage_roi');
                        $request->session()->forget('is_rentable');

                        // redirect user to view property page
                        return redirect()
                                ->route('view-property', \Crypt::encrypt($property_id))
                                ->with($notification);
                    } else {
                        // property image listing record not updated - notify admin
                        $notification = [
                            'message' => 'Record not updated, kindly upload images again.',
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
            } else {
                // property record not updated - notify admin
                $notification = [
                    'message' => 'Update failed, kindly try again.',
                    'alert-type' => 'error',
                ];

                return redirect()
                        ->back()
                        ->with($notification);
            }
        } else {
            // property not found.
            return redirect()
                    ->back();
        }
    }

}
