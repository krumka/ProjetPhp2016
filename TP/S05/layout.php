<?php //Auth. : Rémy Lambinet
    class Layout{
        public $title = "Pas de titre";
        public $linkCss = array("style.css");
        public $body;

        function display(){
            $head = "<!-- Rémy Lambinet -->\n<!DOCTYPE html>\n<html>\n\t<head>\n\t\t<meta charset=\"utf-8\">";
            $head .= "\n\t\t<meta author=\"Rémy Lambinet\">";
            $head .= "\n\t\t<title>".$this->title."</title>";
            foreach($this->linkCss as $css) {
                $head .= "\n\t\t<link href=\"" . $css . "\" rel=\"stylesheet\" type=\"text/css\">";
            }
            $head .= "\n\t</head>";
            echo $head;
            $body = "\t<body>";
            $body .= "\n\t\t".$this->body;
            $body .= "\n\t</body>";
            $body .= "\n</html>";
            echo $body;
        }
        function addCss($css){
            array_push($this->linkCss, $css);
        }
    }
    class Tableau{
        public $list;
        public $title;
        public $head = false;
        public $id;
        private $nbCols;
        private $css = "css/tab.css";

        function __construct($list, $title, $head, $nbCols){
            $this->list = $list;
            $this->title = $title;
            $this->head = $head;
            $this->nbCols = $nbCols;
        }
        function getCss(){
            return $this->css;
        }
        function html(){
            $html = "<table>";
            if(isset($title)){
                $html .= "\n\t<caption>".$this->title."</caption>";
            }
            if($this->head){
                $html .= "\n\t<thead>";
                $html .= "\n\t\t<tr>";
                foreach($this->list[0] as $th){
                    $html .= "\n\t\t\t<th>".$th."</th>";
                }
                $html .= "\n\t\t</tr>";
                $html .= "\n\t</thead>";
            }
            $html .= "\n\t<tbody>";
            foreach($this->list as $line){
                if(!$this->head){
                    $html .= "<tr>";
                    foreach($line as $col){
                        $html .= "<td>".$col."</td>";
                    }
                    $html .= "</tr>";
                }
                $this->head = false;
            }
            $html .= "\n\t</tbody>";
            $html .= "\n</table>";
            return $html;
        }
    }

    class Form{
        public $action;
        public $method = "get";
        public $name;
        public $id;
        public $onSubmit;
        public $submit="Envoyer";
        public $elementsTab = [];
        public $legend;
        public $fieldSet = false;
        public $reset;
        public $css = "css/form.css";

        function __construct($action, $method, $name, $id, $onSubmit, $submit){
            $this->action = $action;
            if (isset($method)) {
                $this->method = $method;
            }
            $this->name = $name;
            $this->id = $id;
            $this->onSubmit = $onSubmit;
            $this->submit = $submit;
        }
        function addLegend($txt){
            $this->fieldSet = true;
            $this->legend = "<legend>".$txt."</legend>";
        }
        function addTxt($elem){
            array_push($this->elementsTab, $elem);
        }
        function addItem($type, $id, $name, $label, $maxLength, $minLength, $height, $size, $placeHolder, $onChange, $required, $autoFocus, $disabled, $add){
            $txt = "<p id=\"".$id."\">";
            $txt .= "\n\t<label for=\"".$name."\">".$label."</label>";
            $txt .= "\n\t<input type=\"".$type."\" ";
            $txt .= "id=\"".$name."\" name=\"".$name."\" ";
            if(isset($maxLength)){
                $txt .= "maxlength=".$maxLength." ";
            }
            if(isset($minLength)){
                $txt .= "minlength=".$minLength." ";
            }
            if(isset($height)){
                $txt .= "height=".$height." ";
            }
            if(isset($size)){
                $txt .= "size=".$size." ";
            }
            if(isset($placeHolder)){
                $txt .= "placeholder=".$placeHolder." ";
            }
            if(isset($onChange)){
                $txt .= "onChange=\"".$onChange."\" ";
            }
            if(isset($required)){
                $txt .= "required ";
            }
            if(isset($autoFocus)){
                $txt .= "autofocus ";
            }
            if(isset($disabled)){
                $txt .= "disabled ";
            }
            if(isset($add)){
                $txt .= $add." ";
            }
            $txt .= ">";
            $txt .= "\n</p>";
            array_push($this->elementsTab, $txt);
        }
        function addTxtArea($name, $cols, $rows, $placeHolder, $maxLength, $required, $autoFocus, $disabled){
            $txt = "<textarea name=\"".$name."\" id=\"".$name."\" cols=\"".$cols."\" rows=\"".$rows."\" ";
            if(isset($placeHolder)){
                $txt .= "placeholder=\"".$placeHolder."\" ";
            }
            if(isset($maxLength)){
                $txt .= "maxlength=\"".$maxLength."\" ";
            }
            if(isset($required)){
                $txt .= "required ";
            }
            if(isset($autoFocus)){
                $txt .= "autofocus ";
            }
            if(isset($disabled)){
                $txt .= "disabled ";
            }
            $txt .= ">";
            array_push($this->elementsTab, $txt);
        }
        function addCheckBox($name, $prop, $check, $add){
            $txt = "<input type=\"checkbox\" name=\"".$name."\" id=\"".$name."\" ";
            if($check){
                $txt .= "checked ";
            }
            if(isset($add)){
                $txt .= $add." ";
            }
            $txt .= "/> \n<label for=\"".$name."\">".$prop."</label>\n<br />";
            array_push($this->elementsTab, $txt);
        }
        function addRadio($id, $name, $question, $list){ //liste avec pour chaque checkbox : value et texte de la proposition
            $txt = "<p id=\"".$id."\">\n";
            $txt .= $question."<br />";
            foreach($list as $item){
                $txt .= "\n<input type=\"radio\" name=\"".$name."\" value=\"".$item[0]."\" id=\"".$item[0]."\" /> <label for=\"".$item[0]."\">".$item[1]."</label><br />";
            }
            $txt .= "\n</p>";
            array_push($this->elementsTab, $txt);
        }
        function addList($id, $name, $list, $onChange, $selected){ //liste avec pour chaque prop : value et texte de la proposition
            $txt = "<p id=\"".$id."\">";
            if(isset($question)){
                $txt .= "\n\t<label for=\"".$name."\">".$question."</label>\n<br />";
            }
            $txt .= "\n\t<select name=\"".$name."\" id=\"".$name."\" ";
            if(isset($onChange)){
                $txt .= "onchange=\"".$onChange."\" ";
            }
            $txt .= ">";
            foreach($list as $item){
                $txt .= "\n\t\t<option value=\"".$item[0]."\" ";
                if(isset($selected)){
                    if($selected == $item[0]){
                        $txt .= "selected ";
                    }
                }
                $txt .= ">".$item[1]."</option>";
            }
            $txt .= "\n\t</select>\n</p>";
            array_push($this->elementsTab, $txt);
        }
        function addReset($txt){
            $this->reset = $txt;
        }
        function html(){
            $html = "<form id=\"".$this->id."\" name=\"".$this->name."\" method=\"".$this->method."\" action=\"".$this->action."\" onSubmit=\"".$this->onSubmit."\">";
            $html .= "\n\t";
            if($this->fieldSet){
                $html .= "<fieldset>";
                $html .= $this->legend;
            }
            foreach ($this->elementsTab as $item){
                $html .= "\n\t".$item;
            }
            if(isset($this->submit)){
                $html .= "<input type=submit value=\"".$this->submit."\">";
            }
            if(isset($this->reset)){
                $html .= "<input type=reset value=\"".$this->reset."\">";
            }
            if($this->fieldSet) {
                $html .= "\n\t</fieldset>";
            }
            $html .= "\n</form>";
            return $html;
        }
    }
?>