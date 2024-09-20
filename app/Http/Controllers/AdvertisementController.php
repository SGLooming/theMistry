<?php

namespace App\Http\Controllers;

use App\Repositories\EServiceRepository;
use App\DataTables\AdvertisementDataTable;
use App\Http\Requests\AdvertisementRequest;
use App\Models\Advertisement;
use App\Models\AdvertisementService;
use Flash;
use Illuminate\Http\Request;
use App\Repositories\UploadRepository;
use Exception;

class AdvertisementController extends Controller
{

    /**
     * @var UploadRepository
     */
    private $uploadRepository;
    /** @var  EServiceRepository */
    private $eServiceRepository;

    public function __construct(EServiceRepository $eServiceRepo, UploadRepository $uploadRepo)
    {
        parent::__construct();
        $this->eServiceRepository = $eServiceRepo;
        $this->uploadRepository = $uploadRepo;
    }
    /**
     * Display a listing of the Category.
     *
     * @param CategoryDataTable $categoryDataTable
     * @return Response
     */
    public function index(AdvertisementDataTable $categoryDataTable)
    {
        return $categoryDataTable->render('advertisement.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = $this->eServiceRepository->pluck('name', 'id');

        return view('advertisement.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',

            'description' => 'required',
        ]);

        $input = $request->all();

        $advertisement = Advertisement::create($input);

        if (isset($input['image']) && $input['image']) {
            if ($input['image'] != null) {
                $cacheUpload = $this->uploadRepository->getByUuid($input['image']);
                $mediaItem = $cacheUpload->getMedia('image')->first();
                if ($mediaItem != null) {
                    $mediaItem->copy($advertisement, 'image');
                }
            }
        }
        if (is_array($request->services) && isset($request->services)) {

            foreach ($request->services  as $service) {

                $advertisement_service = new AdvertisementService;

                $advertisement_service->ad_id = $advertisement->id;

                $advertisement_service->service_id = $service;

                $advertisement_service->save();
            }
        }
        Flash::success(__('lang.created_successfully', ['operator' => __('Advertisement')]));
        return redirect(route('advertisement.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $advertisement = Advertisement::find($id);

        $service_of_ads = AdvertisementService::where('ad_id', $id)->pluck('service_id')->toArray();

        $services = $this->eServiceRepository->pluck('name', 'id');

        return view('advertisement.edit', compact('advertisement', 'service_of_ads', 'services'));
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
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $input = $request->all();

        $advertisement = Advertisement::find($id);
        $advertisement->update($input);

        if (isset($input['image']) && $input['image']) {

            if ($input['image'] != null) {

                $cacheUpload = $this->uploadRepository->getByUuid($input['image']);

                $mediaItem = $cacheUpload->getMedia('image')->first();

                if ($mediaItem != null) {

                    $mediaItem->copy($advertisement, 'image');
                }
            }
        }

        AdvertisementService::where('ad_id', $id)->delete();

        if (is_array($request->services) && isset($request->services)) {

            foreach ($request->services  as $service) {

                $advertisement_service = new AdvertisementService;

                $advertisement_service->ad_id = $advertisement->id;

                $advertisement_service->service_id = $service;

                $advertisement_service->save();
            }
        }
        Flash::success(__('lang.updated_successfully', ['operator' => __('Advertisement')]));
        return redirect(route('advertisement.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $advertisement = Advertisement::find($id);
        if($advertisement){
            $advertisement->delete();
            AdvertisementService::where('ad_id',$id)->delete();
            Flash::success('Advertisement is deleted.');
        }else{
            Flash::success('Something went wrong.');
        }
        return back();
    }


    /**
     * Remove Media of advertisement
     * @param Request $request
     */
    public function removeMedia(Request $request)
    {
        $input = $request->all();
        $advertisement = Advertisement::find($input['id']);
        try {
            if ($advertisement->hasMedia($input['collection'])) {
                $advertisement->getFirstMedia($input['collection'])->delete();
            }
        } catch (Exception $e) {
            \Log::error($e->getMessage());
        }
    }
}
