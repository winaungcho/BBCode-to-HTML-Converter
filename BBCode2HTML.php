<?php
/**
 * BBCode2HTML Class
 *
 * This class is free for the educational use as long as maintain this header together with this class.
 * Author: Win Aung Cho
 * Contact winaungcho@gmail.com
 * version 1.0 10-12-2022
 * Date: 10-12-2022
 */
class BBCode2HTML
{
	private $pattern = "/\[([\w]+)([^\]]*?)(([\s]*\/\])|" . "(\]((([^\[]*?|\[\!\-\-.*?\-\-\])|(?R))*)\[\/\\1[\s]*\]))/sm";
    private $attrpattern = '~(\w+)=([a-zA-Z0-9-\.\/\"\'\:\#]+)~';
    private $limitattr = false;
    
    public function __construct()
    {
        $this->validtag = array(
            "font",
            "div",
            "p",
            "ol",
            "ul",
            "li",
            "pre",
            "code",
            "img",
            "table",
            "tbody",
            "caption",
            "tr",
            "th",
            "td",
            "span",
            "s",
            "u",
            "i",
            "b",
            "em",
            "strong",
            "sub",
            "sup",
            "a",
            "h1",
            "h2",
            "h3",
            "h4",
            "h5",
            "h6",
            "br",
            "hr"
        );
        $this->attrname = array(
            "h" => "height",
            "w" => "width",
            "s" => "size",
            "a" => "align",
            "n" => "name",
            "f" => "float",
            "fa" => "face",
            "ref" => "href",
            "sr" => "src",
            "st" => "style",
            "rspan" => "rowspan",
            "cspan" => "colspan",
            "b" => "border",
            "bg" => "bgcolor",
            "c" => "color",
            "wg" => "weight"
        );
    }
    public function limitAttribute($l)
    {
    	$this->limitattr = $l;
    }
    public function parse($post)
    {
        preg_match_all($this->pattern, $post, $matches, PREG_OFFSET_CAPTURE);
        $elements = array();
        foreach ($matches[0] as $key => $match) {
            $attrib = array();
            if (isset($matches[2][$key][0])) {
                preg_match_all($this->attrpattern, $matches[2][$key][0], $atts);
                for ($j = 0;$j < count($atts);$j++) {
                    if (!empty($atts[1][$j])) $attrib[$atts[1][$j]] = $atts[2][$j];
                }
            }
            $elements[] = array(
                'search' => $match[0],
                'offset' => $match[1],
                'tag' => $matches[1][$key][0],
                'attributes' => $attrib,
                'omittag' => ($matches[4][$key][1] > - 1) , // boolean
                'content' => isset($matches[6][$key][0]) ? $this->parse($matches[6][$key][0]) : ''
            );
        }
        return $this->tagreplace($post, $elements);
    }

    private function tagreplace($post, $datas)
    {
        if (count($datas) > 0) {
            foreach ($datas as $data) {
                $tag = $data["tag"];
                $attr = "";
                foreach ($data['attributes'] as $key => $value) {
                    if (!empty($key)) {
                    	$name = "";
                        if (array_key_exists($key, $this->attrname)) $name = $this->attrname[$key];
                        else if (!$this->limitattr) $name = $key;
                        if (!empty($name))
                        	$attr .= $name . "=" . $value . " ";
                    }
                }
                switch ($tag) {
                    case "img":
                    	if (!$data["omittag"]){
                        	$newData = "<$tag src='" . $data['content'] . "' $attr/>";
                    		break;
                    	}

                    default:
                        if (in_array($tag, $this->validtag)) {
                            if ($data["omittag"]) $newData = "<$tag" . (empty($attr) ? "" : " " . $attr) . "/>";
                            else $newData = "<$tag" . (empty($attr) ? "" : " " . $attr) . ">" . $data['content'] . "</$tag>";
                        }
                        break;
                    }
                    $search = $data['search'];
                    $replace = $newData;
                    $post = str_replace($search, $replace, $post);
                }
        }
        return $post;
    }
}
?>
