<?php

    class Form {

        public static $class = 'form-control';

    //----------------------------------------------------------------------------
    //-----------------------METHODE : GENERATEUR SELECT--------------------------
    //----------------------------------------------------------------------------
        /**
         * @param string $name
         * @param array $options
         * @return string
         */
        public static function select(string $name, array $options) {

            $htmlOptions = [];
            $attributes = ' class="'.self::$class.'"';

            foreach ($options as $key => $option) {

                $htmlOptions[] = '<option value="'.$key.'">'.$option.'</option>';
            }
            return '<select'.$attributes.' name="'.$name.'">'.implode($htmlOptions).'</select>';
        }

        //----------------------------------------------------------------------------
        //--------------------------- METHODE : GENERATEUR LABEL----------------------
        //----------------------------------------------------------------------------
        /**
         * @param string $for
         * @param string $content
         * @return string
         */
        public static function label(string $for, string $content) {
            return '<label class="mt-2" for="'.$for.'">'.$content.'</label>';
        }

        //----------------------------------------------------------------------------
        //--------------------------- METHODE : GENERATEUR INPUT ---------------------
        //----------------------------------------------------------------------------

        /**
         * Undocumented function
         * @param string $type
         * @param string $name
         * @param string $id
         * @param string $placeholder
         * @param string $checked
         * @return string
         */
        public static function input(string $type, string $name, string $id, string $placeholder = null) {

            return '<input class="form-control" type="'.$type.'" name="'.$name.'" id="'.$id.'" placeholder="'.$placeholder.'"/>';
        }
        
        //----------------------------------------------------------------------------
        //--------------------------- METHODE : GENERATEUR SUBMIT --------------------
        //----------------------------------------------------------------------------

        /**
         * Undocumented function
         * @param [type] $value
         * @return string
         */
        public static function submit($value, $id) {
            return '<input class="btn-input" type="submit" id="'.$id.'" value="'.$value.'"/>';
        }

        //----------------------------------------------------------------------------
        //--------------------------- METHODE : GENERATEUR RADIO --------------------
        //----------------------------------------------------------------------------
        
        /**
         * Undocumented function
         * @param [type] $value
         * @return string
         */
        public static function radio(string $id, string $name, string $value, string $checked = null){
            return '<input type="radio" id="'.$id.'" name="'.$name.'" value="'.$value.'"'.$checked.'/>';
        }
    }

