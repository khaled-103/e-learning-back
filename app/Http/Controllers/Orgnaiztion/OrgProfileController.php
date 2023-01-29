<?php

namespace App\Http\Controllers\Orgnaiztion;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Orgnaization;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Nette\Utils\Json;

class OrgProfileController extends Controller
{
    use GeneralTrait;
    public function getCountries()
    {
        $countries = Country::select(['id', 'name'])->get();
        return $this->returnData('countries', $countries, 'get countries success');
    }
    public function getProfileImage(Request $request)
    {
        $orgProfileInfo = Orgnaization::where('id', $request->id)
            ->select('image')
            ->first();
        return $this->returnData('orgProfileInfo', $orgProfileInfo, 'get orgProfile Image success');
    }
    public function getProfileInfo(Request $request)
    {
        $orgProfileInfo = Orgnaization::where('id', $request->token['tokenable_id'])
            ->select('name', 'id', 'phone', 'email', 'username', 'country_id', 'image', 'description')
            ->first();
        return $this->returnData('orgProfileInfo', $orgProfileInfo, 'get orgProfileInfo success');
    }
    public function changeBasicInfo(Request $request)
    {

        $Validator = Validator::make($request->all(), [
            'name' => [
                'required', 'string', 'min:2', 'max:50', Rule::unique('orgnaizations', 'name')->ignore($request->token['tokenable_id'])
            ],
            'username' => ['required', 'string', Rule::unique('orgnaizations', 'username')->ignore($request->token['tokenable_id']), 'min:5', 'max:50'],
            'phone' => ['required', 'numeric'],
            'country_id' => ['nullable', 'exists:countries,id']
        ]);
        if ($Validator->fails()) {
            return $this->returnValidationError('validation error occur', $Validator->errors(), 422);
        }
        $orgnaization = Orgnaization::where('id', $request->token['tokenable_id'])->first();
        $res = $orgnaization->update([
            'name' => $request->name,
            'username' => $request->username,
            'phone' => $request->phone,
            'country_id' => $request->country_id
        ]);
        if ($res)
            return $this->returnSuccessMessage("update info success");
        return $this->returnError(429, "something error occur");
    }
    public function profileChangePassword(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'password' => 'required',
            'newPassword' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($Validator->fails()) {
            return $this->returnValidationError('validation error occur', $Validator->errors(), 422);
        }
        $orgnaization = Orgnaization::where('id', $request->token['tokenable_id'])->first();
        if (Hash::check($request->password, $orgnaization->password)) {
            $res = $orgnaization->update([
                'password' => Hash::make($request->newPassword),
            ]);
            if ($res)
                return $this->returnSuccessMessage('change password successfully');
            return $this->returnError(429, "something error occur");
        } else {
            return $this->returnValidationError('validation error occur', ['password' => ['Not correct password']], 422);
        }
    }

    public function saveAdditionalInfoChanges(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'description' => 'required|min:30',
            'image' => 'nullable|image',
        ]);
        if ($Validator->fails()) {
            return $this->returnValidationError('validation error occur', $Validator->errors(), 422);
        }
        $orgnaization = Orgnaization::where('id', json_decode($request->token)->tokenable_id)->first();
        $image_path = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {
                if ($orgnaization->image != 'avatar.jpg')
                    Storage::disk('uploads')->delete('/' . $orgnaization->image);
                $image_path = $file->store('/', [
                    'disk' => 'uploads'
                ]);
            }
        }
        if ($orgnaization) {
            $orgnaization->update([
                'description' => $request->description,
                'image' => $image_path ?? $orgnaization->image
            ]);
        }

        return $this->returnSuccessMessage('update profile done');
    }
    public function addNewCategory(Request $request)
    {

        $res = DB::table('orgnaization_categories')
            ->where('orgnaization_id', $request->token['tokenable_id'])
            ->where('categories_id', $request->id)
            ->first();
        if (!$res) {
            DB::table('orgnaization_categories')->insert([
                'orgnaization_id' => $request->token['tokenable_id'],
                'categories_id' => $request->id
            ]);
        }
        return $this->returnSuccessMessage('insert done');
    }
    public function deleteCategory(Request $request)
    {
         DB::table('orgnaization_categories')
            ->where('orgnaization_id', $request->token['tokenable_id'])
            ->where('categories_id', $request->id)
            ->delete();
        return $this->returnSuccessMessage('delete done');
    }
}
