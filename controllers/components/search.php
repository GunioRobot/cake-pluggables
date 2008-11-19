<?php
class SearchComponent // extends Object
{
	var $components = array('Session');
    const MK_MUST_HAVE = 0; 
    const MK_MAY_HAVE = 1; 

    const MATCH_EXACTLY = 0;
    const MATCH_ENDS_WITH = 1;
    const MATCH_STARTS_WITH = 2;
    const MATCH_ANYWHERE = 3;

    public function __construct()
    {
        $this->search_settings = array(
            'multiple_keywords' => self::MK_MAY_HAVE,
            'match_type' => self::MATCH_ANYWHERE 
        );
        $this->options = array(
   					'conditions' => array(),
   					'recursive' => 0,
                );
    }

    public $options = array();
    public $multiple_keywords = array();

	function setup($controller, $search = null, $fields = 'name'){
		$name = $controller->name;
		$opt = array('conditions' => array());
        if (isset($search[$name]['keywords'])) {
            $keywords = $search[$name]['keywords'];
            $this->Session->write("Search.$name.keywords", $search[$name]['keywords']);
        }
  
		if ($this->Session->check("Search.$name.keywords")) {
            $key = $this->Session->read("Search.$name.keywords"); 
            $opt = $this->options($controller, $key, $fields);
        }
        return $opt['conditions'];
	}

    function options(&$model, $keywords, $search_fields, $options = array(), $search_settings = array())
    {
        // @todo remove
        App::import('sanitize');
        
        //replace zenkaku space with hankaku space, remove trailing spaces
        $keywords = str_replace("　", " ", $keywords);
        $keywords = preg_replace('/\s+$/', '', $keywords);

        $conditions = "(";
        // $modelName = $model->name;
        $keywords = split(' ', $keywords);
        $search_fields = split(' ', $search_fields);
        $this->inject($this->search_settings, $search_settings);
        $this->inject($this->options, $options);

        foreach ($keywords as $ck => $keyword) {
            foreach ($search_fields as $cf => $field) {

                $keyword = Sanitize::escape($keyword);
            	if ($cf <> 0) {
                    $conditions .= " OR ";
                }
				
                switch ($this->search_settings['match_type']) {

                case self::MATCH_EXACTLY:
                    $conditions .= "$field = '$keyword'";
                    break;

                case self::MATCH_STARTS_WITH:
                    $conditions .= "$field LIKE '%$keyword'";
                    break;

                case self::MATCH_ENDS_WITH:
                    $conditions .= "$field LIKE '$keyword%'";
                    break;

                case self::MATCH_ANYWHERE:
                    $conditions .= "$field LIKE '%$keyword%'";
                    break;
                }
            }

            if ($ck < count($keywords) -1) {
                switch ($this->search_settings['multiple_keywords']) {

                case self::MK_MAY_HAVE:
                    $conditions .= ") OR (";
                    break;

                case self::MK_MUST_HAVE:
                    $conditions .= ") AND (";
                    break;
                }
            } else {
                $conditions .= ')';
            }
        }

        $options['conditions'] = $conditions;
        return $options;
    }

    public function inject($source, &$destination)
    {
        foreach ($source as $key => $value) {
            $destination[$key] = $value;
        }
    }
}

?>
