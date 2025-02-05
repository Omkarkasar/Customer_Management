<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function customerstore(Request $request)
    {
        $data = new Customer();
        $data->customername = $request->customername;
        $data->customerage = $request->customerage;
        $data->customerbmi = $request->customerbmi;
        $data->customercode = $request->customercode;
        $data->customerdate = $request->customerdate;
        $data->gender = $request->gender;
        $data->membership = $request->membership;
        $data->permission = $request->permission ? 'allowed' : 'not allowed';

        if ($request->hasFile('profilepic')) {
            $file = $request->file('profilepic');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $data->profilepic = $filename;
        }

        $data->save();
        return response()->json(['success' => 'Customer Data Added Successfully']);
    }

    public function customerget()
    {
        $data = Customer::all();
        return response()->json($data);
    }

    public function customeredit($id)
    {
        $data = Customer::findOrFail($id);
        return response()->json($data);
    }

    public function customerupdate(Request $request, $id)
    {
        $data = Customer::findOrFail($id);
        $data->customername = $request->customername;
        $data->customerage = $request->customerage;
        $data->customerbmi = $request->customerbmi;
        $data->customercode = $request->customercode;
        $data->customerdate = $request->customerdate;
        $data->gender = $request->gender;
        $data->membership = $request->membership;
        $data->permission = $request->permission ? 'allowed' : 'not allowed';

        if ($request->hasFile('profilepic')) {
            $file = $request->file('profilepic');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $data->profilepic = $filename;
        }

        $data->save();
        return response()->json(['success' => 'Customer Data Updated Successfully']);
    }

    public function customerdelete($id)
    {
        $data = Customer::findOrFail($id);
        $data->delete();
        return response()->json(['success' => 'Customer Data is deleted']);
    }

}