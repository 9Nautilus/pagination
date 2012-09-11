<?php
/************************************
 | Class name  : Pagination.inc.php |
 | Last Modify : Sep 2012           |
 | By          : Narong Rammanee    |
 | E-mail      : ranarong@live.com  |
 ************************************/

class Pagination
{
    /**
     * Previous page constant
     * @var string
     */
    const PREV = '&lsaquo; ก่อนหน้า';

    /**
     * First page constant
     * @var string
     */
    const FIRST = '&laquo; หน้าแรก';

    /**
     * Next page constant
     * @var string
     */
    const NEXT = 'ถัดไป &rsaquo;';

    /**
     * Last page constant
     * @var string
     */
    const LAST = 'หน้าสุดท้าย &raquo;';

    /**
     * All page
     * @var interger
     */
    public $totalPage;

    /**
     * SQL offset
     * @var interger
     */
    public $offset;

    /**
     * URL page
     * @var unknown_type
     */
    private $link;

    /**
     * All row of data
     * @var integer
     */
    private $records;

    /**
     * Current page
     * @var interger
     */
    private $curPage;

    /**
     * Per page
     * @var integer
     */
    private $perPage;

    /**
     * Scroll page
     * @var integer
     */
    private $scroll = 5;

    /**
     * Initialization
     * @param string link
     * @param integer records
     * @param integer curPage
     * @param integer perPage
     */
    public function __construct($link=null, $records=null, $curPage=null, $perPage=null)
    {
        self::setPager($link, $records, $curPage, $perPage);
    }

    /**
     * Set pager
     * 
     * @param $link
     * @param $records
     * @param $curPage
     * @param $perPage
     * @return No value is returned.
     */
    public function setPager($link, $records, $curPage, $perPage)
    {
        $this->link      = $link;
        $this->records   = $records;
        $this->perPage   = $perPage;
        $this->totalPage = ($records) ? ceil($records / $perPage) : 0;
        $this->curPage   = $curPage = (!is_numeric($curPage)) ? 1 : $curPage;
        $this->offset    = ($this->totalPage <= 1) ? 0 : ($curPage - 1) * $perPage;
    }

    /**
     * Get pager
     * 
     * @return No value is returned.
     */
    public function render()
    {
        $html  = '<div class="pagination">';
        $html .= '<ul>';
        $html .= '<li><span class="allpage">ทั้งหมด ' . $this->totalPage . ' หน้า &nbsp;</span><li>';
        $html .= self::firstPage();
        $html .= self::previousPage();
        $html .= self::renderPager();
        $html .= self::nextPage();
        $html .= self::lastPage();
        $html .= '</ul>';
        $html .= '</div>';

        return $html;
    }

    /**
     * First page link
     * @return HTML first page link
     */
    private function firstPage()
    {
        if ($this->totalPage > 1 && $this->curPage > 1) {
            return '<li><a href="' . $this->link . '1">' . self::FIRST . '</a></li>';
        }
    }

    /**
     * Previous page link
     * @return HTML previous page link
     */
    private function previousPage()
    {
        if ($this->totalPage > 1 && $this->curPage > 1) {
            return '<li><a href="' . $this->link . ($this->curPage - 1) . '">' . self::PREV . '</a></li>';
        }
    }

    /**
     * Render pagination
     * @return HTML rander pagination
     */
    private function renderPager()
    {
        if($this->totalPage <= $this->scroll) {
            if($this->records <= $this->perPage) {
                $startPage = 1;
                $stopPage  = $this->totalPage;
            } else {
                $startPage = 1;
                $stopPage  = $this->totalPage;
            }
        } else {
            if($this->curPage < intval($this->scroll / 2) + 1) {
                $startPage = 1; 
                $stopPage  = $this->scroll;
            } else {
                $startPage = $this->curPage - intval($this->scroll / 2);
                $stopPage  = $this->curPage + intval($this->scroll / 2);
                if($stopPage > $this->totalPage) {
                    $stopPage = $this->totalPage;
                }
            }
        }

        if ($this->totalPage > 1) {
            for ($i = $startPage; $i <= $stopPage; $i++) {
                if ($i == $this->curPage) {
                    $html .= '<li><span class="current_page">' . $i . '</span></li>';
                } else {
                    $html .= '<li><a href="'.$this->link.$i.'">' . $i . '</a></li>';
                }
            }
        }

        return $html;
    }

    /**
     * Next page link
     * @return HTML next page link
     */
    private function nextPage()
    {
        if ($this->curPage < $this->totalPage) {
            return '<a href="' . $this->link . ($this->curPage + 1) . '">' . self::NEXT . '</a>';
        }
    }

    /**
     * Last page link
     * @return HTML last page link
     */
    private function lastPage()
    {
        if ($this->curPage < $this->totalPage) {
            return '<a href="' . $this->link . $this->totalPage . '">' . self::LAST . '</a>';
        }
    }
}
