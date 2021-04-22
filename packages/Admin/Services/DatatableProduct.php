<?php


namespace Admin\Services;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Str;

class DatatableProduct
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



//        if ($generalSearch) {
//            $query = $query->whereHas('variations', function (\Illuminate\Database\Eloquent\Builder $query) use ($generalSearch) {
//                return $query->where('title', 'LIKE', '%' . $generalSearch . '%')
//                    ->orWhere('sku', 'LIKE', '%' . $generalSearch . '%');
//            })
//                ->orwhereTranslationLike('title', "%" . $generalSearch . "%");
//        }

        if($translated && in_array($sortField, $translated)) {
            $query = $query->orderByTranslation($sortField, $sortDirection);
        } else
            $query = $query->orderBy($sortField, $sortDirection);

        return $query->paginate($perPage);
    }
}
