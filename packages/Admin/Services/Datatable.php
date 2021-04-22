<?php


namespace Admin\Services;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Str;

class Datatable
{

    public function __construct()
    {

    }

    public function get($query)
    {

        /**
         * @var Builder $query
         */
        $generalSearch = request('generalSearch');
        $perPage = request('pagination.per_page') ?? 10;
        $sortField = request('sort.column') ?? "id";
        $sortDirection = request('sort.asc') ? "desc" : "asc";

        $model = $query->getModel();

        $translated = (new $model())->translatedAttributes;
        $searchable = (new $model())->searchable;




        if ($model && $generalSearch && $searchable)
            foreach ($searchable as $i => $fieldName) {
                if ($i == 0) {
                    if($translated && in_array($fieldName, $translated)) {
                        $query = $query->whereTranslationLike($fieldName, "%$generalSearch%");
                    } else
                        $query = $query->where($fieldName, "LIKE", "%$generalSearch%");
                }
                else {
                    if($translated && in_array($fieldName, $translated)) {
                        $query = $query->orWhereTranslationLike($fieldName, "%$generalSearch%");
                    } else
                    $query = $query->orWhere($fieldName, "LIKE", "%$generalSearch%");
                }

            }

        if($translated && in_array($sortField, $translated)) {
            $query = $query->orderByTranslation($sortField, $sortDirection);
        } else
            $query = $query->orderBy($sortField, $sortDirection);

        return $query->paginate($perPage);
    }
}
