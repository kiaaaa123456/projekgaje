<?php

namespace App\Http\Controllers\Api\Visit;

use Validator;
use Carbon\Carbon;
use App\Models\Visit\Visit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Http\Resources\Hrm\VisitCollection;
use App\Repositories\Hrm\Visit\VisitRepository;
use App\Http\Resources\Hrm\VisitImageCollection;
use App\Http\Resources\Hrm\VisitHistoryCollection;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Repositories\Hrm\Visit\VisitScheduleRepository;
class VisitController extends Controller
{
    use ApiReturnFormatTrait, DateHandler;

    protected $visit;
    protected $visitSchedule;

    public function __construct(VisitRepository $visit,VisitScheduleRepository $visitSchedule)
    {
        $this->visit = $visit;
        $this->visitSchedule = $visitSchedule;
    }

    public function getVisitList()
    {
        try {
            $visit_list= $this->visit->getList();
            return $this->responseWithSuccess('Visit List Loaded', $visit_list, 200);
        } catch (\Exception $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }
    public function getEvkinList()
    {
        try {
            $visit_list= $this->visit->getListEvkin();
            if(count($visit_list) == 0){
                return $this->responseWithSuccess('Visit List Loaded', [], 200);

            }else{

                return $this->responseWithSuccess('Visit List Loaded', $visit_list, 200);
            }
        } catch (\Exception $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }
     public function eksportAktivitasApi($id)
        {
            $user = User::where('id',$id)->first();
           
            if($user) {

                $id_user = $user->id;
                $nama = $user->name;
                $id_dep = $user->department_id;
                $kdprov = $user->kdprov;
                $kdkab = $user->kdkab;
                $kdkec = $user->kdkec;
                $kddesa = $user->kddesa;

                $data  = DB::select( DB::raw("SELECT * FROM daily_activity WHERE created_by = '$id_user' ORDER BY id DESC"));
                $department  = DB::select( DB::raw("SELECT title FROM departments WHERE id = '$id_dep'"))['0']->title;
                $nmprov  = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov = '$kdprov'"))['0']->nmprov;
                $nmkab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab = '$kdkab'"))['0']->nmkab;
                $nmkec  = DB::select( DB::raw("SELECT nmkec FROM wilayah_kecamatan WHERE kdkec = '$kdkec'"))['0']->nmkec;
                $nmdesa  = DB::select( DB::raw("SELECT nmdesa FROM wilayah_desa WHERE kddesa = '$kddesa'"))['0']->nmdesa;
                
                return view('drp.fasilitator.eksport-aktivitas-harian', compact('data', 'department', 'nama', 'nmprov', 'nmkab', 'id_dep', 'nmkec', 'nmdesa'));
                
            } else {
               
                return $this->responseWithError($exception->getMessage(), [], 500);
            }
            
        }
    public function downloadFormat($id){
      
        try {
            $getUser = User::where('id',$id)->first();
            $getDepartement = DB::table('departments')->where('id',$getUser->department_id)->get();
            foreach ($getDepartement as $item) {
            switch ($item->title) {
                case 'KORKAB':
                                    // Redirect to link1
                                    return redirect()->away('https://tekad.kemendesa.go.id/e-lapkin/download/laporan_bulanan_korkab.xlsx');
                                    break;
                case 'FASKAB':
                                    // Redirect to link2
                                    return redirect()->away('https://tekad.kemendesa.go.id/e-lapkin/download/laporan_bulanan_faskab.xlsx');
                                    break;
                case 'FK-FASDIS':
                                    // Redirect to link2
                                    return redirect()->away('https://tekad.kemendesa.go.id/e-lapkin/download/laporan_bulanan_fasdis.xlsx');
                                    break;
                case 'KADER':
                                    // Redirect to link2
                                    return redirect()->away('https://tekad.kemendesa.go.id/e-lapkin/download/laporan_bulanan_kader.xlsx');
                                    break;
                case 'GUEST':
                                    // Redirect to link2
                                    return redirect()->away('https://tekad.kemendesa.go.id/e-lapkin/download/laporan_bulanan_faskab.xlsx');
                                    break;
                case 'NPMU-PM':
                                    // Redirect to link2
                                    return redirect()->away('https://tekad.kemendesa.go.id/e-lapkin/download/laporan_bulanan_faskab.xlsx');
                                    break;
                case 'NPMU-PIC':
                                    // Redirect to link2
                                    return redirect()->away('https://tekad.kemendesa.go.id/e-lapkin/download/laporan_bulanan_faskab.xlsx');
                                    break;
                case 'NPMU-KORWIL':
                                    // Redirect to link2
                                    return redirect()->away('https://tekad.kemendesa.go.id/e-lapkin/download/laporan_bulanan_faskab.xlsx');
                                    break;
                case 'NPMU-SEKRE':
                                    // Redirect to link2
                                    return redirect()->away('https://tekad.kemendesa.go.id/e-lapkin/download/laporan_bulanan_faskab.xlsx');
                                    break;
                case 'NPMU-OFFICER':
                                    // Redirect to link2
                                    return redirect()->away('https://tekad.kemendesa.go.id/e-lapkin/download/laporan_bulanan_faskab.xlsx');
                                    break;
                case 'NPMU-TA':
                                    // Redirect to link2
                                    return redirect()->away('https://tekad.kemendesa.go.id/e-lapkin/download/laporan_bulanan_faskab.xlsx');
                                    break;
                case 'TPK-PROV':
                                    // Redirect to link2
                                    return redirect()->away('https://tekad.kemendesa.go.id/e-lapkin/download/laporan_bulanan_faskab.xlsx');
                                    break;
                case 'TPK-TAPROV':
                                    // Redirect to link2
                                    return redirect()->away('https://tekad.kemendesa.go.id/e-lapkin/download/laporan_bulanan_faskab.xlsx');
                                    break;
                 case 'TPK-KAB':
                                    // Redirect to link2
                                    return redirect()->away('https://tekad.kemendesa.go.id/e-lapkin/download/laporan_bulanan_faskab.xlsx');
                                    break;
                // Add more cases as needed
                default:
                    // Default redirection if none of the conditions match
                    return redirect()->away('https://tekad.kemendesa.go.id/e-lapkin/download/laporan_bulanan_fasdis.xlsx');
                }
        }
        } catch (\Exception $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }
    public function getVisitHistory(Request $request)
    {
        $visit_history = [];
        try {
            $visit_history= $this->visit->getVisitHistoryList($request);
            if($visit_history == null){
                $visit_history['history']=[];
                return $this->responseWithSuccess('No Visit History Found', $visit_history, 200);
            }else{
                return $this->responseWithSuccess('Visit History Loaded', $visit_history, 200);
            }  
        } catch (\Exception $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }


    public function createVisit(Request $request)
    {
         return $this->visit->createNewVisit($request);  
    }
    public function updateVisit(Request $request)
    {
        try {
            return $this->visit->updateVisit($request);     
        } catch (\Exception $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }

    public function getVisitById($id)
    {
        try {

            $visit = $this->visit->visitDetails($id);
            $visit = new VisitCollection($visit);
            return $visit;
        } catch (\Exception $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }
    public function uploadImage(Request $request)
    {
        try {
            $image = $this->visit->uploadVisitImage($request);
            $file_path = uploaded_asset($image->file_id);
            return $this->responseWithSuccess('Image Uploaded Successfully', $file_path, 200);
           
        } catch (\Exception $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        } 
    }

    public function visitImages($id)
    {
        try {
            $visit = $this->visit->getVisitById($id);
            $visit = new VisitImageCollection($visit);

            return $this->responseWithSuccess('Visit Images Loaded Successfully', [$visit], 200);
          
        } catch (\Exception $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }

    public function removeVisitImage($visit_id,$image_id)
    {
        try {
            $visit = $this->visit->removeVisitImage($visit_id,$image_id);

            return $this->responseWithSuccess('Image Deleted Successfully', [], 200);
           
        } catch (\Exception $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }

    public function createNote(Request $request)
    {
        try {
            $note = $this->visit->createNote($request);
            return $this->responseWithSuccess('Note Created Successfully', [], 200);
           
        } catch (\Exception $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }

    public function createSchedule(Request $request)
    {
        try {
            
            $visit = $this->visitSchedule->createNewSchedule($request);

            return $this->responseWithSuccess('Schedule Created Successfully', [], 200);
           
        } catch (\Exception $exception) {

            return $this->responseWithError($exception->getMessage(), [], 500);
        }

    }

    public function changeVisitStatus(Request $request)
    {
        try {
            return  $this->visit->changeVisitStatus($request);
        } catch (\Exception $exception) {
            return $this->responseWithError($exception->getMessage(),[], 500);
        }
    }
}
