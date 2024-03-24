<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreContactUsRequest;
use App\Models\ContactUs;
use Illuminate\Http\Response;

class ContactUsApiController extends Controller
{
    public function store(StoreContactUsRequest $request)
    {
        $contactUs = ContactUs::create($request->validated());

        return response()->json($contactUs, Response::HTTP_CREATED);
    }
}
