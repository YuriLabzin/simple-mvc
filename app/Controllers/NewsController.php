<?php


namespace Controllers;


use Core\Controller;
use Core\Route;
use Models\NewsModel;

/**
 * Class NewsController
 * @package Controllers
 */
class NewsController extends Controller
{
    private $itemsCountInPage = 10;

    public function __construct()
    {
        parent::__construct();
        $this->model = new NewsModel();
    }

    /**
     * Выводит список новостей
     * @param int $currentPage - номер страницы с новостями
     */
    function index($currentPage = 1)
    {
        $itemsCountInPage = $this->itemsCountInPage;
        $sort = 'DESC';

        if (isset($_GET['page']) && $_GET['page'] >= 0) {
            $currentPage = $_GET['page'];
        }

        if (isset($_GET['sort']) && in_array(strtoupper($_GET['sort']), ['ASC', 'DESC'])) {
            $sort = $_GET['sort'];
        }

        $offset = ($currentPage - 1) * $itemsCountInPage;
        $arNews = $this->model->get([
            'count' => $itemsCountInPage,
            'offset' => $offset,
            'sort' => $sort
        ]);
        $allNewsCount = $this->model->count();
        $getParams = '';

        if ($_SERVER['argv']) {
            $getParams = '?';

            foreach ($_SERVER['argv'] as $getParam) {
                $getParams .= '&' . $getParam;
            }
        }

        $arResult = [
            'items' => $arNews,
            'allItemsCount' => $allNewsCount,
            'itemsCountInPage' => $itemsCountInPage,
            'pagesCount' => ceil($allNewsCount / $itemsCountInPage),
            'currentPage' => $currentPage,
            'sort' => $sort,
            'getParams' => $getParams
        ];

        $this->view('news.twig', ['arResult' => $arResult]);
    }

    /**
     * Выводит список новостей конкретной страницы
     * @param $pageNumber - номер страницы, список новостей которой выводится
     */
    public function page($pageNumber)
    {
        $allNewsCount = $this->model->count();
        $pagesCount = ceil($allNewsCount / $this->itemsCountInPage);

        if ($pageNumber && $pageNumber > 0 && $pageNumber <= $pagesCount) {
            $this->index($pageNumber);
        } else Route::Error404();
    }

    /**
     * Выводит детальную страницу новости
     * @param $newsID - ID выводимой страницы
     */
    public function detail($newsID)
    {
        if (isset($newsID) && $newsID > 0) {
            $news = $this->model->get(['id' => $newsID]);
            $this->view('news-detail.twig', ['arResult' => $news['0']]);
        } else Route::Error404();
    }
}
