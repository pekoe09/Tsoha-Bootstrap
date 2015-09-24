<?php

  class BaseModel{
    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null){
      // Käydään assosiaatiolistan avaimet läpi
      foreach($attributes as $attribute => $value){
        // Jos avaimen niminen attribuutti on olemassa...
        if(property_exists($this, $attribute)){
          // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
          $this->{$attribute} = $value;
        }
      }
    }

    public function errors(){
      // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
      $errors = array();

      foreach($this->validators as $validator){
        // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
          $issues = $this->{$validator}();
          $errors = array_merge($errors, $issues);
      }

      return $errors;
    }
    
    public function validate_string_length($item_name, $string, $min_length, $max_length, $is_optional){
        $issues = array();
        
        if(($string == null || $string == '') && ($min_length > 0 || !$is_optional)){
            $issues[] = $item_name . ' ei saa olla tyhjä.';
        }
        elseif($min_length != null && strlen($string) < $min_length){
            $issues[] = $item_name . ': pituuden oltava vähintään ' . $min_length . 'merkkiä.';
        }
        elseif($max_length != null && strlen($string) > $max_length){
            $issues[] = $item_name  .':  pituus saa olla enintään '  . $max_length . 'merkkiä.';
        }
        
        return $issues;
    }
    
    public function validate_date($item_name, $date, $min_date, $max_date, $is_optional){
        $issues = array();
        
        if($date == null && !$is_optional){
            $issues[] = $item_name .' ei saa olla tyhjä.';            
        }
        elseif($date != null){
            if($min_date != null && $date < $min_date){
                $issues[] = $item_name . ': ei saa olla ennen ' . $min_date . '.';
            }
            elseif($max_date != null && $date > $max_date){
                $issues[] = $item_name . ': ei saa olla ' . $max_date  . ' jälkeen.';
            }
        }
        return $issues;
    }
    
    public function validate_number($item_name, $number, $min_value, $max_value,  $is_selection, $is_optional){
        $issues = array();
        
        if($number == null && !$is_optional){
            if($is_selection)
                $issues[] = $item_name . ' on valittava.';
            else
                $issues[] = $item_name . ' ei saa olla tyhjä.';
        }
        elseif($number != null){
            if($min_value != null && $number  <  $min_value){
                $issues[] = $item_name . ': arvon oltava vähintään ' . $min_value . '.';
            }
            elseif ($max_value  != null && $number > $max_value) {
                $issues[]  = $item_name . ': arvon oltava enintään ' . $max_value . '.';
            }
        }
        
        return $issues;
    }
    
    public function validate_time($item_name, $time, $min_value, $max_value, $is_optional){
        $issues = array();
        // toteutettava
        return $issues;
    }
    
    public function validate_email($item_name, $email, $is_optional){
        $issues = array();
        
        return $issues;
    }
    
    public function validate_password($item_name, $password){
        $issues = array();
        
        return $issues;
    }
  }
