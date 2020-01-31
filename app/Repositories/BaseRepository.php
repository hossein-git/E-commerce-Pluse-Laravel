<?php

namespace App\Repositories;

use Facade\FlareClient\Http\Response;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Laracasts\Flash\Flash;


abstract class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @param Application $app
     *
     * @throws \Exception
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Get searchable fields array
     *
     * @return array
     */
    abstract public function getFieldsSearchable();

    /**
     * Configure the Model
     *
     * @return string
     */
    abstract public function model();

    /**
     * Make Model instance
     *
     * @return Model
     * @throws \Exception
     *
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * Paginate records for scaffold.
     *
     * @param int $perPage
     * @param array $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage, $columns = ['*'])
    {
        $query = $this->allQuery();

        return $query->paginate($perPage, $columns);
    }

    /**
     * Build a query for retrieving all records.
     *
     * @param array $search
     * @param int|null $skip
     * @param int|null $limit
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function allQuery($search = [], $skip = null, $limit = null)
    {
        $query = $this->model->newQuery();

        if (count($search)) {
            foreach ($search as $key => $value) {
                if (in_array($key, $this->getFieldsSearchable())) {
                    $query->where($key, $value);
                }
            }
        }

        if (!is_null($skip)) {
            $query->skip($skip);
        }

        if (!is_null($limit)) {
            $query->limit($limit);
        }

        return $query;
    }

    /**
     * Retrieve all records with given filter criteria
     *
     * @param array $search
     * @param int|null $skip
     * @param int|null $limit
     * @param array $columns
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all($search = [], $skip = null, $limit = null, $columns = ['*'])
    {
        $query = $this->allQuery($search, $skip, $limit);

        return $query->get($columns);
    }

    /**
     * Create model record
     *
     * @param array $input
     *
     * @return Model
     */
    public function create($input)
    {
        $model = $this->model->newInstance($input);

        $model->save();

        return $model;
    }

    /**
     * Find model record for given id
     *
     * @param int $id
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function find($id, $columns = ['*'])
    {
        $this->checkId($id);

        $query = $this->model->newQuery();

        return $query->findOrFail($id, $columns);
    }

    /**
     * Update model record for given id
     *
     * @param array $input
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model
     */
    public function update($input, $id)
    {
        $this->checkId($id);

        $query = $this->model->newQuery();

        $model = $query->findOrFail($id);

        $model->fill($input);

        $model->save();

        return $model;
    }

    /**
     * @param int $id
     *
     * @return bool|mixed|null
     * @throws \Exception
     *
     */
    public function delete($id)
    {
        $this->checkId($id);

        $query = $this->model->newQuery();

        $model = $query->findOrFail($id);

        return $model->delete();
    }

    /**
     * check input id
     * @param $id
     * @return JsonResponse
     */
    public function checkId($id)
    {
        if (!is_int($id)) {
            return response()->json(['success' => 'false', 'message' => __('notValidId')], 404);
        }
    }

    /**
     *  pass response after update model
     * @param $result
     * @param $modelLangKey
     * @param $redirectRoute
     * @return RedirectResponse
     */
    public function passViewAfterUpdated($result, string $modelLangKey, string $redirectRoute)
    {
        if ($result) {
            if (env('APP_AJAX')) {
                return response()->json([
                    'success' => true,
                    'message' => __("models/$modelLangKey.singular") . ' ' . __('messages.edited')
                ], 200);
            }

            Flash::success(__("models/$modelLangKey.singular") . ' ' . __('messages.edited'));
            return redirect()->route($redirectRoute);
        }

        if (env('APP_AJAX')) {
            return response()->json([
                'success' => false,
                'message' => __("models/$modelLangKey.singular") . ' ' . __('messages.editedFailed')
            ], 501);
        }
        Flash::error(__("models/$modelLangKey.singular") . ' ' . __('messages.editedFailed'));
        return redirect()->route($redirectRoute);
    }

    /**
     * @param $model
     * @param string $modelLangKey
     * @param string $route
     * @return JsonResponse|RedirectResponse
     */
    public function passViewAfterCreated($model, string $modelLangKey, string $route)
    {
        if (env('APP_AJAX')) {
            return response()->json([
                'success' => true,
                'message' => __("models/$modelLangKey.singular") . ' ' . __('messages.saved')
            ], 200);
        }
        Flash::success(__("models/$modelLangKey.singular") . ' ' . __('messages.saved'));
        return redirect()->route($route);
    }

    /**
     * @param bool $result
     * @param string $modelLangKey
     * @return response
     */
    public function passViewAfterDeleted(bool $result, string $modelLangKey)
    {
        return $result
            ? response()->json([
                'success' => true,
                'message' => __("models/$modelLangKey.singular") . ' ' . __('messages.deleted')],
                202)
            : response()->json([
                'success' => false,
                'message' => __("models/$modelLangKey.singular") . ' ' . __('messages.deletedFailed')],
                500);

    }

    /**
     * @param bool $result
     * @param string $modelLangKey
     * @param string $messageKey
     * @return response
     */
    public function passResponse(bool $result, string $modelLangKey, string $messageKey)
    {
        return $result
            ? response()->json([
                'success' => true,
                'message' => __("models/$modelLangKey.singular") . ' ' . __("messages.$messageKey")],
                200)
            : response()->json([
                'success' => false,
                'message' => __("models/$modelLangKey.singular") . ' ' . __("messages.$messageKey" . "Failed")],
                500);
    }


}
