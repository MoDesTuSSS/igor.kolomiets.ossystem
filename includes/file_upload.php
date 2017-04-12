<?php
class FileUpload{

    public $file = "";

    public $arrayTypes = array("xml","csv","json","yml");

    public function convertToJson($name, $tmp_name){
        if(in_array(end(explode(".", $name)), $this->arrayTypes)){
            $fileName = $name;
            $fileContent = file_get_contents($tmp_name);
            switch(end(explode(".", $name))){
                case $this->arrayTypes[0]:
                    $array = json_encode(simplexml_load_file($tmp_name));
                    break;
                case $this->arrayTypes[1]:
                    $tempArray = array_map("str_getcsv",  file($tmp_name));
                    foreach(array_slice($tempArray, 1) as $index => $temp){
                        foreach($temp as $key => $value){
                            $array[$index][$tempArray[0][$key]] = $value;
                        }
                    }
                    $array = json_encode($array);
                    break;
                case $this->arrayTypes[2]:
                    $array = $fileContent;
                    break;
                case $this->arrayTypes[3]:
                    $data = spyc_load($fileContent);
                    $array = json_encode($data);
                    break;
            }
            return $array;
        }else{
            return false;
        }
    }
    public function getJsonInMyFormat($json, $type){
        switch($type){
            case $this->arrayTypes[0]:
                return $this->generateXml(json_decode($json, true));
                break;
            case $this->arrayTypes[1]:
                return $this->generateCsv(json_decode($json, true));
                break;
            case $this->arrayTypes[2]:
                return $json;
            case $this->arrayTypes[3]:
                return spyc_dump(json_decode($json));
                break;
        }
    }
    public function toFile($json, $name){
        $file = "/result/".uniqid().".".end(explode(".", $name));
        file_put_contents($_SERVER["DOCUMENT_ROOT"].$file, $json);
        $jsonReturn['file'] = $_SERVER["HTTP_ORIGIN"].$file;
        return json_encode($jsonReturn);
    }

    function generateXml($array){
        $xml = new SimpleXMLElement('<result/>');
        $this->array_to_xml($array,$xml);
        return $xml->asXML();
    }

    function array_to_xml( $data, &$xml_data ) {
        foreach( $data as $key => $value ) {
            if( is_numeric($key) ){
                $key = 'item'.$key; //dealing with <0/>..<n/> issues
            }
            if( is_array($value) ) {
                $subnode = $xml_data->addChild($key);
                $this->array_to_xml($value, $subnode);
            } else {
                $xml_data->addChild("$key",htmlspecialchars("$value"));
            }
        }
    }

    function generateCsv($array){
        $str = "";
        foreach($array as $key => $value){
            if(array_keys($array) !== range(0, count($array) - 1)){
                $str .= $key.": ";
            }
            if(is_array($value)){
                $value = $this->generateCsv($value);
                $str .= PHP_EOL;
            }
            if(array_keys($array) !== range(0, count($array) - 1)){
                $str .= $value.PHP_EOL;
            }else{
                $str .= $value.", ";
            }
        }
        return $str;
    }
}