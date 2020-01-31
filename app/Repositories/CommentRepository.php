<?php

namespace App\Repositories;

use App\Models\Photo;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\File;
use Laravelista\Comments\Comment;

/**
 * Class PhotoRepository
 * @package App\Repositories
 * @version January 24, 2020, 4:35 pm +0330
*/

class CommentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'comment',
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
        return Comment::class;
    }

}
