<?php

class formulaire
{


    private $values;

    public function __construct($data = array())
    {
        $this->values = $data;
    }

    private function getValue($key)
    {
        return $this->values[$key] ?? "";
    }

    public function inputText($name, $label = '', $IsRequired = TRUE)
    {
        if ($IsRequired) return "<div><label><span></span><input type='text'  name = '" . $name . "' value='" . $this->getValue($name) . "' placeholder='" . $label . "'required> </label></div>";
        else return "<div><label><span></span><input type='text'  name = '" . $name . "' value='" . $this->getValue($name) . "' placeholder='" . $label . "'> </label></div>";
    }

    public function inputMail($name, $label = '')
    {
        return "<div><label><span></span><input type='email'  name = '" . $name . "' value='" . $this->getValue($name) . "' placeholder='" . $label . "'required> </label></div>";
    }

    public function inputPassword($name, $label = '', $IsRequired = TRUE)
    {
        if ($IsRequired) return "<div><label><span></span><input type='password'  name = '" . $name . "' value='" . $this->getValue($name) . "' placeholder='" . $label . "' required> </label></div>";
        else return "<div><label><span></span><input type='password'  name = '" . $name . "' value='" . $this->getValue($name) . "' placeholder='" . $label . "'> </label></div>";
    }


    public function inputNum($name, $label = '', $IsRequired = TRUE)
    {
        if ($IsRequired) return "<div><label><span></span><input type='number'  name = '" . $name . "' value='" . $this->getValue($name) . "' placeholder='" . $label . "' required> </label></div>";
        else return "<div><label><span></span><input type='number'  name = '" . $name . "' value='" . $this->getValue($name) . "' placeholder='" . $label . "'> </label></div>";
    }

    public function inputTel($name, $label = '', $IsRequired = TRUE)
    {
        if ($IsRequired) return "<div><label><span></span><input type='tel'  name = '" . $name . "' value='" . $this->getValue($name) . "' placeholder='" . $label . "' required> </label></div>";
        else return "<div><label><span></span><input type='tel'  name = '" . $name . "' value='" . $this->getValue($name) . "' placeholder='" . $label . "'> </label></div>";
    }

    public function inputLatitude($name, $label = '')
    {
        return "<div><label><span></span><input type='number'  name = '" . $name . "' value='" . $this->getValue($name) . "' placeholder='" . $label . "' min='-90' max='90' step='0.000001' required> </label></div>";
    }

    public function inputLongitude($name, $label = '')
    {
        return "<div><label><span></span><input type='number'  name = '" . $name . "' value='" . $this->getValue($name) . "' placeholder='" . $label . "' min='-180' max='180' step='0.000001' required> </label></div>";
    }

    public function inputTime($name, $label = '')
    {
        return "<div><label><span></span><input type='time'  name = '" . $name . "' value='" . $this->getValue($name) . "' placeholder='" . $label . "' step='60' required> </label></div>";
    }

    public function inputHidden($name, $label = '')
    {
        return "<div><label><span></span><input type='hidden'  name = '" . $name . "' value='" . $this->getValue($name) . "' placeholder='" . $label . "' required> </label></div>";
    }

    public function inputTextArea($name, $label = '')
    {
        return "<div><label><span></span><textarea name ='" . $name . "' rows='5' cols='33' placeholder='" . $label . "' required>" . $this->getValue($name) . "</textarea></label></div>";
    }

    public function inputRadio($name, $options = array(), $label = '')
    {
        $html = "<div><span class='label' id='$name'>" . $label . "</span><br>";
        foreach ($options as $value => $text) {
            $html .= "<label><input type='radio' name='" . $name . "' value='" . $value . "'";
            if ($this->getValue($name) == $value) {
                $html .= " checked"; // Vérifie si cette option est sélectionnée
            }
            $html .= "> " . $text . "</label><br>";
        }
        $html .= "</div>";
        return $html;
    }
    public function inputSelect($name, $options = array(), $label = '', $class = '')
    {
        $html = "<div><label for='$name' id='$name'>$label</label><br>";
        $html .= "<select name='$name' required class='$class'>";
        foreach ($options as $value => $text) {
            $html .= "<option value='$value'";
            if ($this->getValue($name) == $value) {
                $html .= " selected"; // Sélectionne si cette option est sélectionnée
            }
            $html .= ">" . $text . "</option>";
        }
        $html .= "</select></div>";
        return $html;
    }

