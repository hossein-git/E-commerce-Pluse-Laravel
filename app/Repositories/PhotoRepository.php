<?php

namespace App\Repositories;

use App\Models\Photo;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\File;

/**
 * Class PhotoRepository
 * @package App\Repositories
 * @version January 24, 2020, 4:35 pm +0330
*/

class PhotoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'photo_title',
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
        return Photo::class;
    }

    /**
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function destroy($id) : bool
    {
        $photo = $this->find($id);
        $photo_path = public_path(env("IMAGE_PATH",'images\\') . $photo->addr);
        //THUMBNAIL PATH of photo
        $T_path = public_path(env("THUMBNAIL_PATH",'thumbnails\\') . "T" . $photo->addr);
        if (File::exists($T_path)) {
            unlink($T_path);
        }
        if (File::exists($photo_path)) {
            unlink($photo_path);
        }
        return  $photo->delete();
    }
}
