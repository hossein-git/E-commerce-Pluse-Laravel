<?php

namespace App\Repositories;

use App\Models\GiftCard;
use App\Repositories\BaseRepository;

/**
 * Class GiftCardRepository
 * @package App\Repositories
 * @version January 24, 2020, 4:35 pm +0330
 */
class GiftCardRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'gift_name',
        'gift_code',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return GiftCard::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function createGiftCard($request)
    {
        $input = $this->getCheckBox($request);
        $input['gift_code'] = strtolower($input['gift_code']);
        return $this->create($input);
    }

    /**
     * @param $request
     * @param $id
     * @return GiftCard
     */
    public function updateGiftCard($request, $id) :GiftCard
    {
        $input = $this->getCheckBox($request);
        $input['gift_code'] = strtolower($input['gift_code']);
        $gift = $this->update($input, $id);
        return $gift;
    }

    /**
     * @param $request
     * @return array
     */
    private function getCheckBox($request): array
    {
        $input = $request->except('token');
        if (!$request->ajax()){
            $request->has('status') ? $input['status'] = 1 :$input['status'] = 0;
        }

        return $input;

    }


}
