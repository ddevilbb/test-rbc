<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\NewsRepositoryInterface;
use App\Services\ImportNewsServiceOld;
use Illuminate\Http\Request;

class DefaultController extends Controller
{
    /**
     * @var NewsRepositoryInterface
     */
    private $newsRepository;

    /**
     * @var int
     */
    private $perPage;

    public function __construct(NewsRepositoryInterface $newsRepository)
    {
        $this->newsRepository = $newsRepository;
        $this->perPage = 4;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('default.index', [
            'news' => $this->newsRepository->findAll($this->perPage)
        ]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(Request $request, int $id)
    {
        return view('default.view', [
            'news' => $this->newsRepository->findById($id)
        ]);
    }
}
