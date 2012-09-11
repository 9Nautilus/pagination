<?php
/************************************
 | Class name  : Table.inc.php      |
 | Last Modify : Sep 2012           |
 | By          : Narong Rammanee    |
 | E-mail      : ranarong@live.com  |
 ************************************/

class Table
{
    /**
     * HTML Table Tag Attributes
     * @var string
     */
    private $attributes;

    /**
     * HTML Table Tag caption.
     * @var string
     */
    private $caption;

    /**
     * Table header array contain title and css.
     * @var array
     */
    private $header = array();

    /**
     * HTML Table Tag footer.
     * @var string
     */
    private $footer = array();

    /**
     * Table data array
     * @var array
     */
    private $data = array();

    /**
     * Constructor
     * Initialization that the object may need before it is used.
     *  
     * @param $attributes
     * @param $header
     * @param $data
     * @param $highlight
     * @param $caption
     * @return No value is returned.
     */
    public function __construct( $attributes, $header, &$data, $caption=null, $footer=null) 
    {
        self::setTable($attributes, $header, $data, $caption ,$footer);
    }

    /**
     * Set table
     * 
     * @param $attributes
     * @param $header
     * @param $data
     * @param $highlight
     * @param $caption
     * @return No value is returned. 
     */
    public function setTable( $attributes, $header, &$data, $caption=null, $footer=null)
    {
        $this->attributes = $attributes;
        $this->header     = $header;
        $this->data       = $data;
        $this->caption    = $caption;
        $this->footer     = $footer;
    }

    /**
     * Create table
     *
     * @return HTML table.
     */
    public function render( )
    {
        $html  = '<table ' . $this->attributes . '>';
        $html .= '<caption>' . $this->caption . '</caption>';
        $html .= '<thead>' . self::setTableHeader() . '</thead>';		
        $html .= '<tbody>' . self::setTableData() . '</tbody>';
        $html .= '<tfoot>' . self::setTableFooter() . '</tfoot>';
        $html .= '</table>';

        return $html;
    }

    /**
     * Set table header
     * 
     * @return HTML Table header.
     */
    private function setTableHeader( )
    {
        $html = '<tr>';
        if (!empty($this->header)) {
            foreach ($this->header as $value) 
                $html .= '<th ' . $value[0] . '>' . $value[1] . '</th>';
        } else {
            throw new Exception(
                '<pre class="warning"><h1>Header not found:</h1> Header is NULL.</pre>'
            );
        }

        $html .= '</tr>';

        return $html;
    }

    /**
     * Set table header
     * 
     * @return HTML Table header.
     */
    private function setTableFooter()
    {
            $html = '<tr>';
            if (!is_null($this->footer)) {
                foreach ($this->footer as $value) {
                    $html .= '<th ' . $value[0] . '>' . $value[1] . '</th>';
                }
            }

            $html .= '</tr>';

            return $html;
    }

    /**
     * Set table data
     * 
     * @return HTML Table data
     */
    private function setTableData()
    {
        $html = '';
        if ($this->data) {

            foreach ($this->data as $key=>$rows) {
                $html .= '<tr>';

                foreach ($rows as $columns) {
                    if(is_array($columns)) {
                        $html .= '<td ' . $columns[0] . '>' . $columns[1] . '</td>';
                    } else  {
                        $html .= '<td>' . $columns . '</td>';
                    }
                }

                $html .= '</tr>';
            }

        } else {
            throw new Exception(
                '<pre class="warning"><h1>Data not found:</h1> Data is NULL.</pre>'
            );
        }

        return $html;
    }
}