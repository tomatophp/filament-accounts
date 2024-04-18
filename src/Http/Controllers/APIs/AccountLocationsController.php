<?php

namespace TomatoPHP\FilamentAccounts\Http\Controllers\APIs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use TomatoPHP\FilamentAccounts\Helpers\Response;
use TomatoPHP\FilamentLocations\Models\Location;

class AccountLocationsController extends Controller
{
   public function index(Request $request)
   {
       $query = Location::query();
       $query->where('model_id',$request->user()->id);
       $query->where('model_type',config('filament-accounts.model'));

       if($request->has('search')){
           $query->where('street','like','%'.$request->get('search').'%');
       }

       if($request->has('main')){
              $query->where('is_main', 1);
       }

       return Response::data($query->paginate(10), 'Locations Loaded Successfully');
   }

   public function store(Request $request)
   {
       $request->validate([
            'street' => 'required|max:255|string',
            'area_id' => 'nullable|max:255|string|exists:areas,id',
            'city_id' => 'nullable|max:255|string|exists:cities,id',
            'country_id' => 'nullable|max:255|string|exists:countries,id',
            'home_number' => 'nullable',
            'flat_number' => 'nullable',
            'floor_number' => 'nullable',
            'mark' => 'nullable|max:255|string',
            'map_url' => 'nullable|max:65535',
            'note' => 'nullable|max:255|string',
            'lat' => 'nullable|max:255|string',
            'lng' => 'nullable|max:255|string',
            'zip' => 'nullable|max:255|string'
       ]);

       $request->merge([
          'model_id' => $request->user()->id,
          'model_type' => config('filament-accounts.model')
       ]);

       $location = Location::query()->create($request->all());

       return Response::data($location, 'Location Created Successfully');
   }

   public function show(Location $location, Request $request)
   {
       if($location->model_id === $request->user()->id && $location->model_type === config('filament-accounts.model')) {
           return Response::data($location, 'Location Loaded Successfully');
       }

       return Response::errors('Sorry You do not have access to this location', null, 403);
   }

   public function update(Location $location, Request $request)
   {
       if($location->model_id === $request->user()->id && $location->model_type === config('filament-accounts.model')) {
           $request->validate([
               'street' => 'sometimes|max:255|string',
               'area_id' => 'nullable|max:255|string|exists:areas,id',
               'city_id' => 'nullable|max:255|string|exists:cities,id',
               'country_id' => 'nullable|max:255|string|exists:countries,id',
               'home_number' => 'nullable',
               'flat_number' => 'nullable',
               'floor_number' => 'nullable',
               'mark' => 'nullable|max:255|string',
               'map_url' => 'nullable|max:65535',
               'note' => 'nullable|max:255|string',
               'lat' => 'nullable|max:255|string',
               'lng' => 'nullable|max:255|string',
               'zip' => 'nullable|max:255|string'
           ]);

           $location->update($request->all());

           return Response::data($location, 'Location Loaded Successfully');
       }

       return Response::errors('Sorry You do not have access to this location', null, 403);
   }

   public function destroy(Location $location, Request $request)
   {
       if($location->model_id === $request->user()->id && $location->model_type === config('filament-accounts.model')) {
            $location->delete();
            return Response::success('Location Deleted Successfully');
       }

      return Response::errors('Sorry You do not have access to this location', null, 403);
   }
}