    public function inputCheckbox($name, $options = array(), $label = '')
    {
        $html = "<div><span class='label' id='$name'>" . $label . "</span><br>";
        foreach ($options as $value => $text) {
            $html .= "<label><input type='checkbox' name='" . $name . "[]' value='" . $value . "'";
            if (is_array($this->getValue($name)) && in_array($value, $this->getValue($name))) {
                $html .= " checked"; // Vérifie si cette option est sélectionnée
            }
            $html .= "> " . $text . "</label><br>";
        }
        $html .= "</div>";
        return $html;
    }


    public function inputFilePhoto($name,$nameid, $label = '', $imagePaths = array(), $accept = 'image/jpeg, image/png, image/webp', $multiple = false, $IsRequired = TRUE)
    {
        $input = "<div class='name_file_inp'><label for='$name'><span id='$nameid'>$label</span><br>";
        $input .= "<input type='file' class='texte' name='$name' accept='$accept'";
        if ($multiple) {
            $input .= " multiple";
        }
        if ($IsRequired) $input .= " required";
        $input .= " onchange='previewImages(event, \"$name\")'></label>";

        // Display existing images
        if (!empty($imagePaths)) {
            $input .= "<div class='existing-images'>";
            foreach ($imagePaths as $path) {
                $input .= "<img src='$path' class='existing-image'>";
            }
            $input .= "</div>";
        }

        $input .= "<div id='preview-container-$name' class='preview-container'></div></div>";
        return $input;
    }



    public function submit($name, $texte)
    {
        return "<button  name='" . $name . "' class='submit'><span class='texte11'>" . $texte . " </span></button>";
    }

    public function submit2($name, $texte)
    {
        return "<button  name='" . $name . "' class='submit'><span class='texte11del'>" . $texte . " </span></button>";
    }

    public function submit3($name, $texte)
    {
        return "<button  name='" . $name . "' class='submit'><span class='texte113'>" . $texte . " </span></button>";
    }

    public function select_subject_mail($name, $label = '')
    {
        $select = "<div class='custom-select'><label for='mail_subject'><span></span>";
        $select .= "<select name='" . $name . "' id='select_subject'><option class='texte8' value=''> -- Please select an object -- </option>";
        $select .= '<option class="select1" value="in-vino-veritas">Question about In Vino Veritas</option>
                    <option class="select2" value = "in-cantata-vinum">Question about In Cantata Vinum</option>
                    <option class="select3" value ="buch-der-7-siegel">Question about Buch der 7 Siegel</option>
                    <option class="select4" value ="fluch-der-9-linden">Question about Fluch der 9 Linden</option>
                    <option class="select5" value ="Kaiserstuhl">Question about Kaiserstuhl</option>';
        $select .= "</select></label></div>";
        return $select;
    }


    public function select_price_gift($name, $label = '')
    {
        $select = "<div class='custom-select'><label for='select_price'><span></span>";
        $select .= "<select name='" . $name . "' id='select_price'>";
        $select .= '<option class="select1" value="25">25 €</option>
                    <option class="select2" value = "50">50 €</option>
                    <option class="select3" value ="75">75 €</option>
                    <option class="select4" value ="100">100 €</option>
                    <option class="select5" value ="150">150 €</option>';
        $select .= "</select></label></div>";
        return $select;
    }

    public function select_price_gift_box($name, $label = '')
    {
        $select = "<div class='custom-select'><label for='select_price'><span></span>";
        $select .= "<select name='" . $name . "' id='select_price'>";
        $select .= '<option class="select1" value="25">25 €</option>
                    <option class="select2" value = "50">50 €</option>
                    <option class="select3" value ="75">75 €</option>
                    <option class="select4" value ="100">100 €</option>
                    <option class="select5" value ="150">150 €</option>
                    <option class="select6" value="200">200 €</option>
                    <option class="select7" value="250">250 €</option>
                    <option class="select8" value="300">300 €</option>';
        $select .= "</select></label></div>";
        return $select;
    }
}
