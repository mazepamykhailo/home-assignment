<?php

namespace App\Repositories\record;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Record;


/**
 * Class CategoryRepository.
 */
class RecordRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Record::class;
    }
}
