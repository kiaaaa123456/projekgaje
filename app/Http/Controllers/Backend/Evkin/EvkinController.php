<?php

namespace App\Http\Controllers\Backend\Evkin;

use App\Models\Award\Award;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Award\AwardService;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\StoreAwardRequest;
use App\Http\Requests\UpdateAwardRequest;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;

class EvkinController extends Controller
{
    use ApiReturnFormatTrait;

    protected $awardService;

    public function __construct(AwardService $awardService)
    {
        $this->awardService = $awardService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $data['fields']    = $this->awardService->fields();
            $data['checkbox'] = true;

            $data['title']     = _trans('award.Award List');
            $data['table']     = route('award.table');
            $data['url_id']    = 'award_table_url';
            $data['class']     = 'award_table_class';
            return view('backend.evkin.index', compact('data'));
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    public function fasilitator(Request $request)
    {
        try {
            $data['fields']    = $this->awardService->fields();
            $data['checkbox'] = true;

            $data['title']     = _trans('award.Award List');
            $data['table']     = route('award.table');
            $data['url_id']    = 'award_table_url';
            $data['class']     = 'award_table_class';
            return view('backend.evkin.fasilitator', compact('data'));
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    public function penilaian(Request $request)
    {
        try {
            $data['fields']    = $this->awardService->fields();
            $data['checkbox'] = true;

            $data['title']     = _trans('award.Award List');
            $data['table']     = route('award.table');
            $data['url_id']    = 'award_table_url';
            $data['class']     = 'award_table_class';
            return view('backend.evkin.penilaian', compact('data'));
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    public function detail_evkin(Request $request)
    {
        try {
            $data['fields']    = $this->awardService->fields();
            $data['checkbox'] = true;

            $data['title']     = _trans('award.Award List');
            $data['table']     = route('award.table');
            $data['url_id']    = 'award_table_url';
            $data['class']     = 'award_table_class';
            return view('backend.evkin.detail_evkin', compact('data'));
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }



}
