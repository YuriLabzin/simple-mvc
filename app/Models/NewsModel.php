<?php


namespace Models;


use Core\Model;

/**
 * Class NewsModel
 * @package Models
 */
class NewsModel extends Model
{
    /**
     * @var array Параметры выборки новостей по умолчанию
     */
    private $arParams = [
        'count' => 10,
        'offset' => 0,
        'orderBy' => 'idate',
        'sort' => 'DESC'
    ];

    /**
     * Возвращает записи из базы данных
     * @param array $arParams Массив с параметрами выборки записей <br/>
     * Доступные поля:<br/>
     * <b>id</b> - идентификатор записи<br/>
     * <b>count</b> - количество выбираемых записей<br/>
     * <b>offset</b> - запись, начиная с которой начинается выборка<br/>
     * <b>orderBy</b> - поле сортировки выборки записей<br/>
     * <b>sort</b> - направление сортировки<br/>
     * @return array Сформированный массив записей
     */
    public function get($arParams = [])
    {
        $arParams = array_merge($this->arParams, $arParams);
        $where = '';

        if (isset($arParams['id']) && $arParams['id'] > 0) {
            $where = "WHERE id = '{$arParams['id']}'";
        }

        $objNews = $this->dbh->query("SELECT * FROM news {$where} ORDER BY {$arParams['orderBy']} {$arParams['sort']} LIMIT {$arParams['offset']}, {$arParams['count']}");
        $arResult = [];

        foreach ($objNews as $news) {
            $arResult[] = [
                'id' => $news['id'],
                'name' => htmlspecialchars_decode($news['title']),
                'date' => date('d.m.Y', $news['idate']),
                'previewText' => htmlspecialchars_decode($news['announce']),
                'detailText' => htmlspecialchars_decode($news['content']),
            ];
        }

        return $arResult;
    }

    /**
     * Возвращает общее количество нвоостей в базе данных
     * @return int
     */
    public function count()
    {
        return (int)$this->dbh->query("SELECT COUNT(*) as count FROM news")->fetchColumn();
    }

}
