<?php
/*
 * File name: FavoriteController.php
 * Last modified: 2021.01.22 at 22:19:22
 * Copyright (c) 2021
 */

namespace App\Http\Controllers;

use App\DataTables\FavoriteDataTable;
use App\Http\Requests\CreateFavoriteRequest;
use App\Http\Requests\UpdateFavoriteRequest;
use App\Repositories\CustomFieldRepository;
use App\Repositories\EServiceRepository;
use App\Repositories\FavoriteRepository;
use App\Repositories\OptionRepository;
use App\Repositories\UserRepository;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class FavoriteController extends Controller
{
    /** @var  FavoriteRepository */
    private $favoriteRepository;

    /**
     * @var CustomFieldRepository
     */
    private $customFieldRepository;

    /**
     * @var EServiceRepository
     */
    private $eServiceRepository;
    /**
     * @var OptionRepository
     */
    private $optionRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(FavoriteRepository $favoriteRepo, CustomFieldRepository $customFieldRepo, EServiceRepository $eServiceRepo
        , OptionRepository $optionRepo
        , UserRepository $userRepo)
    {
        parent::__construct();
        $this->favoriteRepository = $favoriteRepo;
        $this->customFieldRepository = $customFieldRepo;
        $this->eServiceRepository = $eServiceRepo;
        $this->optionRepository = $optionRepo;
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the Favorite.
     *
     * @param FavoriteDataTable $favoriteDataTable
     * @return Response
     */
    public function index(FavoriteDataTable $favoriteDataTable)
    {
        return $favoriteDataTable->render('favorites.index');
    }

    /**
     * Show the form for creating a new Favorite.
     *
     * @return Response
     */
    public function create()
    {
        $eService = $this->eServiceRepository->pluck('name', 'id');
        $option = $this->optionRepository->pluck('name', 'id');
        $user = $this->userRepository->pluck('name', 'id');
        $optionsSelected = [];
        $hasCustomField = in_array($this->favoriteRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->favoriteRepository->model());
            $html = generateCustomField($customFields);
        }
        return view('favorites.create')->with("customFields", isset($html) ? $html : false)->with("eService", $eService)->with("option", $option)->with("optionsSelected", $optionsSelected)->with("user", $user);
    }

    /**
     * Store a newly created Favorite in storage.
     *
     * @param CreateFavoriteRequest $request
     *
     * @return Response
     */
    public function store(CreateFavoriteRequest $request)
    {
        $input = $request->all();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->favoriteRepository->model());
        try {
            $favorite = $this->favoriteRepository->create($input);
            $favorite->customFieldsValues()->createMany(getCustomFieldsValues($customFields, $request));

        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.saved_successfully', ['operator' => __('lang.favorite')]));

        return redirect(route('favorites.index'));
    }

    /**
     * Display the specified Favorite.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $favorite = $this->favoriteRepository->findWithoutFail($id);

        if (empty($favorite)) {
            Flash::error('Favorite not found');

            return redirect(route('favorites.index'));
        }

        return view('favorites.show')->with('favorite', $favorite);
    }

    /**
     * Show the form for editing the specified Favorite.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $favorite = $this->favoriteRepository->findWithoutFail($id);
        $eService = $this->eServiceRepository->pluck('name', 'id');
        $option = $this->optionRepository->pluck('name', 'id');
        $user = $this->userRepository->pluck('name', 'id');
        $optionsSelected = $favorite->options()->pluck('options.id')->toArray();

        if (empty($favorite)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.favorite')]));

            return redirect(route('favorites.index'));
        }
        $customFieldsValues = $favorite->customFieldsValues()->with('customField')->get();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->favoriteRepository->model());
        $hasCustomField = in_array($this->favoriteRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $html = generateCustomField($customFields, $customFieldsValues);
        }

        return view('favorites.edit')->with('favorite', $favorite)->with("customFields", isset($html) ? $html : false)->with("eService", $eService)->with("option", $option)->with("optionsSelected", $optionsSelected)->with("user", $user);
    }

    /**
     * Update the specified Favorite in storage.
     *
     * @param int $id
     * @param UpdateFavoriteRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFavoriteRequest $request)
    {
        $favorite = $this->favoriteRepository->findWithoutFail($id);

        if (empty($favorite)) {
            Flash::error('Favorite not found');
            return redirect(route('favorites.index'));
        }
        $input = $request->all();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->favoriteRepository->model());
        try {
            $favorite = $this->favoriteRepository->update($input, $id);
            $input['options'] = isset($input['options']) ? $input['options'] : [];

            foreach (getCustomFieldsValues($customFields, $request) as $value) {
                $favorite->customFieldsValues()
                    ->updateOrCreate(['custom_field_id' => $value['custom_field_id']], $value);
            }
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.updated_successfully', ['operator' => __('lang.favorite')]));

        return redirect(route('favorites.index'));
    }

    /**
     * Remove the specified Favorite from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $favorite = $this->favoriteRepository->findWithoutFail($id);

        if (empty($favorite)) {
            Flash::error('Favorite not found');

            return redirect(route('favorites.index'));
        }

        $this->favoriteRepository->delete($id);

        Flash::success(__('lang.deleted_successfully', ['operator' => __('lang.favorite')]));

        return redirect(route('favorites.index'));
    }

    /**
     * Remove Media of Favorite
     * @param Request $request
     */
    public function removeMedia(Request $request)
    {
        $input = $request->all();
        $favorite = $this->favoriteRepository->findWithoutFail($input['id']);
        try {
            if ($favorite->hasMedia($input['collection'])) {
                $favorite->getFirstMedia($input['collection'])->delete();
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
