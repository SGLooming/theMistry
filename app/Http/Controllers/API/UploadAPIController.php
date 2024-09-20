<?php
/*
 * File name: UploadAPIController.php
 * Last modified: 2021.12.21 at 20:43:47
 * Copyright (c) 2022
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadRequest;
use App\Repositories\UploadRepository;
use Exception;
use Prettus\Validator\Exceptions\ValidatorException;

class UploadAPIController extends Controller
{
    private $uploadRepository;

    /**
     * UploadController constructor.
     * @param UploadRepository $uploadRepository
     */
    public function __construct(UploadRepository $uploadRepository)
    {
        parent::__construct();
        $this->uploadRepository = $uploadRepository;
    }

    /**
     * @param UploadRequest $request
     */
    public function store(UploadRequest $request)
    {
        $input = $request->all();
        if (($key = array_search("Address Proof", $input)) !== false) {
            unset($input[$key]);
            $input['field'] = "address_proof";
        }
        if (($key = array_search("Id Proof", $input)) !== false) {
            unset($input[$key]);
            $input['field'] = "id_proof";
        }
        try {
            $upload = $this->uploadRepository->create($input);
            $upload->addMedia($input['file'])
                ->withCustomProperties(['uuid' => $input['uuid'], 'user_id' => auth()->id()])
                ->toMediaCollection($input['field']);
            return $this->sendResponse($input['uuid'], "Uploaded Successfully");
        } catch (ValidatorException $e) {
            \Log::info('Error');
            \Log::info($e);
            return $this->sendError(false, $e->getMessage());
        }
    }

    /**
     * clear cache from Upload table
     */
    public function clear(UploadRequest $request)
    {
        $input = $request->all();
        if (!isset($input['uuid'])) {
            return $this->sendResponse(false, 'Media not found');
        }
        try {
            if (is_array($input['uuid'])) {
                $result = $this->uploadRepository->clearWhereIn($input['uuid']);
            } else {
                $result = $this->uploadRepository->clear($input['uuid']);
            }
            return $this->sendResponse($result, 'Media deleted successfully');
        } catch (Exception $e) {
            return $this->sendResponse(false, 'Error when delete media');
        }

    }
}
